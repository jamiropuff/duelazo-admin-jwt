<?php

namespace App\Controllers\dashboard;
use App\Controllers\BaseController;

class LoginController extends BaseController
{

    public function login(){
        $client = \Config\Services::curlrequest();

        $res = $client->request('GET',APP_URL.'pools/preview',
        [
            'headers' => [
                'Accept' => 'application/json'
            ]

        ]);

        //var_dump($res);
        //echo  $res->getStatusCode();
        $body['body'] = json_decode($res->getBody());
        //echo "<pre>", var_dump($body), "</pre>";
        //echo "<pre>", var_dump($body[0]->title), "</pre>";

        echo view('welcome_message',$body);
    }
}
