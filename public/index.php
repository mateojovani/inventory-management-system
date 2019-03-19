<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels nice to relax.
|
*/

require __DIR__.'/../bootstrap/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

//helpers
if (! function_exists('getResponse')) {

    function getResponse($status, $key = null)
    {
        $lang = session('lang');

        $response = [];
        $response['status'] = $status;

        if(is_null($key)) $response['message'] = '';
        else
            $response['message'] = config('responses.'.$key.'.'.$lang);

        return $response;
    }
}

#Slightly modified translator
if (! function_exists('trans')) {

    function trans($param)
    {
        $param = explode(".", $param);
        $lang = session('lang');

        $langFile = \File::getRequire(base_path().'/resources/lang/'.$lang.'/'.$param[0].'.php');
        $index = $langFile;

        foreach ($param as $key => $paramValue)
        {
            if($key == 0) continue;
            $index = $index[$param[$key]];
        }
        return $index;

    }
}

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
