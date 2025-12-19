<?php

class LogoutController extends BaseController {

    public function process_responce() {
        $_SESSION['is_logged'] = false;
        unset($_SESSION['user']);

        header("Location: /login");
        exit;
    }
}
