<?php

class LoginRequiredMidleware extends BaseMiddleware {

    public function apply(BaseController $controller, array $context) {

        $username = $_SERVER['PHP_AUTH_USER'] ?? '';
        $password = $_SERVER['PHP_AUTH_PW'] ?? '';

        if ($username === '' || $password === '') {
            $this->unauthorized();
        }

        // получаем PDO из контроллера
        $pdo = $controller->pdo;

        $sql = "SELECT password_hash FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue('username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // if (!$user || !password_verify($password, $user['password_hash'])) {
        //     $this->unauthorized();
        // }
        if (!$user || $user['password_hash'] !== $password) {
            $this->unauthorized();
        }
    }

    private function unauthorized() {
        header('WWW-Authenticate: Basic realm="Protected area"');
        http_response_code(401);
        echo 'Требуется авторизация';
        exit;
    }
}
