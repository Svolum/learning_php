<?php

class LoginController extends TwigBaseController {

    public $template = "login.twig";

    public function get(array $context) {
        parent::get($context);
    }

    public function post(array $context) {

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($username === '' || $password === '') {
            $context['error'] = 'Введите логин и пароль';
            parent::get($context);
            return;
        }

        $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'password' => $password
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $context['error'] = 'Неверный логин или пароль';
            parent::get($context);
            return;
        }

        // логиним
        $_SESSION['is_logged'] = true;
        $_SESSION['user'] = $user['username'];

        header("Location: /");
        exit;
    }
}
