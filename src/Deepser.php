<?php
/**
 * @copyright      Copyright (c) 2019
 */

namespace Deepser;


final class Deepser
{
    static private $_adapter = null;
    static private $_client = null;
    static private $_host = null;
    static private $_username = null;
    static private $_password = null;

    public static function init($host = null, $username = null, $password = null){
        if($host){
            self::$_host = $host;
        }
        if($username){
            self::$_username = $username;
        }
        if($password){
            self::$_password = $password;
        }
    }

    public static function setHost($host){
        self::$_host = $host;
    }

    public static function setUsername($user){
        self::$_username = $user;
    }

    public static function setPassword($password){
        self::$_password = $password;
    }

    public static function getAdapter(){
        if(self::$_adapter == null){
            self::$_adapter = new \Deepser\Adapter\GuzzleHttpAdapter(self::$_host, self::getClient());
        }

        return self::$_adapter;
    }

    /**
     * @return \GuzzleHttp\Client|null
     */
    public static function getClient(){
        if(self::$_client == null){
            self::$_client = new \GuzzleHttp\Client([
                'verify' => false,
                'debug' => false,
                'timeout' => 300,
                'connect_timeout' => 300,
                'read_timeout' => 300,
                'headers' => self::getHeaders()
            ]);
        }

        return self::$_client;
    }

    /**
     * @return array
     */
    public static function getHeaders(){
        $token = base64_encode(self::$_username . ":" . self::$_password);
        return [
            'Authorization' => 'Basic ' . $token,
            'Accept'        => 'application/json',
        ];
    }
}