<?php

namespace App\Controllers;

class PoolsController extends BaseController
{

/**
 * It's a function that returns a JSON object of resources from a REST API.
 * 
 * @return The response is a JSON object.
 */
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

/**
 * It's a function that returns a JSON response of all the leagues for a given sport.
 * 
 * @return <code>{"status":true,"data":[{"id":1,"name":"Premier
 * League","sport_id":1,"created_at":"2019-11-11T00:00:00.000000Z","updated_at":"2019-11-11T00:00:00.000000Z"},{"id":2,"name":"La
 * Liga","sport_id
 */
    public function leagues($sport_id = '') {

        //$sport_id = $this->request->getVar('sport_id');
        
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

/**
 * It's a function that returns a JSON response of teams based on a sport_id.
 * 
 * @return The response is a JSON object with the following structure:
 */
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

    public function pools() {

        $resources = json_decode($this->resources());
        $leagues = json_decode($this->leagues());

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('GET',APP_URL.'pools',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);

            $pools = json_decode($res->getBody());
            $response = $pools;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }

        $data_breadcrumb = array(
            'title' => 'Quinielas',
            'icon' => '<i class="fas fa-tasks"></i>'
        );

        $data = array(
            'resources' => $resources,
            'leagues' => $leagues,
            'pools' => $pools
        );

        echo view('templates/header');
        echo view('templates/nav-top');
        echo view('templates/nav-aside',$data_breadcrumb);
        echo view('templates/breadcrumb',$data_breadcrumb);
        echo view('pools/default',$data);
        echo view('templates/footer',$data_breadcrumb);
    }

    public function save() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";

        // General Info
        $sponsor_id = $this->request->getPost('sponsor_id');
        $sport_id = $this->request->getPost('sport_id_search');
        $titulo = $this->request->getPost('titulo');
        $subtitulo = $this->request->getPost('subtitulo');
        //$multiplier = $this->request->getPost('multiplicador');
        $test = $this->request->getPost('test');
        $vip = $this->request->getPost('vip');

        if( isset($test) && $test == 'on' ){
            $test = 1;
        }else{
            $test = 0;
        }

        if( isset($vip) && $vip == 'on' ){
            $vip = 1;
        }else{
            $vip = 0;
        }

        $fecha_limite = $this->request->getPost('fecha_inicio');
        $horario_limite = $this->request->getPost('horario_inicio');

        $limit_date = $fecha_limite.' '.$horario_limite;

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


        $is_cumulative = $this->request->getPost('is_cumulative');

        if( isset($is_cumulative) && $is_cumulative == 'on' ){
            $is_cumulative = 1;
        }else{
            $is_cumulative = 0;
        }

        $phase_info = '';

        // Quiniela Acumulativa
        if ($is_cumulative == 1){
            $phase_name = $this->request->getPost('phase_name');

            // Fecha de inicio
            $fecha_inicio_cumulative = $this->request->getPost('fecha_inicio_cumulative');
            $horario_inicio_cumulative = $this->request->getPost('horario_inicio_cumulative');
    
            $fecha_inicio_is_cumulative = $fecha_inicio_cumulative.' '.$horario_inicio_cumulative;

            // Fecha de finalización
            $fecha_fin_cumulative = $this->request->getPost('fecha_fin_cumulative');
            $horario_fin_cumulative = $this->request->getPost('horario_fin_cumulative');
    
            $fecha_fin_is_cumulative = $fecha_fin_cumulative.' '.$horario_fin_cumulative;

            $phase_info = array(
                'name' => $phase_name,
                'start_date' => $fecha_inicio_is_cumulative,
                'end_date' => $fecha_fin_is_cumulative
            );
    
        }


        // Matches
        $matches = null;

        $arr_matches = $this->request->getPost('match_id');

        
        if($arr_matches != NULL){
            // Partidos únicos, quitamos los repetidos
            $distinct_arr_matches = array_unique($arr_matches);

            //echo "<pre>", var_dump($arr_matches), "</pre>"; 

            foreach($distinct_arr_matches as $match_id){
                //echo "match_id: ".$match_id."<br>";
                $matches[] = array(
                    "id" => $match_id
                );
            }
        }

        //echo "<pre>", var_dump($matches), "</pre>";

        // Tiebreakers
        $tiebreakers = null;
        $opciones_list = '';

        // Preguntas
        $questions = $this->request->getPost('pregunta');
        //echo "<pre>", $questions."</pre>";

        $type_question = gettype($questions);
        //echo "type_question: ".$type_question."<br>";

        // Si no se agregan preguntas, ponemos la variable $questions como un arreglo vacio y validamos que no hay preguntas para que no procese el foreach
        $total_preguntas = 1;
        if( isset($type_question) && ($type_question == 'null' || $type_question == 'NULL') ) {
            //echo "entro <br>";
            $questions = array();
            $total_preguntas = 0;
        }

        //echo "total_preguntas: ".$total_preguntas."<br>";
        

        if(isset($total_preguntas) && $total_preguntas > 0){
            
            // Armamos las preguntas
            foreach($questions as $key => $value){
                //echo "key: ".$key."<br>";
                //echo "value: ".$value."<br>";

                $total_opciones = count($this->request->getPost('opcion_'.$key));
                $opciones = $this->request->getPost('opcion_'.$key);
                $x = 1;

                // Armamos las respuestas
                foreach($opciones as $opcion){
                    //echo "opcion: ".$opcion."<br>";

                    if($x == 1){
                        $opciones_list .= '[';
                        $opciones_list .= $opcion;
                    }else{
                        $opciones_list .= ','.$opcion;
                    }
        
                    if($x == $total_opciones){
                        $opciones_list .= ']';
                        $x=1;
                    }

                    $x++;
                }

                $tiebreakers[] = array(
                    'question' => $value,
                    'options' => $opciones_list
                );

                $opciones_list = '';
            }

            $json['tiebreakers'] = $tiebreakers;
        }

