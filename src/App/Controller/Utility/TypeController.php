<?php

namespace App\Controller\Utility;

class TypeController
{

    /**
     * isJson
     * 
     * Returns true if JSON string
     *
     * @param String $string
     * @return boolean
     */
    public static function isJson( String $string) {

        if( is_array( $string) || is_object( $string ) ) {
            return false;
        }

        json_decode($string);

        return (json_last_error() == JSON_ERROR_NONE);

    }

}
