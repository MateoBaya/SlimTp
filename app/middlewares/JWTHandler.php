<?php

use Firebase\JWT\JWT;
class JWTHandler
{
    private static $secretPassword = 'dinosaurio';
    private static $encriptationType = ['HS256'];

    public static function CreateToken($data)
    {
        $now = time();
        $payload = array(
            'iat' => $now,
            'exp' => $now + (20000),
            'data' => $data,
            'app' => "1er Intento JWT"
        );
        return JWT::encode($payload, self::$secretPassword);
    }

    public static function ValidateToken($token)
    {
        if(empty($token))
        {
            throw new Exception("Empty token recieved");
        }
        try
        {
            $decodedJWT = JWT::decode($token,self::$secretPassword,self::$encriptationType);
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

}



?>