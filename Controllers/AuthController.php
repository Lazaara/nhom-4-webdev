<?php

require_once BASE_PATH . '/src/Core/BaseController.php';
require_once BASE_PATH . '/src/Models/UserModel.php';

class AuthController extends BaseController {

    private UserModel $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // POST /auth/login
    public function login(): void {
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);
        $email    = trim($data['email'] ?? '');
        $password = trim($data['password'] ?? '');

        if (!$email || !$password) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin.']);
            return;
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            echo json_encode(['success' => false, 'message' => 'Email hoặc mật khẩu không đúng.']);
            return;
        }

        // Lấy role
        $role = $this->userModel->getRoleByUserId($user['id']);

        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_role'] = $role;

        echo json_encode(['success' => true]);
    }

    // POST /auth/register
    public function register(): void {
        header('Content-Type: application/json');

        $data     = json_decode(file_get_contents('php://input'), true);
        $name     = trim($data['name'] ?? '');
        $email    = trim($data['email'] ?? '');
        $password = trim($data['password'] ?? '');

        if (!$name || !$email || !$password) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin.']);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Email không hợp lệ.']);
            return;
        }

        if (strlen($password) < 6) {
            echo json_encode(['success' => false, 'message' => 'Mật khẩu phải có ít nhất 6 ký tự.']);
            return;
        }

        if ($this->userModel->findByEmail($email)) {
            echo json_encode(['success' => false, 'message' => 'Email đã được sử dụng.']);
            return;
        }

        $hash   = password_hash($password, PASSWORD_BCRYPT);
        $userId = $this->userModel->create($name, $email, $hash);

        // Gán role customer
        $this->userModel->assignRole($userId, 2);

        // Auto login sau khi đăng ký
        $_SESSION['user_id']   = $userId;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_role'] = 'customer';

        echo json_encode(['success' => true]);
    }

    // GET /auth/logout
    public function logout(): void {
        session_destroy();
        header('Location: /webdev/public/');
        exit();
    }
}