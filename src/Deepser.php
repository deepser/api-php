<?php
/**
 * @copyright      Copyright (c) 2019
 */

namespace Deepser;


final class Deepser
{
    const AUTH_BASIC = 'basic';
    const AUTH_TOKEN = 'token';

    static private $_adapter = null;
    static private $_client = null;
    static private $_host = null;
    static private $_authType = null;
    static private $_token = null;
    static private $_username = null;
    static private $_password = null;

    /**
     * @param null $host
     * @param null $username
     * @param null $password
     */
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

        if($username && $password){
            self::$_authType = self::AUTH_BASIC;
        }else{
            self::$_authType = self::AUTH_TOKEN;
            self::setToken($username);
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

    public static function setToken($token){
        self::$_token = $token;
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
        $headers = [
            'Accept'        => 'application/json'
        ];
        if(self::$_authType == self::AUTH_BASIC){
            $headers['Authorization'] = 'Basic ' . $token;
        }else{
            $headers['Authorization'] = 'Bearer ' . self::$_token;
        }

        return $headers;
    }
}