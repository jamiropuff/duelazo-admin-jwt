<?php

namespace App\Controllers;

class MatchesController extends BaseController
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

    public function matches() {

        $resources = json_decode($this->resources());
        
        $data_breadcrumb = array(
            'title' => 'Partidos',
            'icon' => '<i class="far fa-calendar-alt"></i>'
        );

        $data = array(
            'resources' => $resources
        );

        echo view('templates/header');
        echo view('templates/nav-top');
        echo view('templates/nav-aside',$data_breadcrumb);
        echo view('templates/breadcrumb',$data_breadcrumb);
        echo view('matches/default',$data);
        echo view('templates/footer',$data_breadcrumb);
    }

    public function save() {

        $league_id = $this->request->getPost('league_id');
        $local_team = $this->request->getPost('local_team');
        $visitor_team = $this->request->getPost('visitor_team');
        $start_date = $this->request->getPost('start_date');
        $start_time = $this->request->getPost('start_time');
        $spread = $this->request->getPost('spread');
        $sport_id = $this->request->getPost('sport_id');

        $date_time = $start_date.' '.$start_time;

        $client = \Config\Services::curlrequest();
        $session = session();

        try {
            $res = $client->request('POST',APP_URL.'matches',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->token
                ],
                'json' => [
                    'local_team_id' => $local_team,
                    'visitor_team_id' => $visitor_team,
                    'start_date' => $date_time,
                    'league_id' => $league_id,
                    'spread' => $spread
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

    public function update() {

        // inputs
        $match_id = $this->request->getPost('match_id');
        $sport_id = $this->request->getPost('sport_id');

        $league_id = $this->request->getPost('league_id');
        $local_team = $this->request->getPost('local_team');
        $visitor_team = $this->request->getPost('visitor_team');
        $start_date = $this->request->getPost('start_date');
        $start_time = $this->request->getPost('start_time');
        $spread = $this->request->getPost('spread');

        $local_team_score = $this->request->getPost('local_team_score');
        $visitor_team_score = $this->request->getPost('visitor_team_score');
        $status_edit = $this->request->getPost('status_edit');
        $result_edit = $this->request->getPost('result_edit');

        // inputs old
        $league_edit_id_old = $this->request->getPost('league_edit_id_old');
        $local_team_edit_old = $this->request->getPost('local_team_edit_old');
        $visitor_team_edit_old = $this->request->getPost('visitor_team_edit_old');
        $start_date_edit_old = $this->request->getPost('start_date_edit_old');
        $start_time_edit_old = $this->request->getPost('start_time_edit_old');
        $spread_edit_old = $this->request->getPost('spread_edit_old');

        $local_team_score_old = $this->request->getPost('local_team_score_old');
        $visitor_team_score_old = $this->request->getPost('visitor_team_score_old');
        $status_edit_old = $this->request->getPost('status_edit_old');
        $result_edit_old = $this->request->getPost('result_edit_old');

        $date_time = $start_date.' '.$start_time;
        $date_time_old = $start_date_edit_old.' '.$start_time_edit_old;

        $arr_json = array();

        if($league_id != $league_edit_id_old){
            $arr_json['league_id'] = intval($league_id);
        }
        
        if($local_team != $local_team_edit_old){
            $arr_json['local_team_id'] = intval($local_team);
        }
        
        //$arr_json['local_team_id'] = intval($local_team);

        if($visitor_team != $visitor_team_edit_old){
            $arr_json['visitor_team_id'] = intval($visitor_team);
        }
        
        //$arr_json['visitor_team_id'] = intval($visitor_team);

        if($date_time != $date_time_old){
            $arr_json['start_date'] = $date_time;
        }
        if($spread != $spread_edit_old){
            $arr_json['spread'] = $spread;
        }

        // Primera vez que se modifica el score
        if($local_team_score_old == ''){
            if($local_team_score != ''){
                $arr_json['local_team_score'] = intval($local_team_score);
            }
        }
        // Ya existe el score y se va a modificar
        else{
            if($local_team_score != $local_team_score_old){
                $arr_json['local_team_score'] = intval($local_team_score);
            }    
        }
        
        //$arr_json['local_team_score'] = intval($local_team_score);

        // Primera vez que se modifica el score
        if($visitor_team_score_old == ''){
            if($visitor_team_score != ''){
                $arr_json['visitor_team_score'] = intval($visitor_team_score);
            }
        }
        // Ya existe el score y se va a modificar
        else{
            if($visitor_team_score != $visitor_team_score_old){
                $arr_json['visitor_team_score'] = intval($visitor_team_score);
            }    
        }
        
        //$arr_json['visitor_team_score'] = intval($visitor_team_score);

        // Primera vez que se modifica el status
        if($status_edit_old == ''){
            if($status_edit != ''){
                $arr_json['status'] = $status_edit;
            }
        }
        // Ya existe el status y se va a modificar
        else{
            if($status_edit != $status_edit_old){
                $arr_json['status'] = $status_edit;
            }    
        }
        
        //$arr_json['status'] = $status_edit;

        // Primera vez que se modifica el result
        if($result_edit_old == ''){
            if($result_edit != ''){
                $arr_json['result'] = $result_edit;
            }
        }
        // Ya existe el result y se va a modificar
        else{
            if($result_edit != $result_edit_old){
                $arr_json['result'] = $result_edit;
            }    
        }
        
        //$arr_json['result'] = $result_edit;

        //$response = $arr_json;
        //$response = count($arr_json);

        
          
        if(count($arr_json) > 0){

            $client = \Config\Services::curlrequest();
            $session = session();

            try {
                $res = $client->request('PUT',APP_URL.'matches/'.$match_id,
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => $session->token
                    ],
                    'json' => $arr_json
                ]);

                $matches = json_decode($res->getBody());
                $response = $matches;

            } catch (\Exception $e) {
                //exit($e->getMessage());
                $response = $e->getMessage();
            }

        }
        

        return json_encode($response);
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