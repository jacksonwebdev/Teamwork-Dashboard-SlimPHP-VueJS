<?php

namespace App\Controller;

use Awurth\Slim\Helper\Controller\Controller;
use \App\Controller\Utility\TypeController as Type;
use TeamWorkPm;


class TeamworkController extends Controller
{
    protected static $twauth = null;

    /**
     * Constructor - Extends Base Slim Controller
     * Wipe session, define default API key, authenticate Teamwork API
     */
    public function __construct() {

        // necessary so api calls can run concurrently
        session_write_close();

        // allocate your stuff
        if ( !defined( 'API_KEY' ) ) {
            define('API_KEY', 'red397blur' );
        }
        
        self::authenticate();

    }

    /**
     * Uauthenticate Teamwork API Key
     *
     * @return void
     */
    public static function authenticate()
    {
        // START configurtion
        try {
            // Set your keys
            TeamWorkPm\Auth::set(API_KEY);
            return true;
        } catch (Exception $e) {
            print_r($e);
        }
    }

    /**
     * Respond from API, Format in JSON across Teamwork Classes
     *
     * @param Object $payload
     * @return void
     */
    public static function respond( Object $payload ) {

        $isJson = Type::isJson( $payload );

        if ( !$isJson ) {
            $payload = json_encode( $payload );
        }

        echo $payload;
        die();

    }

}
