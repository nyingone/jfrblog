<?php
class Cookie
{
    public static function exists()
    {
        return(isset($_COOKIE[$name])) ? true : false;  
    }
}