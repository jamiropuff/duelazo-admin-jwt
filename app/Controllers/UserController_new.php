<?php

namespace App\Controllers;
use App\Libraries\JWT;
use CodeIgniter\API\ResponseTrait;

class UserController extends BaseController
{

    use ResponseTrait;

    public function login() {
    echo "entro a login \n";

        $user = $this->request->getPost('usuario');
        $pass = $this->request->getPost('clave');
        $identifier = $this->randomPass(10);
        $web_identifier = hash('sha256', $identifier);

        //$user = 'gconderos@gmail.com';
        //$pass = 'master12';

        
        echo "user: ".$user."\n";
        echo "pass: ".$pass."\n";
        echo "identifier: ".$identifier."\n";
        echo "web_identifier: ".$web_identifier."\n";
        echo APP_URL.'sessions/login'."\n";
        

        $client = \Config\Services::curlrequest();

        try {
            $res = $client->request('POST',APP_URL.'sessions/login',
            [
                'headers' => [
                    'Accept' => 'application/json'
                ],
    
                'json' => [
                    'email' => $user,
                    'password' => $pass,
                    'device_identifier' => $web_identifier
                ]
    
            ]);

            $body = json_decode($res->getBody());
        

            if(isset($body)){
                //echo "entro a session <br>";
                
                
                if(isset($body->session) && $body->session->user->role_id == 1 || $body->session->user->role_id == 2){

                    // Generar el token JWT para la nueva Versión
                    $jwt = new JWT();
                    $payload = array(
                        "userId" => $body->session->user_id,
                        "name" => $body->session->user->name,
                        "lastName" => $body->session->user->last_name,
                        "email" => $body->session->user->email,
                        "phone" => $body->session->user->phone,
                        "nickname" => $body->session->user->nickname,
                        "bDay" => $body->session->user->birthday,
                        'iat' => time(),   // Fecha/hora de emisión del token
                        'exp' => time() + 3600  // Fecha/hora de expiración del token (1 hora)
                    );
                    $token = $jwt->encode($payload);

                    echo $token."\n";

                    // Generar la Session
                    $arr_session = array(
                        'user_id' => $body->session->user_id,
                        'token' => $token,
                        'identifier' => $body->session->device->identifier,
                        'role_id' => $body->session->user->role_id,
                        'name' => $body->session->user->name,
                        'last_name' => $body->session->user->last_name,
                        'nickname' => $body->session->user->nickname,
                        'email' => $body->session->user->email,
                        'verified' => $body->session->user->verified,
                        'invitation_code' => $body->session->user->invitation_code
                    );
    
                    $session = session();
                    $session->set($arr_session);

                    
                    $response = array(
                        'status' => 1,
                        'message' => 'Success'
    
                    );

                    //return redirect()->to('/home');

                }else{
                    
                    $response = array(
                        'status' => 0,
                        'message' => 'No tiene permisos para acceder a este servicio'
    
                    );
                            

                    //return redirect()->back()->with('message','No tiene permisos para acceder a este servicio');
                }

                //echo $session->email;
            }
    
        } catch (\Exception $e) {
            //exit($e->getMessage());

            $response = array(
                'status' => 0,
                'message' => 'Usuario o contraseña incorrectos',
                'error' => $e->getMessage()

            );

            //return redirect()->back()->with('message','Usuario o contraseña incorrectos');
        }

        //$response->setContentType('application/json');

        return json_encode($response);
    }

    public function logout() {
        $session = session();
        $session->destroy();

        return redirect()->to('./');
        //return redirect()->to('https://administrador.duelazo.com/');
    }

    public function randomPass($longitud) {
        $cadena="[^a-zA-Z0-9!@#\$%\^&\*\?_~\/]";  
        return substr(preg_replace($cadena, "", md5(rand())) .  preg_replace($cadena, "", md5(rand())) .  preg_replace($cadena, "", md5(rand())),  0, $longitud);
    }


    public function users() {
        
        $data_breadcrumb = array(
            'title' => 'Usuarios',
            'icon' => '<i class="fas fa-users"></i>'
        );

        /*
        $data = array(
            'resources' => $resources
        );
        */

        echo view('templates/header');
        echo view('templates/nav-top');
        echo view('templates/nav-aside',$data_breadcrumb);
        echo view('templates/breadcrumb',$data_breadcrumb);
        echo view('users/default');
        echo view('templates/footer',$data_breadcrumb);
    }

