<?php

require_once BASE_PATH . '/src/Core/BaseController.php';

class PageController extends BaseController {

    public function faq(): void {
        $this->render('page/faq', [
            'pageTitle' => 'FAQ - NanoTech',
        ]);
    }

    public function about(): void {
        $this->render('page/about', [
            'pageTitle' => 'Về chúng tôi - NanoTech',
        ]);
    }
}