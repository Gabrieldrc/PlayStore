<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
use Phalcon\Http\Request;

class RegisterController extends Controller
{    
    public function signupAction()
    {
        $data = [];
        $data['user_name'] = $this->request->getPost('user_name');
        $data['password'] = $this->request->getPost('password');
        $response = new Response();
        $contents = [
            'data' => $data,
        ];

        $response->setStatusCode(200, 'ok');
        $response->setJsonContent($contents);
        $response->send();
    }
}
