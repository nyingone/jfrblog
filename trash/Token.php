<?php
class Token
{
    public static function generate(){
        $value = (md5(uniqid()));
        return Session::put(Config::get('session/token_name'), $value);
    }

    public static function check($token){
        $tokenName = Config::get('session/token_name');
        
        if(Session::exists($tokenName) && $token === Session::get($tokenName)){
            Session::delete($tokenName);
            return true;
        }
        return false;
    }
}