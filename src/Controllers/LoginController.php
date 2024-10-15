<?php

namespace App\Controllers;

use App\Models\User;

class LoginController extends BaseController {

    public function showLoginForm() {

        $template = 'login-form';
        $output = $this->render($template);
        return $output;
    }

    public function login() {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = new User();
        $save_result = $user->getPassword($username)->password_hash;

        if (password_verify($password, $save_result)) {

            session_start();
            $user_id = session_id();

            $_SESSION['is_logged_in'] = TRUE;
            $_SESSION['user_id'] = $user_id;
            
            $data_result = $user->getData();

            $data = [
                'title' => 'Suppliers',
                'data' => $data_result
            ];

            return $this->render('welcome', $data);
    }
}
}