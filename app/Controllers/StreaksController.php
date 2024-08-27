<?php

namespace App\Controllers;

class StreaksController extends BaseController
{

    public function resources() {

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('GET',APP_URL.'resources',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);

            $resources = json_decode($res->getBody());
            //echo "<pre>", var_dump($resources), "</pre>";

            /*
            // Sponsors
            $x=0;
            foreach($resources->sponsors as $sponsors){
                $file_id = $sponsors->s3_file_id;

                $file = json_decode($this->getfile($file_id));

                $resources->sponsors[$x]->base64 = $file;

                $x++;
            }

            // Sports
            $x=0;
            foreach($resources->sports as $sports){
                $file_id = $sports->s3_file_id;

                $file = json_decode($this->getfile($file_id));

                $resources->sports[$x]->base64 = $file;

                $x++;
            }

            // Physical Awards
            $x=0;
            foreach($resources->physical_awards as $physical_awards){
                $file_id = $physical_awards->s3_file_id;

                $file = json_decode($this->getfile($file_id));

                $resources->physical_awards[$x]->base64 = $file;

                $x++;
            }
            */
            

            $response = $resources;
            

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }

        //echo "<pre>", var_dump($response), "</pre>";
        

        return json_encode($response);
    }

    public function getfile($file_id = false) {

        //echo "file_id: ".$file_id."<br>";

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('GET',APP_URL.'files/s3/base64/'.$file_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);

            $file = json_decode($res->getBody());
            $type = $file->type;
            $base64 = $file->base64;
            $file_base64 = 'data:'.$type.';base64,'.$base64;
            
            $response = $file_base64;
            //echo "<pre>", var_dump($response), "</pre>";

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }

        //header('Content-type: image/png');
        //$this->response->setContentType('image/png')->send();

        return json_encode($response);
    }

    public function leagues() {

        $sport_id = $this->request->getVar('sport_id');
        
        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('GET',APP_URL.'matches/leagues?sport_id='.$sport_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);

            $leagues = json_decode($res->getBody());
            $response = $leagues;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }
        

        return json_encode($response);
    }

    public function teams() {

        $sport_id = $this->request->getVar('sport_id');

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('GET',APP_URL.'teams?sport_id='.$sport_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);

            $teams = json_decode($res->getBody());
            $response = $teams;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }

        return json_encode($response);
    }

    public function templates() {

        $sport_id = $this->request->getVar('sport_id');

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('GET',APP_URL.'streak-tournaments/templates?sport_id='.$sport_id,
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

    public function streaks() {

        $resources = json_decode($this->resources());
        $leagues = json_decode($this->leagues());

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('GET',APP_URL.'streak-tournaments',
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
            'title' => 'Rachas',
            'icon' => '<i class="fas fa-bolt"></i>'
        );

        $data = array(
            'resources' => $resources,
            'leagues' => $leagues,
            'streaks' => $response
        );

        echo view('templates/header');
        echo view('templates/nav-top');
        echo view('templates/nav-aside',$data_breadcrumb);
        echo view('templates/breadcrumb',$data_breadcrumb);
        echo view('streaks/default',$data);
        echo view('templates/footer',$data_breadcrumb);
    }

    public function save() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";

        $response = null;

        $sponsor_id = $this->request->getPost('sponsor_add_id');
        $titulo = $this->request->getPost('titulo');
        $subtitulo = $this->request->getPost('subtitulo');
        $fecha_inicio = $this->request->getPost('fecha_inicio');
        $horario_inicio = $this->request->getPost('horario_inicio');
        $fecha_fin = $this->request->getPost('fecha_fin');
        $horario_fin = $this->request->getPost('horario_fin');
        $multiplicador = $this->request->getPost('multiplicador');
        $test = $this->request->getPost('test');

        $start_date = $fecha_inicio.' '.$horario_inicio;
        $end_date = $fecha_fin.' '.$horario_fin;

        if( isset($test) && $test == 'on' ){
            $test = 1;
        }else{
            $test = 0;
        }

        // Awards
        $awards = $this->request->getPost('awards');

        // Total awards
        //$total_awards = $this->request->getPost('total_awards');
        $total_awards = $this->request->getPost('lugar_add');

        $award_list = '';
        $physical_awards = null;

        for($x=1;$x<=$total_awards;$x++){
            $award = $this->request->getPost('award_add_'.$x);
            $physical_award_id = $this->request->getPost('physical_award_id_'.$x);

            if(isset($physical_award_id) && $physical_award_id > 0) {
                $physical_awards[] = array( 
                    "premio_id" => $physical_award_id,
                    "place" => $x
                );
            }

            if($x == 1){
                $award_list .= '[';
                $award_list .= '$'.number_format($award,2,'.',',');
            }else{
                $award_list .= '-$'.number_format($award,2,'.',',');
            }

            if($x == $total_awards){
                $award_list .= ']';
            }
        }

        //echo "award_list: ".$award_list."<br>";
        //echo "<pre>", var_dump($physical_awards), "</pre>";


        $client = \Config\Services::curlrequest();
        $session = session();

        
        try {
            $res = $client->request('POST',APP_URL.'streak-tournaments',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ],
                'json' => [
                    'title' => $titulo,
                    'subtitle' => $subtitulo,
                    'test' => $test,
                    'sponsor_id' => $sponsor_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'award' => $awards,
                    'awards' => $award_list,
                    'physical_awards' => $physical_awards
                ]
            ]);

            $respuesta = json_decode($res->getBody());
            $response = $respuesta;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }
        

        $data_breadcrumb = array(
            'title' => 'Rachas - Guardando...',
            'icon' => '<i class="fas fa-bolt"></i>'
        );

        $data = array(
            'response' => $response
        );

        echo view('templates/header');
        echo view('templates/nav-top');
        echo view('templates/nav-aside',$data_breadcrumb);
        echo view('templates/breadcrumb',$data_breadcrumb);
        echo view('streaks/save',$data);
        echo view('templates/footer',$data_breadcrumb);
    }

    public function save_templates() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";

        // Armamos los matches que se modificaron
        // Matches
        $matches_add = null;
        $matches_upd = null;
        $arr_matches_old = null;

        $tournament_id = $this->request->getPost('tournament_id');

        $matches_status = $this->request->getPost('matches_status');

        // inputs
        if($matches_status == 'add'){
            $match_var = '';
        }

        if($matches_status == 'edit'){
            $match_var = '_edit';
        }

        // Partidos
        $arr_matches = $this->request->getPost('match_id');
        $arr_templates = $this->request->getPost('templates_id');
        $arr_vip = $this->request->getPost('is_streak_vip');

        

        // echo "<pre>", var_dump($arr_templates), "</pre>"; 
        // echo "<pre>", var_dump($arr_matches), "</pre>"; 

        if($arr_matches != NULL){
            // Partidos únicos, quitamos los repetidos
            $distinct_arr_matches = array_unique($arr_matches);

            //echo "<pre>", var_dump($arr_matches), "</pre>"; 


            foreach($distinct_arr_matches as $match_id){
                //echo "match_id: ".$match_id."<br>";
                
                // Buscamos si existe el match para hacer PUT (Ejemplo: brackets)
                if( isset($arr_matches_old) && $arr_matches_old != null && $arr_matches_old[$match_id] == 'checked'){


                }else{
                    $templates = '';
                    // Varificamos si existen templates a agregar
                    if( isset($arr_templates[$match_id]) && $arr_templates[$match_id] != ''){
                        // Hace el explode como valor string
                        //$templates = explode(',',$arr_templates[$match_id]);
                        // Hace el explode y lo convierte a valor entero
                        $templates = array_map('intval', explode(',', $arr_templates[$match_id]));
                        //echo "<pre>", var_dump($templates), "</pre>"; 

                        // match para hacer POST
                        $matches_add[] = array(
                            "match_id" => intval($match_id),
                            "templates" => $templates,
                        );

                    }else{
                        // match para hacer POST
                        // NO Existen templates
                        $matches_add[] = array(
                            "match_id" => intval($match_id)
                        );
                    }


                }
            }
            //echo "<pre>", var_dump($matches_add), "</pre>"; 
        } // END if

        if($arr_vip != ''){
            foreach($arr_vip as $key => $value){
                echo "key: ".$key."<br>";
                echo "value: ".$value."<br>";

                $clave = array_search($key, array_column($matches_add, 'match_id'));
                echo "clave: ".$clave."<br>";

                $matches_add[$clave]["is_vip"] = intval('1');

                //array_push($matches_add[$clave],$arr_templ);
            }
        }

        //echo "<pre>", var_dump($matches_add), "</pre>"; 

        if(!is_null($matches_add)){

            //$distinct_matches_add = array_unique($matches_add);
            //echo "<pre>", var_dump($distinct_matches_add), "</pre>";

            $client = \Config\Services::curlrequest();
            $session = session();    
            
            try {
                $res = $client->request('POST',APP_URL.'streak-tournaments/add-matches',
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => $session->token
                    ],
                    'json' => [
                        'tournament_id' => intval($tournament_id),
                        'matches' => $matches_add
                    ]
                ]);

                $respuesta = json_decode($res->getBody());
                $response['matches_add'] = $respuesta;


            } catch (\Exception $e) {
                //exit($e->getMessage());
                $response['matches_add'] = 'fallo al agregar partidos';
                echo $e->getMessage();
            }
            
        }else{
            $response['matches_add'] = null;
        }

        //echo "response <br>";
        //echo "<pre>", var_dump($response), "</pre>";

        $data_breadcrumb = array(
            'title' => 'Rachas Templates - Actualizando',
            'icon' => '<i class="fas fa-sitemap"></i>'
        );

        $data = array(
            'response' => $response
        );

        //echo "<pre>", var_dump($data), "</pre>";

        echo view('templates/header');
        echo view('templates/nav-top');
        echo view('templates/nav-aside',$data_breadcrumb);
        echo view('templates/breadcrumb',$data_breadcrumb);
        echo view('streaks/save_templates',$data);
        echo view('templates/footer',$data_breadcrumb);

    }

    public function update() {

    }

    public function delete() {

        $match_id = $this->request->getPost('match_id');

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('DELETE',APP_URL.'matches/'.$match_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);

            $matches = json_decode($res->getBody());
            $response = $matches;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }

        return json_encode($response);
    }

    public function list($tournament_id = false) {

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('GET',APP_URL.'streak-tournaments/streaks/'.$tournament_id.'?day=0',
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
            'title' => 'Rachas',
            'icon' => '<i class="fas fa-bolt"></i>'
        );

        $data = array(
            'streaks' => $response
        );

        echo view('templates/header');
        echo view('templates/nav-top');
        echo view('templates/nav-aside',$data_breadcrumb);
        echo view('templates/breadcrumb',$data_breadcrumb);
        echo view('streaks/streaks',$data);
        echo view('templates/footer',$data_breadcrumb);
    }

    public function list_streak() {

        //$response = json_encode($this->request->getPost());

        $tournament_id = $this->request->getPost('tournament_id');
        $day = $this->request->getPost('day');
        
        $client = \Config\Services::curlrequest();
        $session = session();
        
        try {
            $res = $client->request('GET',APP_URL.'streak-tournaments/streaks/'.$tournament_id.'?day='.$day,
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

    public function update_streaks() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";
        //$response = json_encode($this->request->getPost());

        $streak_id = $this->request->getPost('streak_id');

        // inputs
        $is_vip = $this->request->getPost('vip');
        $status = $this->request->getPost('status');

        $fecha_limite = $this->request->getPost('fecha_limite');
        $horario_limite = $this->request->getPost('horario_limite');

        $pregunta = $this->request->getPost('pregunta');
        $local = $this->request->getPost('local');
        $visitante = $this->request->getPost('visitante');
        $local_abv = $this->request->getPost('local_abv');
        $visitante_abv = $this->request->getPost('visitante_abv');
        $local_extra = $this->request->getPost('local_extra');
        $visitante_extra = $this->request->getPost('visitante_extra');
        $ganador = $this->request->getPost('ganador');

        // inputs old
        $is_vip_old = $this->request->getPost('vip_old');
        $status_old = $this->request->getPost('status_old');

        $fecha_limite_old = $this->request->getPost('fecha_limite_old');
        $horario_limite_old = $this->request->getPost('horario_limite_old');

        $pregunta_old = $this->request->getPost('pregunta_old');
        $local_old = $this->request->getPost('local_old');
        $visitante_old = $this->request->getPost('visitante_old');
        $local_abv_old = $this->request->getPost('local_abv_old');
        $visitante_abv_old = $this->request->getPost('visitante_abv_old');
        $local_extra_old = $this->request->getPost('local_extra_old');
        $visitante_extra_old = $this->request->getPost('visitante_extra_old');
        $ganador_old = $this->request->getPost('ganador_old');

        // Armamos la fecha limite
        $limit_date = $fecha_limite.'T'.$horario_limite;
        $limit_date_old = $fecha_limite_old.'T'.$horario_limite_old; 

        $arr_json = array();

        // Armamos el arreglo con los cambios
        if($is_vip != $is_vip_old){
            $arr_json['is_vip'] = intval($is_vip);
        }

        if($status != $status_old){
            $arr_json['status'] = $status;
        }

        if($limit_date != $limit_date_old){
            $arr_json['limit_date'] = $limit_date;
        }

        if($pregunta != $pregunta_old){
            $arr_json['question'] = $pregunta;
        }

        if($ganador != $ganador_old){

            if($ganador == 'Local'){
                $arr_json['answer'] = "0";
            }

            if($ganador == 'Push'){
                $arr_json['answer'] = "Push";
            }

            if($ganador == 'Visitante'){
                $arr_json['answer'] = "1";
            }
            
        }

        // Options
        $options_chg = 0;
        if($local != $local_old){
            $options_chg = 1;
        }
        if($visitante != $visitante_old){
            $options_chg = 1;
        }

        if($options_chg == 1){
            $arr_json['options'] = "[".$local.",".$visitante."]";
        }

        // Extra
        $extra_chg = 0;
        if($local_extra != $local_extra_old){
            $extra_chg = 1;
        }
        if($visitante_extra != $visitante_extra_old){
            $extra_chg = 1;
        }

        if($extra_chg == 1){
            $arr_json['extra'] = "['".$local_extra."','".$visitante_extra."']";
        }

        // Abbreviation
        $abbreviation_chg = 0;
        if($local_abv != $local_abv_old){
            $abbreviation_chg = 1;
        }
        if($visitante_abv != $visitante_abv_old){
            $abbreviation_chg = 1;
        }

        if($abbreviation_chg == 1){
            $arr_json['options_abbreviation'] = "['".$local_abv."','".$visitante_abv."']";
        }
        
        $client = \Config\Services::curlrequest();
        $session = session();
        
        try {
            $res = $client->request('PUT',APP_URL.'streaks/'.$streak_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ],
                'json' => $arr_json
            ]);

            $respuesta = json_decode($res->getBody());
            $response = $respuesta;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }
        
        return json_encode($response);
    }

    public function personalized_streaks() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";
        //$response = json_encode($this->request->getPost()); 
        
        $arr_json = array();

        $tournament_id = $this->request->getPost('tournament_id');
        $sport_id = $this->request->getPost('sport_id');

        // inputs
        $pregunta = $this->request->getPost('pregunta');
        $local = $this->request->getPost('local');
        $visitante = $this->request->getPost('visitante');
        $local_abv = $this->request->getPost('local_abv');
        $visitante_abv = $this->request->getPost('visitante_abv');
        $local_extra = $this->request->getPost('local_extra');
        $visitante_extra = $this->request->getPost('visitante_extra');

        $fecha = $this->request->getPost('fecha');
        $horario = $this->request->getPost('horario');

        $arr_json['limit_date'] = $fecha.'T'.$horario;

        
        // Armamos el arreglo con lo que se va a agregar en la racha personalizada
        $arr_json['tournament_id'] = $tournament_id;
        $arr_json['sport_id'] = $sport_id;
        $arr_json['question'] = $pregunta;

        // Options
        $options_add = 0;
        if($local != ''){
            $options_add = 1;
        }
        if($visitante != ''){
            $options_add = 1;
        }

        if($options_add == 1){
            $arr_json['options'] = "[".$local.",".$visitante."]";
        }

        // Extra
        $extra_add = 0;
        if($local_extra != ''){
            $extra_add = 1;
        }
        if($visitante_extra != ''){
            $extra_add = 1;
        }

        if($extra_add == 1){
            $arr_json['extra'] = "['".$local_extra."','".$visitante_extra."']";
        }

        // Abbreviation
        $abbreviation_add = 0;
        if($local_abv != ''){
            $abbreviation_add = 1;
        }
        if($visitante_abv != ''){
            $abbreviation_add = 1;
        }

        if($abbreviation_add == 1){
            $arr_json['options_abbreviation'] = "['".$local_abv."','".$visitante_abv."']";
        }
        
        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('POST',APP_URL.'streaks',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ],
                'json' => $arr_json
            ]);

            $respuesta = json_decode($res->getBody());
            $response = $respuesta;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }
        
        return json_encode($response);
    }

    public function update_tournament() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";
        //$response = json_encode($this->request->getPost()); 
        
        $arr_json = array();


        // Inputs
        $tournament_id = $this->request->getPost('tournament_id');

        $sponsor_id = $this->request->getPost('sponsor_id');
        $title = $this->request->getPost('title');
        $subtitle = $this->request->getPost('subtitle');
        $fecha_inicio = $this->request->getPost('fecha_inicio');
        $horario_inicio = $this->request->getPost('horario_inicio');
        $fecha_fin = $this->request->getPost('fecha_fin');
        $horario_fin = $this->request->getPost('horario_fin');

        // Inputs Old
        $sponsor_id_old = $this->request->getPost('sponsor_id_old');
        $title_old = $this->request->getPost('title_old');
        $subtitle_old = $this->request->getPost('subtitle_old');
        $fecha_inicio_old = $this->request->getPost('fecha_inicio_old');
        $horario_inicio_old = $this->request->getPost('horario_inicio_old');
        $fecha_fin_old = $this->request->getPost('fecha_fin_old');
        $horario_fin_old = $this->request->getPost('horario_fin_old');

        $start_date = $fecha_inicio.'T'.$horario_inicio;
        $start_date_old = $fecha_inicio_old.'T'.$horario_inicio_old;

        $end_date = $fecha_fin.'T'.$horario_fin;
        $end_date_old = $fecha_fin_old.'T'.$horario_fin_old;


        $existe_cambio = 0;


        if($sponsor_id != $sponsor_id_old){
            $arr_json['sponsor_id'] = $sponsor_id;
            $existe_cambio = 1;
        }

        if($title != $title_old){
            $arr_json['title'] = $title;
            $existe_cambio = 1;
        }

        if($subtitle != $subtitle_old){
            $arr_json['subtitle'] = $subtitle;
            $existe_cambio = 1;
        }

        if($start_date != $start_date_old){
            $arr_json['start_date'] = $start_date;
            $existe_cambio = 1;
        }

        if($end_date != $end_date_old){
            $arr_json['end_date'] = $end_date;
            $existe_cambio = 1;
        }

        if($existe_cambio == 1){

            $client = \Config\Services::curlrequest();
            $session = session();

            try {
                $res = $client->request('PUT',APP_URL.'streak-tournaments/'.$tournament_id,
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => $session->token
                    ],
                    'json' => $arr_json
                ]);

                $respuesta = json_decode($res->getBody());
                $response = $respuesta;

            } catch (\Exception $e) {
                //exit($e->getMessage());
                $response = null;
            }
        }else{
            $response['message'] = "No se generó ningun cambio en los datos";
        }

        return json_encode($response);
    }

    public function delete_tournament() {

        $tournament_id = $this->request->getPost('tournament_id');

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('DELETE',APP_URL.'streak-tournaments/'.$tournament_id,
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

    public function delete_streak() {

        $streak_id = $this->request->getPost('streak_id');

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('DELETE',APP_URL.'streaks/'.$streak_id,
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

    public function find_date() {

        $date = $this->request->getVar('date');
        $sport_id = $this->request->getVar('sport_id');

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('GET',APP_URL.'matches?date='.$date.'&sport_id='.$sport_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);

            $matches_date = json_decode($res->getBody());
            $response = $matches_date;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }

        return json_encode($response);
    }

    public function find_league() {

        $league_id = $this->request->getVar('league_id');
        $sport_id = $this->request->getVar('sport_id');

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('GET',APP_URL.'matches?sport_id='.$sport_id.'&league_id='.$league_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);

            $matches_league = json_decode($res->getBody());
            $response = $matches_league;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }

        return json_encode($response);
    }
}