<?php

class BaseController {
	protected function render(string $view, array $data = []): void {
		extract($data);
		require_once BASE_PATH . '/src/Views/layouts/header.php';
		$viewFile = BASE_PATH . '/src/Views/' . $view . '.php';
		if (file_exists($viewFile)) {
			require_once $viewFile;
		} else {
			echo "View không tồn tại: $view";
		}
		require_once BASE_PATH . '/src/Views/layouts/footer.php';
	}

	protected function redirect(string $url): void {
		header("Location: /webdev/public/" . $url);
		exit();
	}

    protected function isLoggedIn(): bool {
        return isset($_SESSION['user_id']);
    }

    protected function isAdmin(): bool {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

	protected function requireLogin(): void {
		if (!$this->isLoggedIn()) {
			$this->redirect('');
		}
	}
	
	protected function requireAdmin(): void {
		if (!$this->isAdmin()) {
			$this->redirect('');
		}
	}
	
	protected function renderAdmin(string $view, array $data = []): void {
		extract($data);
		// Load jQuery TRƯỚC
		echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>';
		echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>';
		require_once BASE_PATH . '/src/Views/admin/layout.php';
		require_once BASE_PATH . '/src/Views/' . $view . '.php';
		echo '</div></div>';
		echo '</body></html>';
	}
}