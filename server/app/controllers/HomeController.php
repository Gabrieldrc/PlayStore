<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
use Phalcon\Http\Request;

class HomeController extends Controller
{    
    public function homeAction()
    {
        $response = new Response();
        $contents = [
            'invoice' => [
                'id'    => 12345,
                'name'  => 'invoice.pdf',
                'date'  => '2019-01-01 01:02:03',
                'owner' => 'admin',
            ]   
        ];

        $response
            ->setJsonContent($contents)
            ->send();
    }

    public function postAction()
    {
        $response = new Response();
        $data = $this->request->getHeaders();
        $contents = [
            'data' => [
                'name' => $data['Name'],
                'user' => $data['User'],
            ]
        ];

        $response
            ->setJsonContent($contents)
            ->send();
    }
}
