<?php

namespace App\Controllers;

class BracketsController extends BaseController
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

    public function brackets() {

        $resources = json_decode($this->resources());
        $leagues = json_decode($this->leagues());

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('GET',APP_URL.'brackets',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);

            $brackets = json_decode($res->getBody());
            $response = $brackets;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }

        $data_breadcrumb = array(
            'title' => 'Brackets',
            'icon' => '<i class="fas fa-sitemap"></i>'
        );

        $data = array(
            'resources' => $resources,
            'leagues' => $leagues,
            'brackets' => $brackets
        );

        echo view('templates/header');
        echo view('templates/nav-top');
        echo view('templates/nav-aside',$data_breadcrumb);
        echo view('templates/breadcrumb',$data_breadcrumb);
        echo view('brackets/default',$data);
        echo view('templates/footer',$data_breadcrumb);
    }

    public function save() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";

        // General Info
        $sponsor_id = $this->request->getPost('sponsor_id');
        $titulo = $this->request->getPost('titulo');
        $subtitulo = $this->request->getPost('subtitulo');
        $test = $this->request->getPost('test');

        if( isset($test) && $test == 'on' ){
            $test = true;
        }else{
            $test = false;
        }
        
        $fecha_inicio = $this->request->getPost('fecha_inicio');
        $horario_inicio = $this->request->getPost('horario_inicio');

        $fecha_fin = $this->request->getPost('fecha_fin');
        $horario_fin = $this->request->getPost('horario_fin');

        $fecha_limite = $this->request->getPost('fecha_limite');
        $horario_limite = $this->request->getPost('horario_limite');

        $start_date = $fecha_inicio.' '.$horario_inicio;
        $end_date = $fecha_fin.' '.$horario_fin;
        $limit_date = $fecha_limite.' '.$horario_limite;

        // Awards
        $awards = $this->request->getPost('awards');

        // Total awards
        $total_awards = $this->request->getPost('total_awards');

        $award_list = '';
        $physical_awards = null;

        for($x=1;$x<=$total_awards;$x++){
            $award = $this->request->getPost('award_'.$x);
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

        // Matches
        $matches = null;

        $arr_matches = $this->request->getPost('match_id');
        $arr_grupo = $this->request->getPost('grupo');
        $arr_jornada = $this->request->getPost('jornada');

        foreach($arr_matches as $match_id){
            //echo "match_id: ".$match_id."<br>";
            $matches[] = array(
                "match_id" => $match_id,
                "group" => $arr_grupo[$match_id],
                "phase" => $arr_jornada[$match_id]
            );
        }

        //echo "<pre>", var_dump($matches), "</pre>";

        //$date_time = $start_date.' '.$start_time;

        $client = \Config\Services::curlrequest();
        $session = session();

        //echo "token: ".$session->token."<br>";
        
        try {
            $res = $client->request('POST',APP_URL.'brackets',
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
                    'phase2_limit_date' => $limit_date,
                    'award' => $awards,
                    'awards' => $award_list,
                    'physical_awards' => $physical_awards,
                    'matches' => $matches
                ]
            ]);

            $code = $res->getStatusCode();
            $brackets = json_decode($res->getBody());
            $response = $brackets;

            //echo "code: ".$code."<br>";
            //echo "<pre>", var_dump($response), "</pre>";

        } catch (\Exception $e) {
            exit($e->getMessage());
            $response = null;
        }

        $data_breadcrumb = array(
            'title' => 'Brackets Fase 1 - Guardando...',
            'icon' => '<i class="fas fa-sitemap"></i>'
        );

        $data = array(
            'response' => $response
        );

        echo view('templates/header');
        echo view('templates/nav-top');
        echo view('templates/nav-aside',$data_breadcrumb);
        echo view('templates/breadcrumb',$data_breadcrumb);
        echo view('brackets/phase1-save',$data);
        echo view('templates/footer',$data_breadcrumb);

        //return json_encode($response);
    }

    public function update() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";

        // inputs
        $bracket_id = $this->request->getPost('bracket_edit_id');

        $title = $this->request->getPost('titulo_edit');
        $subtitle = $this->request->getPost('subtitulo_edit');
        
        $test = $this->request->getPost('test');
        if($test == 'on'){
            $test = 1;
        }else{
            $test = 0;
        }

        $sponsor_id = $this->request->getPost('sponsor_edit_id');

        $fecha_inicio = $this->request->getPost('fecha_inicio_edit');
        $horario_inicio = $this->request->getPost('horario_inicio_edit');

        $fecha_fin = $this->request->getPost('fecha_fin_edit');
        $horario_fin = $this->request->getPost('horario_fin_edit');

        $fecha_limite = $this->request->getPost('fecha_limite_edit');
        $horario_limite = $this->request->getPost('horario_limite_edit');

        $awards_edit = $this->request->getPost('awards_edit');

        $start_date = $fecha_inicio.' '.$horario_inicio;
        $end_date = $fecha_fin.' '.$horario_fin;
        $limit_date = $fecha_limite.' '.$horario_limite;

        // inputs old
        $title_old = $this->request->getPost('titulo_edit_old');
        $subtitle_old = $this->request->getPost('subtitulo_edit_old');
        
        $sponsor_id_old = $this->request->getPost('sponsor_edit_id_old');

        $fecha_inicio_old = $this->request->getPost('fecha_inicio_edit_old');
        $horario_inicio_old = $this->request->getPost('horario_inicio_edit_old');

        $fecha_fin_old = $this->request->getPost('fecha_fin_edit_old');
        $horario_fin_old = $this->request->getPost('horario_fin_edit_old');

        $fecha_limite_old = $this->request->getPost('fecha_limite_edit_old');
        $horario_limite_old = $this->request->getPost('horario_limite_edit_old');

        $start_date_old = $fecha_inicio_old.' '.$horario_inicio_old;
        $end_date_old = $fecha_fin_old.' '.$horario_fin_old;
        $limit_date_old = $fecha_limite_old.' '.$horario_limite_old;

        $arr_json = array();

        // Armamos el arreglo con los cambios
        if($title != $title_old){
            $arr_json['title'] = $title;
        }
        if($subtitle != $subtitle_old){
            $arr_json['subtitle'] = $subtitle;
        }
        $arr_json['test'] = $test;

        if($sponsor_id != $sponsor_id_old){
            $arr_json['sponsor_id'] = $sponsor_id;
        }
        if($start_date != $start_date_old){
            $arr_json['start_date'] = $start_date;
        }
        if($end_date != $end_date_old){
            $arr_json['end_date'] = $end_date;
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
        
        // Editamos los datos generales del Bracket
        if($total_arr_json > 3){
            try {
                $res = $client->request('PUT',APP_URL.'brackets/'.$bracket_id,
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => $session->token
                    ],
                    'json' => $arr_json
                ]);

                $brackets_general = json_decode($res->getBody());
                $response['bracket_info'] = $brackets_general;

            } catch (\Exception $e) {
                //exit($e->getMessage());
                $response['bracket_info'] = 'fallo al actualizar';
            }
        }

        //echo "response <br>";
        //echo "<pre>", var_dump($response), "</pre>";
        


        // Armamos los matches que se modificaron
        // Matches
        $matches_add = null;
        $matches_upd = null;

        // inputs
        $arr_matches = $this->request->getPost('match_edit_id');
        $arr_grupo = $this->request->getPost('grupo');
        $arr_jornada = $this->request->getPost('jornada');
        $arr_bracket_match = $this->request->getPost('bracket_match_id');

        // inputs old
        $arr_matches_old = $this->request->getPost('match_edit_old_id');
        $arr_grupo_old = $this->request->getPost('grupo_old');
        $arr_jornada_old = $this->request->getPost('jornada_old');

        foreach($arr_matches as $match_id){
            //echo "match_id: ".$match_id."<br>";
            
            // Buscamos si existe el match para hacer PUT
            if($arr_matches_old[$match_id] == 'checked'){

                // Buscamos si hubo algun cambio
                if($arr_grupo[$match_id] != $arr_grupo_old[$match_id] || $arr_jornada[$match_id] != $arr_jornada_old[$match_id]){

                    $id_bracket_match = $arr_bracket_match[$match_id];
                    //echo "id_bracket_match: ".$id_bracket_match."<br>";

                    $matches_upd[] = array(
                        "match_id" => $match_id,
                        "group" => $arr_grupo[$match_id],
                        "phase" => $arr_jornada[$match_id]
                    );

                    // Si existe un cambio en algun partido, lo actualizamos
                    try {
                        $res = $client->request('PUT',APP_URL.'brackets/phase-1/add-match/'.$id_bracket_match,
                        [
                            'headers' => [
                                'Accept' => 'application/json',
                                'Authorization' => $session->token
                            ],
                            'json' => [
                                'match_id' => $match_id,
                                'group' => $arr_grupo[$match_id],
                                'phase' => $arr_jornada[$match_id]
                            ]
                        ]);
        
                        $brackets_upd = json_decode($res->getBody());
                        $response['matches_update'] = $brackets_upd;
        
                    } catch (\Exception $e) {
                        //exit($e->getMessage());
                        $response['matches_update'] = 'fallo al actualizar';
                    }

                }
            }else{
                // match para hacer POST
                $matches_add[] = array(
                    "match_id" => $match_id,
                    "group" => $arr_grupo[$match_id],
                    "phase" => $arr_jornada[$match_id]
                );
            }
        }


        // echo "matches_upd <br>";
        // echo "<pre>", var_dump($matches_upd), "</pre>";
        // echo "-------------------<br><br>";

        // echo "matches_add <br>";
        // echo "bracket_id: ".$bracket_id."<br>";
        // echo "<pre>", var_dump($matches_add), "</pre>";
        


        // Agregamos partidos al bracket POST
        if(!is_null($matches_add)){
            
            try {
                $res = $client->request('POST',APP_URL.'brackets/phase-1/add-match',
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => $session->token
                    ],
                    'json' => [
                        'bracket_id' => $bracket_id,
                        'matches' => $matches_add
                    ]
                ]);

                $brackets_add = json_decode($res->getBody());
                $response['matches_add'] = $brackets_add;

            } catch (\Exception $e) {
                //exit($e->getMessage());
                $response['matches_add'] = 'fallo al agregar';
            }
            
        } // END if

        //echo "response <br>";
        //echo "<pre>", var_dump($response), "</pre>";

        $data_breadcrumb = array(
            'title' => 'Brackets Fase 1 - Actualizando',
            'icon' => '<i class="fas fa-sitemap"></i>'
        );

        $data = array(
            'response' => $response
        );

        echo view('templates/header');
        echo view('templates/nav-top');
        echo view('templates/nav-aside',$data_breadcrumb);
        echo view('templates/breadcrumb',$data_breadcrumb);
        echo view('brackets/phase1-update',$data);
        echo view('templates/footer',$data_breadcrumb);
        
    }

    public function delete() {

        $bracket_id = $this->request->getPost('bracket_id');

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('DELETE',APP_URL.'brackets/'.$bracket_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);

            $brackets = json_decode($res->getBody());
            $response = $brackets;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }

        return json_encode($response);
    }

    public function remove_match() {

        $bracket_match_id = $this->request->getPost('bracket_match_id');

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('DELETE',APP_URL.'brackets/phase-1/add-match/'.$bracket_match_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);

            $brackets = json_decode($res->getBody());
            $response = $brackets;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = $e->getMessage();
        }

        return json_encode($response);
    }

    public function list_brackets() {

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('GET',APP_URL.'brackets',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);

            $brackets = json_decode($res->getBody());
            $response = $brackets;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }

        return json_encode($response);
    }

    public function list_phase1($bracket_id = '') {

        //$bracket_id = $this->request->getPost('bracket_id');

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('GET',APP_URL.'brackets/phase-1/'.$bracket_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);

            $brackets = json_decode($res->getBody());
            $response = $brackets;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }

        return json_encode($response);
    }

    public function list_phase2($bracket_id = '') {

        //$bracket_id = $this->request->getPost('bracket_id');

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('GET',APP_URL.'brackets/phase-2/'.$bracket_id,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ]
            ]);

            $brackets = json_decode($res->getBody());
            $response = $brackets;

        } catch (\Exception $e) {
            //exit($e->getMessage());
            $response = null;
        }

        return json_encode($response);
    }


    public function phase2($bracket_id = '') {

        //echo "bracket_id: ".$bracket_id."<br>";

        $resources = json_decode($this->resources());
        $phase1 = json_decode($this->list_phase1($bracket_id));
        $phase2 = json_decode($this->list_phase2($bracket_id));

        $data_breadcrumb = array(
            'title' => 'Brackets Fase 2',
            'icon' => '<i class="fas fa-project-diagram"></i>'
        );

        $data = array(
            'resources' => $resources,
            'brackets_phase1' => $phase1,
            'brackets_phase2' => $phase2
        );

        echo view('templates/header');
        echo view('templates/nav-top');
        echo view('templates/nav-aside',$data_breadcrumb);
        echo view('templates/breadcrumb',$data_breadcrumb);
        echo view('brackets/phase2',$data);
        echo view('templates/footer',$data_breadcrumb);

    }

    public function phase2_save() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";
        
        $client = \Config\Services::curlrequest();
        $session = session();

        $arr_matches = null;
        $arr_json = null;

        // inputs
        for($i=1;$i<=15;$i++){
            ${"match_number_".$i} = $this->request->getPost('match_number_'.$i);

            unset($arr_json);
            $arr_json = null;

            if(isset(${"match_number_".$i}) && ${"match_number_".$i} > 0){
                $match_id = $this->request->getPost('match_id_'.$i);

                $local_team_id = $this->request->getPost('local_team_id_'.$i);
                $visitor_team_id = $this->request->getPost('visitor_team_id_'.$i);

                $local_team_old_id = $this->request->getPost('local_team_old_id_'.$i);
                $visitor_team_old_id = $this->request->getPost('visitor_team_old_id_'.$i);

                // Agregamos el match ID al arreglo
                if( $local_team_id > 0 && ($local_team_id != $local_team_old_id) || $visitor_team_id > 0 && ($visitor_team_id != $visitor_team_old_id)  ){
                    /*
                    echo "Match PUT <br>";
                    echo "----------------------<br>";
                    echo "match_number: ".${"match_number_".$i}."<br>";
                    echo "match_id: ".$match_id."<br>";
                    */
    
                    $arr_matches[$i]['match_id'] = $match_id;
                }

                
                
                // Agregamos el Local ID al arreglo
                if( $local_team_id > 0 && ($local_team_id != $local_team_old_id) ){
                    //echo "local_team_id: ".$local_team_id."<br>";
                    //echo "local_team_old_id: ".$local_team_old_id."<br>";

                    $arr_matches[$i]['local_team_id'] = $local_team_id;
                    $arr_json['local_team_id'] = intval($local_team_id);
                }

                // Agregamos el Visitor ID al arreglo
                if( $visitor_team_id > 0 && ($visitor_team_id != $visitor_team_old_id) ){
                    //echo "visitor_team_id: ".$visitor_team_id."<br>";
                    //echo "visitor_team_old_id: ".$visitor_team_old_id."<br>";

                    $arr_matches[$i]['visitor_team_id'] = $visitor_team_id;
                    $arr_json['visitor_team_id'] = intval($visitor_team_id);
                }
                //echo "----------------------<br>";

                //echo "<pre>", var_dump($arr_json), "</pre>";

                // Ejecutamos el PUT si hay algún cambio
                if( $local_team_id > 0 && ($local_team_id != $local_team_old_id) || $visitor_team_id > 0 && ($visitor_team_id != $visitor_team_old_id)  ){
                
                    try {
                        $res = $client->request('PUT',APP_URL.'matches/'.intval($match_id),
                        [
                            'headers' => [
                                'Accept' => 'application/json',
                                'Authorization' => $session->token
                            ],
                            'json' => $arr_json
                        ]);
            
                        $brackets = json_decode($res->getBody());
                        $response[$i] = $brackets;
        
                        //echo "<pre>", var_dump($response), "</pre>";
                        //echo "<br><br>";
            
                    } catch (\Exception $e) {
                        //exit($e->getMessage());
                        $response[$i] = $e->getMessage();
                        //echo "<pre>", var_dump($response), "</pre>";
                        //echo "<br><br>";
                    }
                } // END if
    
            } // END if

        } // END for

        $data_breadcrumb = array(
            'title' => 'Brackets Fase 2',
            'icon' => '<i class="fas fa-project-diagram"></i>'
        );
        
        $data = array(
            'brackets' => $arr_matches,
            'response' => $response
        );
        

        echo view('templates/header');
        echo view('templates/nav-top');
        echo view('templates/nav-aside',$data_breadcrumb);
        echo view('templates/breadcrumb',$data_breadcrumb);
        echo view('brackets/phase2-save',$data);
        echo view('templates/footer',$data_breadcrumb);

    }

    // Modificar el estatus de la quiniela
    public function status() {

        //echo "<pre>", var_dump($this->request->getPost()), "</pre>";

        $bracket_id = $this->request->getPost('bracket_id');
        $status = $this->request->getPost('status');

        $client = \Config\Services::curlrequest();
        $session = session();

        
        try {
            $res = $client->request('PUT',APP_URL.'brackets/'.$bracket_id,
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

}
