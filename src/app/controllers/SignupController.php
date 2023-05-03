<?php

use Phalcon\Mvc\Controller;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use MyApp\Locale;


class SignupController extends Controller
{

    public function IndexAction()
    {
        // defalut action
        // eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzAwMDAwMCwicm9sZSI6ImFkbWluIn0.8MDNXPtnvoo_LFMiE05cdqX59ACR8HuvB7TMm9pRAKQ

    }

    public function registerAction()
    {
        $user = new Users();

        $data = array(
            "name" => $this->escaper->escapeHtml($this->request->getPost("name")),
            "email" => $this->escaper->escapeHtml($this->request->getPost("email")),
            "password" => $this->escaper->escapeHtml($this->request->getPost("password")),
            'role' => $this->request->getPost('role')
        );


        $user->assign(
            $data,
            [
                'name',
                'email',
                'password',
                'role',

            ]
        );
        $success = $user->save();

        $key = '123456789';

        $payload = [
            'role' => $data['role']
        ];
        $jwt = JWT::encode($payload, $key, 'HS256');
        $this->response->redirect('/product/index?bearer=' . $jwt);
        $this->view->success = $success;
        if ($success) {
            $this->view->message = "Register succesfully";
        } else {
            $this->view->message = "Not Register due to following reason: <br>" . implode("<br>", $user->getMessages());
        }
    }
}
