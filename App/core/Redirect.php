<?php

class Redirect
{
    public static function to($location = null)
    {
        if($location){
            if(is_numeric($location)){
                switch($location){
                    case 404:
                    header('HTTP/1.0 404 Not Found');
                    include VIEW . 'errors/404.phtml';
                    break;

                }
            }
            header('Location:' . $location);
            exit();
        }
    }

}