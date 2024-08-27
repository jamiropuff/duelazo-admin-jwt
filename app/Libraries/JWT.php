<?php 

namespace App\Libraries;
use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;

class JWT {
    
    protected $key;

    public function __construct() {
        $this->key = '.z?S?+MxuEY0f89mUxTRP*HzUn-u97rSC#c%3Wk94zvn$y-cFG';  // Cambiar por una clave segura
    }

    public function encode($payload) {
        return FirebaseJWT::encode($payload, $this->key, 'HS256');
    }

    public function decode($token) {
        return FirebaseJWT::decode($token, $this->key, array('HS256'));
    }
    
}