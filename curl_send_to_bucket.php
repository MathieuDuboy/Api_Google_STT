<?php
// Configuration
define("BASE", "https://www.googleapis.com/upload/storage/v1/b/");
$client_id     = "922634632013-cuaom4k4s17avf3u1g5tb3ksjfmlmlah.apps.googleusercontent.com";
$client_secret = "BLVKg9Bb9nKKghxYUJZOA57e";
$refresh_token = "1/QqvTxl0kIdJOU6dqxI7kCdgpWl-0y4MaXGW2RGW1mmI";

// Fichier récupéré via l'API OVH ici
$file = file_get_contents('bonjour-google.flac');

// Unique id pour le nom du fichier
$uniqueId    = time() . '-' . mt_rand();
$nom_fichier = "bonjour-google-$uniqueId.flac"; // Le nom qui sera sur le bucket
// Fin Configuration

$postData = array(
    "grant_type" => "refresh_token",
    "client_id" => $client_id,
    "client_secret" => $client_secret,
    "refresh_token" => $refresh_token
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://accounts.google.com/o/oauth2/token");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
$response = curl_exec($ch);
curl_close($ch);
$r = json_decode($response, true);

$accessToken = $r["access_token"];


$key         = $accessToken;
$authheaders = array(
    "Authorization: Bearer " . $key,
    "Content-Type: audio/flac"
);

$bucket = 'test_codeur2';
$url    = BASE . $bucket . '/o?name=' . $nom_fichier . '&uploadType=media';
$curl   = curl_init();

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


$data = array(
    'config' => array(
        "encoding" => 'FLAC',
        "languageCode" => "fr-FR"
    ),
    "audio" => array(
        "uri" => "gs://test_codeur2/" . $nom_fichier
    )
);

$ch = curl_init("https://speech.googleapis.com/v1/speech:recognize?key=AIzaSyAXFJQCIO9rkl6Up0-6WrPhJEsY2AH2KlU");

curl_setopt_array($ch, array(
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer " . $accessToken,
        "Content-Type: application/json"
    )
));
$json = curl_exec($ch);
curl_close($ch);
// "results": [ { "alternatives": [ { "transcript": "Bonjour Google comment ça va", "confidence": 0.96079487 } ] } ] }

// Récupèrer u  array et la valeur du transcript
$tab = json_decode($json, true);

$transcript     = $tab["results"][0]["alternatives"][0]["transcript"];
$taux_confiance = $tab["results"][0]["alternatives"][0]["confidence"];

echo "avec un taux de confiance de " . $taux_confiance . ", voici le transcript : " . $transcript;

?>
