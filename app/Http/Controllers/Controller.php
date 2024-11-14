<?php

namespace App\Http\Controllers;

use ErrorException;

abstract class Controller
{
    //
    function validateSession(){
        try{
            session_start();
            return $_SESSION['userId'];
        } catch (ErrorException $e){

            return '';

        }

    }
}
