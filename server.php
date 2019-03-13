<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

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

require_once __DIR__.'/public/index.php';
