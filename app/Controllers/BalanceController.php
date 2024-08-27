<?php

namespace App\Controllers;

class BalanceController extends BaseController
{

    // Recursos del Balance General
    public function resources() {

        $client = \Config\Services::curlrequest();
        $session = session();

        //echo "token: ".$session->token."<br>";

        try {
            $res = $client->request('GET',APP_URL.'resources/balance',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);

            $resources = json_decode($res->getBody());
            $response = $resources;
            //echo "<pre>", var_dump($response), "</pre>";

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }

        return json_encode($response);
    }

    // Balance
    public function balance() {

        $resources = json_decode($this->resources());

        // status = pending | deposited | rejected
        $status = $this->request->getVar('status');
        //echo "status: ".$status."<br>";

        if($status == ''){
            $status = 'pending';
        }
        
        //echo "status: ".$status."<br>";
        //echo 'GET',APP_URL.'users-verifictions?'.$status.'=True';


        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('GET',APP_URL.'withdrawals?'.$status.'=True',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);

            $respuesta = json_decode($res->getBody());
            $response = $respuesta;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }

        $data_breadcrumb = array(
            'title' => 'Balance',
            'icon' => '<i class="fas fa-dollar-sign"></i>'
        );

        $data = array(
            'resources' => $resources,
            'balance' => $response
        );

        echo view('templates/header');
        echo view('templates/nav-top');
        echo view('templates/nav-aside',$data_breadcrumb);
        echo view('templates/breadcrumb',$data_breadcrumb);
        echo view('balance/default',$data);
        echo view('templates/footer',$data_breadcrumb);
    }

    // Balance - Retiros
    public function withdrawals() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";

        $balance_id = $this->request->getPost('balance_id');
        $status_id = $this->request->getPost('status_id');
        $comments = $this->request->getPost('comments');

        $json['status_id'] = intval($status_id);
        
        if($comments != ''){
            $json['comment'] = $comments;
        }

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('PUT',APP_URL.'withdrawals/'.$balance_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ],
                'json' => $json
            ]);

            $respuesta = json_decode($res->getBody());
            $response = $respuesta;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }

        return json_encode($response);
    }
    
}