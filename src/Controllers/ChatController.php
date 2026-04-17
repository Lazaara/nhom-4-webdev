<?php

require_once BASE_PATH . '/src/Core/BaseController.php';
require_once BASE_PATH . '/src/Models/ProductModel.php';

class ChatController extends BaseController {

    private ProductModel $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    // POST /chat/ask
    public function ask(): void {
        header('Content-Type: application/json');

        $data    = json_decode(file_get_contents('php://input'), true);
        $message = trim($data['message'] ?? '');

        if (!$message) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập câu hỏi.']);
            return;
        }

        $products    = $this->productModel->getAll(20, 0);
        $productList = array_map(fn($p) =>
            "- {$p['name']} | Giá: " . number_format($p['price'], 0, ',', '.') . "đ | ID: {$p['id']}",
        $products);
        $productText = implode("\n", $productList);

        $apiKey   = 'KEY';
        $response = $this->callGroq($apiKey, $message, $productText);

        echo json_encode(['success' => true, 'reply' => $response]);
    }

    private function callGroq(string $apiKey, string $userMessage, string $productList): string {
        $systemPrompt = "Bạn là trợ lý tư vấn mua sắm của NanoTech - cửa hàng công nghệ. 
    Nhiệm vụ của bạn là gợi ý sản phẩm phù hợp dựa trên nhu cầu của khách hàng.
    Chỉ gợi ý sản phẩm từ danh sách sau, đừng bịa thêm sản phẩm:

    $productList

    Trả lời ngắn gọn, thân thiện bằng tiếng Việt. Khi gợi ý sản phẩm hãy đề cập tên và giá.";

        $payload = json_encode([
            'model'    => 'llama-3.1-8b-instant',
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user',   'content' => $userMessage],
            ],
            'max_tokens'  => 500,
            'temperature' => 0.7,
        ]);

        $ch = curl_init('https://api.groq.com/openai/v1/chat/completions');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey,
            ],
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);

        if (isset($data['error'])) {
            return 'Lỗi: ' . $data['error']['message'];
        }

        return $data['choices'][0]['message']['content'] 
            ?? 'Xin lỗi, tôi không thể trả lời lúc này.';
    }
}