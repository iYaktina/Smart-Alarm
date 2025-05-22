<?php
require_once __DIR__ . '/../Model/User.php';

class UserController {
    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function loginForm() {
        require_once __DIR__ . '/../View/login.php';
    }

    public function registerForm() {
        require_once __DIR__ . '/../View/register.php';
    }

    public function login() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->login($email, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: index.php');
            } else {
                $_SESSION['error'] = "Invalid credentials.";
                header('Location: login.php');
            }
        }
    }

    public function register() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $success = $this->userModel->register($name, $email, $password);
            $_SESSION['message'] = $success ? "Registered successfully!" : "Registration failed!";
            header('Location: login.php');
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: login.php');
    }
}