    public function search() {

        $type_search = $this->request->getPost('type_search');
        $search = $this->request->getPost('search');

        $client = \Config\Services::curlrequest();
        $session = session();

        if($type_search == 'nickname'){
            try {
                $res = $client->request('GET',APP_URL.'users?nickname='.$search,
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => $session->token
                    ]
                ]);

                $user = json_decode($res->getBody());
                $response = $user;

            } catch (\Exception $e) {
                //exit($e->getMessage());
                $response = null;
            }
        }

        if($type_search == 'email'){
            try {
                $res = $client->request('GET',APP_URL.'users?email='.$search,
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => $session->token
                    ]
                ]);

                $user = json_decode($res->getBody());
                $response = $user;

            } catch (\Exception $e) {
                //exit($e->getMessage());
                $response = null;
            }
        }

        if($type_search == 'id'){
            try {
                $res = $client->request('GET',APP_URL.'users/'.$search,
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => $session->token
                    ]
                ]);

                $user = json_decode($res->getBody());
                $response = $user;

            } catch (\Exception $e) {
                //exit($e->getMessage());
                $response = null;
            }
        }

        return json_encode($response);
    }

    // Editar Usuario
    public function update() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";

        // inputs
        $user_id = $this->request->getPost('user_id_edit');

        $rol_user = $this->request->getPost('rol_user_edit');

        $name = $this->request->getPost('name_edit');
        $last_name = $this->request->getPost('last_name_edit');
        $nickname = $this->request->getPost('nickname_edit');
        $email = $this->request->getPost('email_edit');
        $phone = $this->request->getPost('phone_edit');
        $birthday = $this->request->getPost('birthday_edit');
        $diamonds = $this->request->getPost('diamonds_edit');
        $tokens = $this->request->getPost('tokens_edit');
        $boosts = $this->request->getPost('boosts_edit');
        $balance = $this->request->getPost('balance_edit');
        $suscription_type = $this->request->getPost('suscription_type_id_edit');
        $suscriber_until = $this->request->getPost('suscriber_until_edit');

        // inputs old
        $rol_user_old = $this->request->getPost('rol_user_edit_old');

        $name_old = $this->request->getPost('name_edit_old');
        $last_name_old = $this->request->getPost('last_name_edit_old');
        $nickname_old = $this->request->getPost('nickname_edit_old');
        $email_old = $this->request->getPost('email_edit_old');
        $phone_old = $this->request->getPost('phone_edit_old');
        $birthday_old = $this->request->getPost('birthday_edit_old');
        $diamonds_old = $this->request->getPost('diamonds_edit_old');
        $tokens_old = $this->request->getPost('tokens_edit_old');
        $boosts_old = $this->request->getPost('boosts_edit_olds');
        $balance_old = $this->request->getPost('balance_edit_old');
        $suscription_type_old = $this->request->getPost('suscription_type_id_edit_old');
        $suscriber_until_old = $this->request->getPost('suscriber_until_edit_old');

        if($rol_user != $rol_user_old){
            $json['role_id'] = $rol_user;
        }

        if($name != $name_old){
            $json['name'] = $name;
        }

        if($last_name != $last_name_old){
            $json['last_name'] = $last_name;
        }

        if($nickname != $nickname_old){
            $json['nickname'] = $nickname;
        }

        if($email != $email_old){
            $json['email'] = $email;
        }

        if($phone != $phone_old){
            $json['phone'] = $phone;
        }

        if($birthday != $birthday_old){
            $json['birthday'] = $birthday;
        }

        if($diamonds != $diamonds_old){
            $json['diamonds'] = $diamonds;
        }

        if($tokens != $tokens_old){
            $json['tokens'] = $tokens;
        }

        if($boosts != $boosts_old){
            $json['boosts'] = $boosts;
        }

        if($balance != $balance_old){
            $json['balance'] = $balance;
        }
        
        $confirmed_email = $this->request->getPost('confirmed_email_edit');
        $confirmed_email_edit_old = $this->request->getPost('confirmed_email_edit_old');

        if($confirmed_email != $confirmed_email_edit_old){
            $json['confirmed_email'] = intval($confirmed_email);
        }

        $confirmed_phone = $this->request->getPost('confirmed_phone_edit');
        $confirmed_phone_edit_old = $this->request->getPost('confirmed_phone_edit_old');

        if($confirmed_phone != $confirmed_phone_edit_old){
            $json['confirmed_phone'] = intval($confirmed_phone);
        }

        $verified = $this->request->getPost('verified_edit');
        $verified_edit_old = $this->request->getPost('verified_edit_old');

        if($verified != $verified_edit_old){
            $json['verified'] = intval($verified);
        }

        $is_subscriber = $this->request->getPost('is_subscriber_edit');
        $is_subscriber_edit_old = $this->request->getPost('is_subscriber_edit_old');

        if($is_subscriber != $is_subscriber_edit_old){
            $json['is_subscriber'] = intval($is_subscriber);
        }

        if($suscription_type != $suscription_type_old){
            $json['suscription_type_id'] = $suscription_type;
        }

        if($suscriber_until != $suscriber_until_old){
            $json['subscriber_until'] = $suscriber_until;
        }
        

        $response = null;
        //$response = $json;
        //$response = $this->request->getPost();
        
        $client = \Config\Services::curlrequest();
        $session = session();

        $total_cambios = count($json);
        //echo "total_cambios: ".$total_cambios."<br>";
        
        if($total_cambios > 0){
            try {
                $res = $client->request('PUT',APP_URL.'users/'.$user_id,
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => $session->token
                    ],
                    'json' => $json
                ]);
        
                $users = json_decode($res->getBody());
                $response[] = $users;
        
            } catch (\Exception $e) {
                //exit($e->getMessage());
                $response[] = $e->getMessage();
            }
        }
        
        
        return json_encode($response);
    }

    public function delete() {

        $user_id = $this->request->getPost('user_id');

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('DELETE',APP_URL.'users/'.$user_id,
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

        return json_encode($response);
    }

    // Verificación de usuarios
    public function users_verifictions() {

        // status = pending | verified
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
            $res = $client->request('GET',APP_URL.'users-verifictions?'.$status.'=True',
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
            'title' => 'Verificación de Usuarios',
            'icon' => '<i class="fas fa-user-check"></i>'
        );

        $data = array(
            'response' => $response
        );

        echo view('templates/header');
        echo view('templates/nav-top');
        echo view('templates/nav-aside',$data_breadcrumb);
        echo view('templates/breadcrumb',$data_breadcrumb);
        echo view('users/verification',$data);
        echo view('templates/footer',$data_breadcrumb);
    }

    // Guardamos la Verificación del Usuario
    public function save_verifiction() {

        $user_id = $this->request->getPost('user_id');

        // Comprobante de Domicilio
        $comprobante_domicilio = $this->request->getPost('comprobante_domicilio');
        $comprobante_domicilio_old = $this->request->getPost('comprobante_domicilio_old');

        if($comprobante_domicilio != $comprobante_domicilio_old){
            $json['status_id_comprobante_de_domicilio'] = $comprobante_domicilio;
        }

        // Identificación Oficial
        $identificacion = $this->request->getPost('identificacion');
        $identificacion_old = $this->request->getPost('identificacion_old');

        if($identificacion != $identificacion_old){
            $json['status_id_ine'] = $identificacion;
        }

        // CURP
        $curp = $this->request->getPost('curp');
        $curp_old = $this->request->getPost('curp_old');

        if($curp != $curp_old){
            $json['status_id_curp'] = $curp;
        }

        // Estado de Cuenta
        $cuenta = $this->request->getPost('cuenta');
        $cuenta_old = $this->request->getPost('cuenta_old');

        if($cuenta != $cuenta_old){
            $json['status_id_estado_de_cuenta'] = $cuenta;
        }

        // Comentarios
        $comentarios = $this->request->getPost('comentarios');
        $comentarios_old = $this->request->getPost('comentarios_old');

        $json['comments'] = $comentarios;

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('PUT',APP_URL.'users-verifictions/'.$user_id,
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

    public function store_transactions() {

        $user_id = $this->request->getPost('user_id');

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('GET',APP_URL.'store-transactions/users/'.$user_id,
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

        return json_encode($response);
    }

    public function winners_records() {

        $user_id = $this->request->getPost('user_id');

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('GET',APP_URL.'users/winners-records/'.$user_id,
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

        return json_encode($response);
    }
}