        //echo "<pre>", var_dump($tiebreakers), "</pre>";

        $client = \Config\Services::curlrequest();
        $session = session();

        //echo "token: ".$session->token."<br>";

        $json['sport_id'] = $sport_id;
        $json['sponsor_id'] = $sponsor_id;
        $json['title'] = $titulo;
        $json['subtitle'] = $subtitulo;
        $json['test'] = $test;
        $json['is_vip'] = $vip;
        $json['limit_date'] = $limit_date;
        $json['award'] = $awards;
        $json['awards'] = $award_list;
        //$json['multiplier'] = $multiplier;
        $json['is_cumulative'] = $is_cumulative;
        if ($is_cumulative == 1){
            // Quiniela Acumulativa
            $json['phase_info'] = $phase_info;
        }
        $json['matches'] = $matches;
        $json['physical_awards'] = $physical_awards;


        $json_view = json_encode($json);

        //echo "<pre>", var_dump(json_decode($json_view)), "</pre>";
        
        try {
            $res = $client->request('POST',APP_URL.'pools',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ],
                'json' => $json
            ]);

            $code = $res->getStatusCode();
            $pools = json_decode($res->getBody());
            $response = $pools;

            //echo "code: ".$code."<br>";
            //echo "<pre>", var_dump($response), "</pre>";

        } catch (\Exception $e) {
            exit($e->getMessage());
            $response = null;
        }
        

        $data_breadcrumb = array(
            'title' => 'Quinielas',
            'icon' => '<i class="fas fa-tasks"></i>'
        );

        $data = array(
            'response' => $response
        );

        echo view('templates/header');
        echo view('templates/nav-top');
        echo view('templates/nav-aside',$data_breadcrumb);
        echo view('templates/breadcrumb',$data_breadcrumb);
        echo view('pools/save',$data);
        echo view('templates/footer',$data_breadcrumb);
        
    }

    public function update() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";

        // inputs
        $pool_id = $this->request->getPost('pool_edit_id');

        $title = $this->request->getPost('titulo_edit');
        $subtitle = $this->request->getPost('subtitulo_edit');
        
        $test = $this->request->getPost('test_edit');
        if($test == 'on'){
            $test = 1;
        }else{
            $test = 0;
        }

        $vip = $this->request->getPost('vip_edit');
        if($vip == 'on'){
            $vip = 1;
        }else{
            $vip = 0;
        }

        $sponsor_id = $this->request->getPost('sponsor_edit_id');

        $fecha_inicio = $this->request->getPost('fecha_inicio_edit');
        $horario_inicio = $this->request->getPost('horario_inicio_edit');

        $limit_date = $fecha_inicio.' '.$horario_inicio;

        // inputs old
        $title_old = $this->request->getPost('titulo_edit_old');
        $subtitle_old = $this->request->getPost('subtitulo_edit_old');
        
        $sponsor_id_old = $this->request->getPost('sponsor_edit_id_old');

        $fecha_inicio_old = $this->request->getPost('fecha_inicio_edit_old');
        $horario_inicio_old = $this->request->getPost('horario_inicio_edit_old');

        $limit_date_old = $fecha_inicio_old.' '.$horario_inicio_old;

        $awards_edit = $this->request->getPost('awards_edit');

        $arr_json = array();

        // Armamos el arreglo con los cambios
        if($title != $title_old){
            $arr_json['title'] = $title;
        }
        if($subtitle != $subtitle_old){
            $arr_json['subtitle'] = $subtitle;
        }
        $arr_json['test'] = $test;
        $arr_json['is_vip'] = $vip;

        if($sponsor_id != $sponsor_id_old){
            $arr_json['sponsor_id'] = $sponsor_id;
        }
        if($limit_date != $limit_date_old){
            $arr_json['limit_date'] = $limit_date;
        }


        $total_awards = $this->request->getPost('total_awards_edit');

        $award_list = '';
        $physical_awards = null;
        //$cantidad_premio = 0;

        for($x=1;$x<=$total_awards;$x++){
            $award = $this->request->getPost('award_edit_'.$x);
            $award_old = $this->request->getPost('award_edit_old_'.$x);
            $physical_award_id = $this->request->getPost('physical_award_edit_id_'.$x);
            $physical_award_id_old = $this->request->getPost('physical_award_edit_old_id_'.$x);

            if($physical_award_id != $physical_award_id_old){
                if(isset($physical_award_id) && $physical_award_id > 0) {
                    $physical_awards[] = array( 
                        "premio_id" => $physical_award_id,
                        "place" => $x
                    );
                }
            }

            //echo "award: ".$award."<br>";
            //echo "award_old: ".$award_old."<br>";
            //echo "----------------<br>";

            if($x == 1){
                $award_list .= '[';

                if(is_numeric($award)){
                    //$cantidad_premio += $award;
                    $award_list .= '$'.number_format($award,2,'.',',');
                }else{
                    $award_list .= $award;
                }
            }else{
                if(is_numeric($award)){
                    //$cantidad_premio += $award;
                    $award_list .= '-$'.number_format($award,2,'.',',');
                }else{
                    $award_list .= $award;
                }
            }

            if($x == $total_awards){
                $award_list .= ']';
            }


        } // END for

        //echo "cantidad_premio: ".$cantidad_premio."<br>";

        $arr_json['award'] = $awards_edit;
        $arr_json['awards'] = $award_list;

        $total_arr_json = count($arr_json);

        //echo "total_arr_json: ".$total_arr_json."<br>";
        //echo "<pre>", var_dump($arr_json), "</pre>";

        $client = \Config\Services::curlrequest();
        $session = session();
        
        // Editamos los datos generales del Pool
        if($total_arr_json > 3){
            //echo "entro a editar los datos generales <br>";
            try {
                $res = $client->request('PUT',APP_URL.'pools/'.$pool_id,
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => $session->token
                    ],
                    'json' => $arr_json
                ]);

                $pools_general = json_decode($res->getBody());
                $response['pools_general'] = $pools_general;

            } catch (\Exception $e) {
                //exit($e->getMessage());
                $response['pools_general'] = 'fallo al actualizar';
            }
        }

        //echo "response <br>";
       // echo "<pre>", var_dump($response), "</pre>";

        // Armamos los matches que se modificaron
        // Matches
        $matches_add = null;
        $matches_upd = null;

        /*
        // inputs
        $arr_matches = $this->request->getPost('match_edit_id');
        $arr_pool_match = $this->request->getPost('pool_match_id');

        // inputs old
        $arr_matches_old = $this->request->getPost('match_edit_old_id');

        foreach($arr_matches as $match_id){
            //echo "match_id: ".$match_id."<br>";
            
            // Buscamos si existe el match para hacer PUT (Ejemplo: brackets)
            if($arr_matches_old[$match_id] == 'checked'){


            }else{
                // match para hacer POST
                $matches_add[] = array(
                    "id" => intval($match_id)
                );
            }
        }
        */

        // Partidos
        $arr_matches = $this->request->getPost('match_id');
        $arr_pool_match = $this->request->getPost('pool_match_id');

        //echo "<pre>", var_dump($arr_matches), "</pre>"; 

        if($arr_matches != NULL){
            // Partidos únicos, quitamos los repetidos
            $distinct_arr_matches = array_unique($arr_matches);

            //echo "<pre>", var_dump($arr_matches), "</pre>"; 


            foreach($distinct_arr_matches as $match_id){
                //echo "match_id: ".$match_id."<br>";
                
                // Buscamos si existe el match para hacer PUT (Ejemplo: brackets)
                if( isset($arr_matches_old) && $arr_matches_old != null && $arr_matches_old[$match_id] == 'checked'){


                }else{
                    // match para hacer POST
                    $matches_add[] = array(
                        "id" => intval($match_id)
                    );
                }
            }
            //echo "<pre>", var_dump($matches_add), "</pre>"; 
        } // END if


        // Tiebreakers
        $tiebreakers = null;
        $tiebreakers_put = null;
        $opciones_list = '';
        $opciones_list_old = '';

        // Preguntas
        $questions = $this->request->getPost('pregunta');
        $pregunta_old = $this->request->getPost('pregunta_old');
        $pregunta_id = $this->request->getPost('pregunta_id');

        //var_dump($questions);
        
        if($questions != NULL){
            // Armamos las preguntas
            foreach($questions as $key => $value){
                //echo "key: ".$key."<br>";
                //echo "value: ".$value."<br>";

                // Verificamos si existen las preguntas old
                if( isset( $pregunta_old[$key] ) ) {
                    //echo "actualizar pregunta <br>";
                    //echo "question_".$key.": ".$questions[$key]."<br>";
                    //echo "pregunta_old_".$key.": ".$pregunta_old[$key]."<br>";
                    //echo "------------------------<br>";

                    // Verificamos si cambio la pregunta
                    if( $questions[$key] != $pregunta_old[$key] ){
                        $tiebreakers_put['question'] = $questions[$key];
                        unset($tiebreakers_put['options']);

                        // Verificamos si cambiaron las respuestas
                        $total_opciones = count($this->request->getPost('opcion_'.$key));
                        $opciones = $this->request->getPost('opcion_'.$key);
                        $x = 1;
        
                        // Armamos las respuestas
                        foreach($opciones as $opcion){
                            //echo "opcion: ".$opcion."<br>";
        
                            if($x == 1){
                                $opciones_list .= '[';
                                $opciones_list .= $opcion;
                            }else{
                                $opciones_list .= ','.$opcion;
                            }
                
                            if($x == $total_opciones){
                                $opciones_list .= ']';
                                $x=1;
                            }
        
                            $x++;
                        }

                        // Verificamos las respuestas anteriores OLD
                        $total_opciones_old = count($this->request->getPost('opcion_old_'.$key));
                        $opciones_old = $this->request->getPost('opcion_old_'.$key);
                        $x = 1;
        
                        // Armamos las respuestas OLD
                        foreach($opciones_old as $opcion_old){
                            //echo "opcion: ".$opcion."<br>";
        
                            if($x == 1){
                                $opciones_list_old .= '[';
                                $opciones_list_old .= $opcion_old;
                            }else{
                                $opciones_list_old .= ','.$opcion_old;
                            }
                
                            if($x == $total_opciones_old){
                                $opciones_list_old .= ']';
                                $x=1;
                            }
        
                            $x++;
                        }

                        // verificamos si cambiaron las respuestas actualues con las respuestas anteriores
                        if($opciones_list != $opciones_list_old){
                            $tiebreakers_put['options'] = $opciones_list;
                        }

                        $opciones_list = '';
                        $opciones_list_old = '';

                        //echo "tiebreakers_put - preguntas y respuestas <br>";
                        //echo "<pre>", var_dump($tiebreakers_put), "</pre>";
        

                        // Hacemos el PUT de las preguntas y respuestas al pool           
                        if(!is_null($tiebreakers_put)){
                            
                            try {
                                $res = $client->request('PUT',APP_URL.'tiebreaker_rules/'.$pregunta_id[$key],
                                [
                                    'headers' => [
                                        'Accept' => 'application/json',
                                        'Authorization' => $session->token
                                    ],
                                    'json' => $tiebreakers_put
                                ]);

                                $tiebreakers_upd = json_decode($res->getBody());
                                $response['tiebreakers_upd'] = $tiebreakers_upd;

                            } catch (\Exception $e) {
                                //exit($e->getMessage());
                                $response['tiebreakers_upd'] = 'fallo al actualizar los tiebreakers';
                            }
                            
                        } // END if
                        
                        //echo "response <br>";
                        //echo "<pre>", var_dump($response), "</pre>";

                    }else{

                        unset($tiebreakers_put['question']);
                        unset($tiebreakers_put['options']);


                        // Verificamos si solo cambiaron las respuestas
                        $total_opciones = count($this->request->getPost('opcion_'.$key));
                        $opciones = $this->request->getPost('opcion_'.$key);
                        $x = 1;
        
                        // Armamos las respuestas
                        foreach($opciones as $opcion){
                            //echo "opcion: ".$opcion."<br>";
        
                            if($x == 1){
                                $opciones_list .= '[';
                                $opciones_list .= $opcion;
                            }else{
                                $opciones_list .= ','.$opcion;
                            }
                
                            if($x == $total_opciones){
                                $opciones_list .= ']';
                                $x=1;
                            }
        
                            $x++;
                        }

                        // Verificamos las respuestas anteriores OLD
                        $total_opciones_old = count($this->request->getPost('opcion_old_'.$key));
                        $opciones_old = $this->request->getPost('opcion_old_'.$key);
                        $x = 1;
        
                        // Armamos las respuestas OLD
                        foreach($opciones_old as $opcion_old){
                            //echo "opcion: ".$opcion."<br>";
        
                            if($x == 1){
                                $opciones_list_old .= '[';
                                $opciones_list_old .= $opcion_old;
                            }else{
                                $opciones_list_old .= ','.$opcion_old;
                            }
                
                            if($x == $total_opciones_old){
                                $opciones_list_old .= ']';
                                $x=1;
                            }
        
                            $x++;
                        }

                        // verificamos si cambiaron las respuestas actualues con las respuestas anteriores
                        if($opciones_list != $opciones_list_old){
                            $tiebreakers_put['options'] = $opciones_list;
                        }

                        $opciones_list = '';
                        $opciones_list_old = '';

                        //echo "tiebreakers_put - solo respuestas <br>";
                        //echo "<pre>", var_dump($tiebreakers_put), "</pre>";

                        // Hacemos el PUT de las respuestas que cambiaron al pool
                        if(!is_null($tiebreakers_put)){
                            
                            try {
                                $res = $client->request('PUT',APP_URL.'tiebreaker_rules/'.$pregunta_id[$key],
                                [
                                    'headers' => [
                                        'Accept' => 'application/json',
                                        'Authorization' => $session->token
                                    ],
                                    'json' => $tiebreakers_put
                                ]);

                                $tiebreakers_upd = json_decode($res->getBody());
                                $response['tiebreakers_upd'] = $tiebreakers_upd;

                            } catch (\Exception $e) {
                                //exit($e->getMessage());
                                $response['tiebreakers_upd'] = 'fallo al actualizar los tiebreakers';
                            }
                            
                        } // END if
                        

                        //echo "response <br>";
                        //echo "<pre>", var_dump($response), "</pre>";

                    }


                    //echo "tiebreakers_upd PUT <br>";
                    //echo "<pre>", var_dump($tiebreakers_put), "</pre>";                


                }else{
                    // Es pregunta nueva
                    //echo "es pregunta nueva <br>";
                    //echo "question_".$key.": ".$questions[$key]."<br>";
                    //echo "------------------------<br>";

                    $total_opciones = count($this->request->getPost('opcion_'.$key));
                    $opciones = $this->request->getPost('opcion_'.$key);
                    $x = 1;

                    // Armamos las respuestas para hacer el POST
                    foreach($opciones as $opcion){
                        //echo "opcion: ".$opcion."<br>";

                        if($x == 1){
                            $opciones_list .= '[';
                            $opciones_list .= $opcion;
                        }else{
                            $opciones_list .= ','.$opcion;
                        }
            
                        if($x == $total_opciones){
                            $opciones_list .= ']';
                            $x=1;
                        }

                        $x++;
                    }

                    $tiebreakers[] = array(
                        'question' => $value,
                        'options' => $opciones_list
                    );

                    $opciones_list = '';

                    //echo "tiebreakers_add POST <br>";
                    //echo "<pre>", var_dump($tiebreakers), "</pre>";
                    //echo "pool_id: ".$pool_id."<br>";
                    
                    // Agregamos tiebreakers nuevos al pool POST
                    if(!is_null($tiebreakers)){
                        
                        try {
                            $res = $client->request('POST',APP_URL.'tiebreaker_rules',
                            [
                                'headers' => [
                                    'Accept' => 'application/json',
                                    'Authorization' => $session->token
                                ],
                                'json' => [
                                    'pool_id' => intval($pool_id),
                                    'tiebreakers' => $tiebreakers
                                ]
                            ]);

                            $code = $res->getStatusCode();
                            $tiebreakers_add = json_decode($res->getBody());
                            $response['tiebreakers_add'] = $tiebreakers_add;

                            //echo "code: ".$code."<br>";
                            //echo "<pre>", var_dump($response), "</pre>";

                        } catch (\Exception $e) {
                            //exit($e->getMessage());
                            $response['tiebreakers_add'] = 'fallo al agregar';
                        }
                        
                        
                    } // END if
                    
                    
                }
            } // foreach
        } // if

        // echo "matches_upd PUT <br>";
        // echo "<pre>", var_dump($matches_upd), "</pre>";
        // echo "-------------------<br><br>";

        // echo "matches_add POST <br>";
        // echo "pool_id: ".$pool_id."<br>";
        // echo "<pre>", var_dump($matches_add), "</pre>";

        // Agregamos partidos al pool POST
        
        if(!is_null($matches_add)){
            //echo "entro a matches add <br>";
            
            try {
                $res = $client->request('POST',APP_URL.'pool-matches',
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => $session->token
                    ],
                    'json' => [
                        'pool_id' => intval($pool_id),
                        'matches' => $matches_add
                    ]
                ]);

                $pools_add = json_decode($res->getBody());
                $response['matches_add'] = $pools_add;

            } catch (\Exception $e) {
                //exit($e->getMessage());
                $response['matches_add'] = 'fallo al agregar';
            }
            
        }else{
            $response['matches_add'] = null;
        }
        

        //echo "response <br>";
        //echo "<pre>", var_dump($response), "</pre>";

        $data_breadcrumb = array(
            'title' => 'Quiniela - Actualizando',
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
        echo view('pools/update',$data);
        echo view('templates/footer',$data_breadcrumb);

    }

    public function delete() {

        $pool_id = $this->request->getPost('pool_id');

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('DELETE',APP_URL.'pools/'.$pool_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);

            $pools = json_decode($res->getBody());
            $response = $pools;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }

        return json_encode($response);
    }

    public function remove_match() {

        $pool_match_id = $this->request->getPost('pool_match_id');
        $pool_id = $this->request->getPost('pool_id');

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('DELETE',APP_URL.'pool/'.$pool_id.'/match/'.$pool_match_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);

            $pools = json_decode($res->getBody());
            $response = $pools;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = $e->getMessage();
        }

        return json_encode($response);
    }

    public function list() {

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('GET',APP_URL.'pools',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);

            $pools = json_decode($res->getBody());
            $response = $pools;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }

        return json_encode($response);
    }

    public function list_pools($pool_id = '') {
    
        $client = \Config\Services::curlrequest();
        $session = session();
    
        try {
            $res = $client->request('GET',APP_URL.'pools/preview/info/'.$pool_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);
    
            $pools = json_decode($res->getBody());
            $response = $pools;
    
        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }
    
        return json_encode($response);
    }

    public function list_phases() {

        $pool_id = $this->request->getVar('pool_id');
        $phase_id = $this->request->getVar('phase_id');
    
        $client = \Config\Services::curlrequest();
        $session = session();
    
        try {
            $res = $client->request('GET',APP_URL.'pools/preview/info/'.$pool_id.'?phase_id='.$phase_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);
    
            $phase = json_decode($res->getBody());
            $response = $phase;
    
        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }
    
        return json_encode($response);
    }

    // Calificar las preguntas
    public function tiebreakers() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";

        $opciones = $this->request->getPost('opcion');
        $opciones_old = $this->request->getPost('opcion_old');
        $total_opciones = count($opciones);

        //echo "total_opciones: ".$total_opciones."<br>";

        $client = \Config\Services::curlrequest();
        $session = session();

        foreach($opciones as $key => $value){
            //echo "key: ".$key."<br>";
            //echo "value: ".$value."<br>";

            if($opciones[$key] != $opciones_old[$key]){
                //echo "existe un cambio en la respuesta <br>";

                try {
                    $res = $client->request('PUT',APP_URL.'tiebreaker_rules/'.$key,
                    [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Authorization' => $session->token
                        ],
                        'json' => [
                            'answer' => $value
                        ]
                    ]);
            
                    $tiebreakers = json_decode($res->getBody());
                    $response[] = $tiebreakers;
            
                } catch (\Exception $e) {
                    //exit($e->getMessage());
                    $response[] = null;
                }                

            }else{
                //echo "no cambio el resultado de la respuesta <br>";
            }

        } // END for
        
        $data_breadcrumb = array(
            'title' => 'Quiniela - Calificando preguntas',
            'icon' => '<i class="fas fa-list-ul"></i>'
        );

        $data = array(
            'response' => $response
        );

        //echo "<pre>", var_dump($data), "</pre>";

        echo view('templates/header');
        echo view('templates/nav-top');
        echo view('templates/nav-aside',$data_breadcrumb);
        echo view('templates/breadcrumb',$data_breadcrumb);
        echo view('pools/tiebreakers',$data);
        echo view('templates/footer',$data_breadcrumb);
    }

    // Modificar el icono del deporte de la quiniela
    public function sport_pool() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";

        $pool_id = $this->request->getPost('pool_id');
        $sport_id = $this->request->getPost('sport_id');

        $client = \Config\Services::curlrequest();
        $session = session();

        
        try {
            $res = $client->request('PUT',APP_URL.'pools/'.$pool_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ],
                'json' => [
                    'sport_id' => $sport_id
                ]
            ]);
    
            $status = json_decode($res->getBody());
            $response[] = $status;
    
        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response[] = null;
        }
              
      
        return json_encode($response);
    }


    // Modificar el estatus de la quiniela
    public function status() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";

        $pool_id = $this->request->getPost('pool_id');
        $status = $this->request->getPost('status');

        $client = \Config\Services::curlrequest();
        $session = session();

        
        try {
            $res = $client->request('PUT',APP_URL.'pools/'.$pool_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ],
                'json' => [
                    'status' => $status
                ]
            ]);
    
            $status = json_decode($res->getBody());
            $response[] = $status;
    
        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response[] = null;
        }
              
      
        return json_encode($response);
    }

    
    // Listado de las fases de una quiniela
    public function phases() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";

        $pool_id = $this->request->getPost('pool_id');

        $client = \Config\Services::curlrequest();
        $session = session();

        
        try {
            $res = $client->request('GET',APP_URL.'pools/phases/'.$pool_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);
    
            $respuesta = json_decode($res->getBody());
            $response[] = $respuesta;
    
        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response[] = null;
        }
        
        return json_encode($response);
    }


    //Agregar otra fase a una quiniela
    public function phases_add() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";

        //$response = var_dump($this->request->getPost());

        $pool_id = $this->request->getPost('pool_id');
        $phase_name = $this->request->getPost('phase_name');

        // Fecha de inicio
        $fecha_inicio_cumulative = $this->request->getPost('fecha_inicio_cumulative');
        $horario_inicio_cumulative = $this->request->getPost('horario_inicio_cumulative');

        $fecha_inicio_is_cumulative = $fecha_inicio_cumulative.' '.$horario_inicio_cumulative;

        // Fecha de finalización
        $fecha_fin_cumulative = $this->request->getPost('fecha_fin_cumulative');
        $horario_fin_cumulative = $this->request->getPost('horario_fin_cumulative');

        $fecha_fin_is_cumulative = $fecha_fin_cumulative.' '.$horario_fin_cumulative;

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('POST',APP_URL.'pools/phases',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ],
                'json' => [
                    'pool_id' => $pool_id,
                    'name' => $phase_name,
                    'start_date' => $fecha_inicio_is_cumulative,
                    'end_date' => $fecha_fin_is_cumulative
                ]
            ]);
    
            $respuesta = json_decode($res->getBody());
            $response[] = $respuesta;
    
        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response[] = $e->getMessage();
        }
        
        
        return json_encode($response);
    }

    public function update_phase() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";

        // inputs
        $pool_id = $this->request->getPost('pool_id_phases');
        $phase_id = $this->request->getPost('phase_id_new');

        $phase_step = $this->request->getPost('phase_step');

        if(isset($phase_step) && $phase_step == 'edit'){

            $phase_name = $this->request->getPost('phase_name_phases');

            // Fecha de inicio
            $fecha_inicio_cumulative = $this->request->getPost('fecha_inicio_cumulative_phases');
            $horario_inicio_cumulative = $this->request->getPost('horario_inicio_cumulative_phases');

            $fecha_inicio_is_cumulative = $fecha_inicio_cumulative.' '.$horario_inicio_cumulative;

            // Fecha de finalización
            $fecha_fin_cumulative = $this->request->getPost('fecha_fin_cumulative_phases');
            $horario_fin_cumulative = $this->request->getPost('horario_fin_cumulative_phases');

            $fecha_fin_is_cumulative = $fecha_fin_cumulative.' '.$horario_fin_cumulative;

            // inputs old
            $phase_name_old = $this->request->getPost('phase_name_phases_old');

            // Fecha de inicio
            $fecha_inicio_cumulative_old = $this->request->getPost('fecha_inicio_cumulative_phases_old');
            $horario_inicio_cumulative_old = $this->request->getPost('horario_inicio_cumulative_phases_old');

            $fecha_inicio_is_cumulative_old = $fecha_inicio_cumulative_old.' '.$horario_inicio_cumulative_old;

            // Fecha de finalización
            $fecha_fin_cumulative_old = $this->request->getPost('fecha_fin_cumulative_phases_old');
            $horario_fin_cumulative_old = $this->request->getPost('horario_fin_cumulative_phases_old');

            $fecha_fin_is_cumulative_old = $fecha_fin_cumulative_old.' '.$horario_fin_cumulative_old;
            

            $arr_json = array();

            // Armamos el arreglo con los cambios
            if($phase_name != $phase_name_old){
                $arr_json['name'] = $phase_name;
            }

            if($fecha_inicio_is_cumulative != $fecha_inicio_is_cumulative_old){
                $arr_json['start_date'] = $fecha_inicio_is_cumulative;
            }
            if($fecha_fin_is_cumulative != $fecha_fin_is_cumulative_old){
                $arr_json['end_date'] = $fecha_fin_is_cumulative;
            }
        } // END if



        //echo "arr_json <br>";
        //echo "<pre>", var_dump($arr_json), "</pre>";

        // Armamos los matches que se modificaron
        // Matches
        $matches_add = null;
        $matches_upd = null;
        $arr_matches_old = null;
        $response['tiebreakers_add'] = null;
        $response['tiebreakers_upd'] = null;

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
        $arr_pool_match = $this->request->getPost('pool_match_id');

        //echo "<pre>", var_dump($arr_matches), "</pre>"; 

        if($arr_matches != NULL){
            // Partidos únicos, quitamos los repetidos
            $distinct_arr_matches = array_unique($arr_matches);

            //echo "<pre>", var_dump($arr_matches), "</pre>"; 


            foreach($distinct_arr_matches as $match_id){
                //echo "match_id: ".$match_id."<br>";
                
                // Buscamos si existe el match para hacer PUT (Ejemplo: brackets)
                if( isset($arr_matches_old) && $arr_matches_old != null && $arr_matches_old[$match_id] == 'checked'){


                }else{
                    // match para hacer POST
                    $matches_add[] = array(
                        "id" => intval($match_id)
                    );
                }
            }
            //echo "<pre>", var_dump($matches_add), "</pre>"; 
        } // END if
        


        // Tiebreakers
        $tiebreakers = null;
        $tiebreakers_put = null;
        $opciones_list = '';
        $opciones_list_old = '';

        // Preguntas
        $questions = $this->request->getPost('pregunta');
        $pregunta_old = $this->request->getPost('pregunta_old');
        $pregunta_id = $this->request->getPost('pregunta_id');
        
        //echo "questions: ".$questions."<br>";

        $type_question = gettype($questions);
        //echo "type_question: ".$type_question."<br>";

        $total_preguntas = 1;
        if( isset($type_question) && ($type_question == 'null' || $type_question == 'NULL') ) {
            //echo "entro <br>";
            $questions = array();
            $total_preguntas = 0;
        }
        

        if(isset($total_preguntas) && $total_preguntas > 0){
            //echo "total_preguntas: ".$total_preguntas."<br>";
            //echo "<pre>", var_dump($questions), "</pre>"; 

            // Armamos las preguntas
            foreach($questions as $key => $value){
                //echo "key: ".$key."<br>";
                //echo "value: ".$value."<br>";

                // Verificamos si existen las preguntas old
                if( isset( $pregunta_old[$key] ) ) {
                    //echo "entro a preguntas old, para validar cambios <br>";
                    //echo "actualizar pregunta <br>";
                    //echo "question_".$key.": ".$questions[$key]."<br>";
                    //echo "pregunta_old_".$key.": ".$pregunta_old[$key]."<br>";
                    //echo "------------------------<br>";

                    // Verificamos si cambio la pregunta
                    if( $questions[$key] != $pregunta_old[$key] ){
                        //echo "cambio la pregunta <br>";
                        $tiebreakers_put['question'] = $questions[$key];
                        unset($tiebreakers_put['options']);

                        // Verificamos si cambiaron las respuestas
                        $total_opciones = count($this->request->getPost('opcion_'.$key));
                        $opciones = $this->request->getPost('opcion_'.$key);
                        $x = 1;
        
                        // Armamos las respuestas
                        foreach($opciones as $opcion){
                            //echo "opcion: ".$opcion."<br>";
        
                            if($x == 1){
                                $opciones_list .= '[';
                                $opciones_list .= $opcion;
                            }else{
                                $opciones_list .= ','.$opcion;
                            }
                
                            if($x == $total_opciones){
                                $opciones_list .= ']';
                                $x=1;
                            }
        
                            $x++;
                        }

                        // Verificamos las respuestas anteriores OLD
                        $total_opciones_old = count($this->request->getPost('opcion_old_'.$key));
                        $opciones_old = $this->request->getPost('opcion_old_'.$key);
                        $x = 1;
        
                        // Armamos las respuestas OLD
                        foreach($opciones_old as $opcion_old){
                            //echo "opcion: ".$opcion."<br>";
        
                            if($x == 1){
                                $opciones_list_old .= '[';
                                $opciones_list_old .= $opcion_old;
                            }else{
                                $opciones_list_old .= ','.$opcion_old;
                            }
                
                            if($x == $total_opciones_old){
                                $opciones_list_old .= ']';
                                $x=1;
                            }
        
                            $x++;
                        }

                        // verificamos si cambiaron las respuestas actualues con las respuestas anteriores
                        if($opciones_list != $opciones_list_old){
                            echo "cambiaron las respuestas <br>";
                            $tiebreakers_put['options'] = $opciones_list;
                        }

                        $opciones_list = '';
                        $opciones_list_old = '';

                        //echo "tiebreakers_put - preguntas y respuestas <br>";
                        //echo "<pre>", var_dump($tiebreakers_put), "</pre>";
        

                        // Hacemos el PUT de las preguntas y respuestas al pool           
                        if(!is_null($tiebreakers_put)){
                            //echo "Hacemos el PUT de las preguntas y respuestas al pool <br>";

                            $client = \Config\Services::curlrequest();
                            $session = session();                
                            
                            try {
                                $res = $client->request('PUT',APP_URL.'tiebreaker_rules/'.$pregunta_id[$key],
                                [
                                    'headers' => [
                                        'Accept' => 'application/json',
                                        'Authorization' => $session->token
                                    ],
                                    'json' => $tiebreakers_put
                                ]);

                                $tiebreakers_upd = json_decode($res->getBody());
                                $response['tiebreakers_upd'] = $tiebreakers_upd;

                            } catch (\Exception $e) {
                                //exit($e->getMessage());
                                $response['tiebreakers_upd'] = 'fallo al actualizar los tiebreakers';
                            }
                            
                        } // END if
                        
                        //echo "response <br>";
                        //echo "<pre>", var_dump($response), "</pre>";

                    }else{
                        //echo "No cambiaron las pregunta, verificamos si cambio alguna respuesta <br>"; 

                        unset($tiebreakers_put['question']);
                        unset($tiebreakers_put['options']);


                        // Verificamos si solo cambiaron las respuestas
                        $total_opciones = count($this->request->getPost('opcion_'.$key));
                        $opciones = $this->request->getPost('opcion_'.$key);
                        $x = 1;
        
                        // Armamos las respuestas
                        foreach($opciones as $opcion){
                            //echo "opcion: ".$opcion."<br>";
        
                            if($x == 1){
                                $opciones_list .= '[';
                                $opciones_list .= $opcion;
                            }else{
                                $opciones_list .= ','.$opcion;
                            }
                
                            if($x == $total_opciones){
                                $opciones_list .= ']';
                                $x=1;
                            }
        
                            $x++;
                        }

                        // Verificamos las respuestas anteriores OLD
                        $total_opciones_old = count($this->request->getPost('opcion_old_'.$key));
                        $opciones_old = $this->request->getPost('opcion_old_'.$key);
                        $x = 1;
        
                        // Armamos las respuestas OLD
                        foreach($opciones_old as $opcion_old){
                            //echo "opcion: ".$opcion."<br>";
        
                            if($x == 1){
                                $opciones_list_old .= '[';
                                $opciones_list_old .= $opcion_old;
                            }else{
                                $opciones_list_old .= ','.$opcion_old;
                            }
                
                            if($x == $total_opciones_old){
                                $opciones_list_old .= ']';
                                $x=1;
                            }
        
                            $x++;
                        }

                        // verificamos si cambiaron las respuestas actualues con las respuestas anteriores
                        if($opciones_list != $opciones_list_old){
                            //echo "cambiaron las respuestas <br>";
                            $tiebreakers_put['options'] = $opciones_list;
                        }

                        $opciones_list = '';
                        $opciones_list_old = '';

                        //echo "tiebreakers_put - solo respuestas <br>";
                        //echo "<pre>", var_dump($tiebreakers_put), "</pre>";

                        // Hacemos el PUT de las respuestas que cambiaron al pool
                        if(!is_null($tiebreakers_put)){
                            //echo "Hacemos el PUT de las respuestas que cambiaron al pool <br>";

                            $client = \Config\Services::curlrequest();
                            $session = session();                
                            
                            try {
                                $res = $client->request('PUT',APP_URL.'tiebreaker_rules/'.$pregunta_id[$key],
                                [
                                    'headers' => [
                                        'Accept' => 'application/json',
                                        'Authorization' => $session->token
                                    ],
                                    'json' => $tiebreakers_put
                                ]);

                                $tiebreakers_upd = json_decode($res->getBody());
                                $response['tiebreakers_upd'] = $tiebreakers_upd;

                            } catch (\Exception $e) {
                                //exit($e->getMessage());
                                $response['tiebreakers_upd'] = 'fallo al actualizar los tiebreakers';
                                echo $e->getMessage();
                            }
                            
                        } // END if
                        

                        //echo "response <br>";
                        //echo "<pre>", var_dump($response), "</pre>";

                    }


                    //echo "tiebreakers_upd PUT <br>";
                    //echo "<pre>", var_dump($tiebreakers_put), "</pre>";                


                }else{
                    // Es pregunta nueva

                    //echo "es pregunta nueva <br>";
                    //echo "question_".$key.": ".$questions[$key]."<br>";
                    //echo "------------------------<br>";

                    $total_opciones = count($this->request->getPost('opcion_'.$key));
                    $opciones = $this->request->getPost('opcion_'.$key);
                    $x = 1;

                    // Armamos las respuestas para hacer el POST
                    foreach($opciones as $opcion){
                        //echo "opcion: ".$opcion."<br>";

                        if($x == 1){
                            $opciones_list .= '[';
                            $opciones_list .= $opcion;
                        }else{
                            $opciones_list .= ','.$opcion;
                        }
            
                        if($x == $total_opciones){
                            $opciones_list .= ']';
                            $x=1;
                        }

                        $x++;
                    }

                    $tiebreakers[] = array(
                        'question' => $value,
                        'options' => $opciones_list
                    );

                    $opciones_list = '';

                    //echo "tiebreakers_add POST <br>";
                    //echo "<pre>", var_dump($tiebreakers), "</pre>";
                    //echo "pool_id: ".$pool_id."<br>";
                    
                } // else
            } // foreach
        } // if

        // Agregamos tiebreakers nuevos al pool POST
        if(!is_null($tiebreakers)){
            //echo "Agregamos tiebreakers nuevos al pool POST <br>";

            $client = \Config\Services::curlrequest();
            $session = session();            
            
            try {
                $res = $client->request('POST',APP_URL.'tiebreaker_rules',
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => $session->token
                    ],
                    'json' => [
                        'pool_id' => intval($pool_id),
                        'pool_phase_id' => intval($phase_id),
                        'tiebreakers' => $tiebreakers
                    ]
                ]);

                $code = $res->getStatusCode();
                $tiebreakers_add = json_decode($res->getBody());
                $response['tiebreakers_add'] = $tiebreakers_add;

                //echo "code: ".$code."<br>";
                //echo "<pre>", var_dump($response), "</pre>";

            } catch (\Exception $e) {
                //exit($e->getMessage());
                $response['tiebreakers_add'] = 'fallo al agregar preguntas';
                echo $e->getMessage();
            }
            
            
        }else{
            $response['tiebreakers_add'] = 'no hay preguntas nuevas para agregar o modificar';
        }
    

        //echo "matches_upd PUT <br>";
        //echo "<pre>", var_dump($matches_upd), "</pre>";
        //echo "-------------------<br><br>";

        //echo "matches_add POST <br>";
        //echo "pool_id: ".$pool_id."<br>";
        //echo "<pre>", var_dump($matches_add), "</pre>";

        // Agregamos partidos al pool POST
        
        if(!is_null($matches_add)){

            //$distinct_matches_add = array_unique($matches_add);
            //echo "<pre>", var_dump($distinct_matches_add), "</pre>";

            $client = \Config\Services::curlrequest();
            $session = session();    
            
            try {
                $res = $client->request('POST',APP_URL.'pool-matches',
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => $session->token
                    ],
                    'json' => [
                        'pool_id' => intval($pool_id),
                        'pool_phase_id' => intval($phase_id),
                        'matches' => $matches_add
                    ]
                ]);

                $pools_add = json_decode($res->getBody());
                $response['matches_add'] = $pools_add;

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
            'title' => 'Quiniela Fase - Actualizando',
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
        echo view('pools/update_phase',$data);
        echo view('templates/footer',$data_breadcrumb);

    }

    // Listado de las fases de una quiniela
    public function delete_tiebreaker() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";

        $tiebreaker_id = $this->request->getPost('tiebreaker_id');

        $client = \Config\Services::curlrequest();
        $session = session();

        
        try {
            $res = $client->request('DELETE',APP_URL.'tiebreaker_rules/'.$tiebreaker_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);
    
            $respuesta = json_decode($res->getBody());
            $response[] = $respuesta;
    
        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response[] = null;
        }
        
        return json_encode($response);
    }

}