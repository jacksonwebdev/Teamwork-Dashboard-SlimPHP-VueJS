<?php

namespace App\Controller;

use Awurth\Slim\Helper\Controller\Controller;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * @property \Awurth\SlimValidation\Validator validator
 * @property \Cartalyst\Sentinel\Sentinel     auth
 */
class AppController extends Controller
{
    /**
     * Send routes to home for Vue App
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function home(Request $request, Response $response)
    {
        return $this->render($response, 'app/home.twig');
    }
    public function say() {
        return 'hi';
    }
}
