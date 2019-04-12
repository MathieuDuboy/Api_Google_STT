<?php
// Configuration
define("BASE", "https://www.googleapis.com/upload/storage/v1/b/");
$client_id     = "922634632013-cuaomxxxxxxxxxlah.apps.xxxxxxxxxx.com";
$client_secret = "BLVKg9Bb9xxxxxxxxxxxxxYUJZOA57e";
$refresh_token = "1/QqvTxlxxxxxxxxxRGW1mmI";
$bucket = 'test_api_codeur'; // Nom de mon bucket sans le gs://
// Fin Configuration

$postData = array(
    "grant_type" => "refresh_token",
    "client_id" => $client_id,
    "client_secret" => $client_secret,
    "refresh_token" => $refresh_token
);

$ch       = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://accounts.google.com/o/oauth2/token");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
$response = curl_exec($ch);
echo $response;
curl_close($ch);
$r = json_decode($response, true);

$accessToken = $r["access_token"];
echo $accessToken;


$key         = $accessToken;
$authheaders = array(
    "Authorization: Bearer " . $key,
    "Content-Type: audio/flac"
);


$file     = file_get_contents('bonjour-google.flac');
$fileName = 'bonjour-google.flac';
$url      = BASE . $bucket . '/o?name=bonjour-google3.flac&uploadType=media';
// Le paramètre &name= peut accepter un nom dynamique si vous le souhaitez.
// Ici j'ai forcé le nom de mon fichier qui sera sur le bucket à : bonjour-google3.flac (à vous de voir ce que vous souhaitez faire)

$curl = curl_init();

curl_setopt($curl, CURLOPT_POSTFIELDS, $file);

curl_setopt($curl, CURLOPT_HTTPHEADER, $authheaders);
curl_setopt($curl, CURLOPT_URL, $url);

curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_USERAGENT, "HTTP/1.1.5");

curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
// 1 is CURL_SSLVERSION_TLSv1, which is not always defined in PHP.
curl_setopt($curl, CURLOPT_SSLVERSION, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, true);


$response = curl_exec($curl);
echo $response;


?>
