<?php

// handle static content
$clean_request_uri = strtok($_SERVER['REQUEST_URI'], '?');
if (preg_match('/\.css|\.js|\.jpg|\.woff|\.ttf|\.png|\.map$/', $clean_request_uri, $match)) {
    $mimeTypes = [
        '.css' => 'text/css',
        '.js'  => 'application/javascript',
        '.jpg' => 'image/jpg',
        '.png' => 'image/png',
        '.map' => 'application/json',
		'.woff' => 'font/opentype',
		'.ttf' => 'font/opentype',
    ];
    $path = __DIR__ . $clean_request_uri;
    if (is_file($path)) {
    	$path_with_query = __DIR__ . $_SERVER['REQUEST_URI'];
        header("Content-Type: {$mimeTypes[$match[0]]}");
        readfile($path);
        exit();
    }
}

// router
require_once(__DIR__ . '/vendor/autoload.php');

$klein = new \Klein\Klein();

$klein->respond('GET', '/', function () {
	require('./index.php');
});

$klein->respond('GET', '/test', function () {
	return "test";
});

$klein->dispatch();
