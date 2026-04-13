<?php

class Router {
	public function dispatch(): void {
		$url = $_GET['url'] ?? 'home';
		$url = trim($url, '/');
		$parts = explode('/', $url);

		$controllerName = ucfirst($parts[0] ?? 'home') . 'Controller';
		
		// Đổi kebab-case thành camelCase (order-detail → orderDetail)
		$methodRaw = $parts[1] ?? 'index';
		$method = lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $methodRaw))));
		
		$param = $parts[2] ?? null;

		$controllerFile = BASE_PATH . '/src/Controllers/' . $controllerName . '.php';

		if (file_exists($controllerFile)) {
			require_once $controllerFile;
			$controller = new $controllerName();
			if (method_exists($controller, $method)) {
				$controller->$method($param);
			} else {
				$this->notFound();
			}
		} else {
			$this->notFound();
		}
	}

    private function notFound(): void {
        http_response_code(404);
        echo "404 - Trang không tồn tại";
    }
}