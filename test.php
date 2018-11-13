<?php

ini_set('display_errors', '1');
ini_set('html_errors', '0');
ini_set('log_errors', '0');

header('Content-Type: text/plain');

$upload_url = "http://{$_SERVER['HTTP_HOST']}/testRecv.php";
$upload_file = '/var/lib/php-fpm/upload/testfile'; // simulate the upload file

file_put_contents($upload_file, 'testdata');

$ch = curl_init();
$files = array(
    'name1' => new CURLFile($upload_file, 'application/octet-stream', 'file1.ext'),
    'name2' => new CURLFile($upload_file, 'application/octet-stream', 'file2.ext')
);
$headers = array('Expect:'); //  For HTTP POST method, this is required to use only 1 HTTP request instead of 2.
curl_setopt($ch, CURLOPT_URL, $upload_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $files);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_exec($ch);
curl_close($ch);

unlink($upload_file);
