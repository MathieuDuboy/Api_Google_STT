<?php
// Configuration
$code          = "4/KgHeqJxxxxxxxxxxxJLlDM09Ye8r4wz7oEnZ0";
$client_id     = "922634632013-cuaom4kxxxxxxxxmlmlah.apps.gooxxxxxxxxx.com";
$client_secret = "BLVKgxxxxxxxxxZOA57e";
$redirect_uri  = "http://localhost:8888/get_code.php";
// Fin Configuration

function getToken()
{
    $curl   = curl_init();
    $params = array(
        CURLOPT_URL => "https://accounts.google.com/o/oauth2/token?"
          . "code=" . $code
          . "&grant_type=authorization_code"
          . "&client_id=" . $client_id
          . "&client_secret=" . $client_secret
          . "&redirect_uri=" . $redirect_uri,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        //CURLOPT_NOBODY => false,
        CURLOPT_HTTPHEADER => array(
            "Content-length: 0",
            'Content-Type: application/x-www-form-urlencoded'
        )
    );
    curl_setopt_array($curl, $params);

    $response = curl_exec($curl);
    echo $response;
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Erreur #01: " . $err;
    } else {
        $response = json_decode($response, true);
        if (array_key_exists("access_token", $response))
            return $response;
        $refreshToken = $response["refresh_token"];
        if (array_key_exists("error", $response))
            echo $response["error_description"];
        echo "cURL Erreur #02: Gros bug ...";
    }
}

// Execution de cette fonction avec les paramètres définis plus tôt.
getToken();

/*
Vous devriez avoir une réponse de ce type dans votre navigateur
  {
    "access_token": "ya29.GlvoBvxxxxxxxx2M-3VcGGPc-in07G7SY0ea0xxxxxxxxxB9Yc",
    "expires_in": 3600,
    "refresh_token": "1/QqvTxl0kxxxxxxxxxxxxxxxxxxxxxW2RGW1mmI",
    "scope": "https://www.googleapis.com/auth/cloud-platform",
    "token_type": "Bearer"
  }
*/
