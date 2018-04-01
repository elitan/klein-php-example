<?php

session_start();

$clean_request_uri = strtok($_SERVER['REQUEST_URI'], '?');
if (preg_match('/\.well-known|\.css|\.js|\.jpg|\.jpeg|\.woff|\.ttf|\.png|\.map|\.pdf|\.html|\.mp4$/', $clean_request_uri, $match)) {
    $mimeTypes = [
        '.html' => 'text/html',
        '.css' => 'text/css',
        '.mp4' => 'video/mp4',
        '.js'  => 'application/javascript',
        '.jpg' => 'image/jpg',
        '.jpeg' => 'image/jpg',
        '.png' => 'image/png',
        '.map' => 'application/json',
        '.json' => 'application/json',
		'.woff' => 'font/opentype',
		'.ttf' => 'font/opentype',
		'.pdf' => 'application/pdf',
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
