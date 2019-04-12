# Api_Google_STT
But de la manipulation principale : Envoyer un fichier .flac sur un bucket spécifique via PHP cURL

## Sommaire
1. Pré-requis
2. Génération & récupération du code d'authorisation
3. Génération & récupération du token d'accès
4. Re-Générartion du token via refresh_token lors de chaque requête
5. Envoi du fichier .flac via cURL sur le bucket

## La manipulation
### 1. Pré-requis
Vous devez créer un projet Google Cloud https://console.cloud.google.com/<br />
Ensuite, vous devez **explorer et activer les APIs**<br />
Dans la liste des APIs, recherchez **Google Cloud Storage JSON API** et activez la.<br/>
Une fois sur cette API, vous devez cliquer sur "identifants" afin de récupérer des clés et codes secrets.
- cliquez sur **identifants** dans le menu de gauche
- cliquez sur **+ créer des identifiants**
- Choisissez parmi la liste de créer un **ID Client Oauth**

**Vous devez obtenir des clés du type**<br />
**ID client**	: 922xxxxxxxxx013-xxxxxxxx.apps.googlexxxxxxxxxxxxnt.com<br />
**Code secret du client** : BLVKg9BxxxxxxxxxxxxxOA57e<br /><br />

**Attention :** Vous devez spécifier un URL de retour pour obtenir le code d'accès.
Dans mon cas, j'ai crée une page PHP vide sur mon ordinateur local et j'ai renseigné dans la case "URI de redirection autorisés" : http://localhost:8888/get_code.php
J'utilise [MAMP](https://www.mamp.info/en/) (ou WAMP pour windows) pour travailler en local.

Tout est ok pour passer à la suite.

### 2. Génération & récupération du code d'authorisation

Nous allons utiliser cette procédure uniquement via cURL et PHP : https://cloud.google.com/storage/docs/authentication?hl=fr

Le principe est de générer un code d'autorisation qui nous permettra alors d'avoir un token d'accès par la suite.<br />

Depuis un navigateur web, copiez et collez cet URL en ayant modifié les champs avec vos valeurs pour **client_id** et **redirect_uri** : 
````
https://accounts.google.com/o/oauth2/auth?
client_id=922xxxxxxxxx013-xxxxxxxx.apps.googlexxxxxxxxxxxxnt.com
&response_type=code
&access_type=offline
&redirect_uri=http://localhost:8888/get_code.php
&scope=https://www.googleapis.com/auth/cloud-platform
&approval_prompt=force
````
Vous allez être redirigé vers un pop-up de validation de votre compte Google et vous devrez accepter ensuite que l'application puisse accéder aux Buckets.
Une fois tout ceci validé, vous serez alors redirigé vers votre URL de redirection défini plus tot et obtiendrez dans l'URL de votre navigateur le code.<br />

**Exemple :** http://localhost:8888/get_code.php?code=4/KgHeqJxzyS_8iXMxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxDM09Ye8r4wz7oEnZ0

Récupérez ce code et mettez-le de côté pour la suite.<br />
Vous avez tout pour passer à l'étape suivante.

### 3. Génération & récupération du token d'accès
Maintenant vous devez récupérer le token pour accéder à l'API.<br />

Ouvrez l'éditeur de texte et modifier la page [get_token.php](https://github.com/MathieuDuboy/Api_Google_STT/blob/master/get_token.php) en remplacant les identifiants par les vôtres puis sauvegardez.<br />
Lancez alors cette page avec MAMP depuis votre navigateur.<br />

Vous devriez avoir une réponse de ce type dans votre navigateur : <br/>
````
  {
    "access_token": "ya29.GlvoBvxxxxxxxx2M-3VcGGPc-in07G7SY0ea0xxxxxxxxxB9Yc",
    "expires_in": 3600,
    "refresh_token": "1/QqvTxl0kxxxxxxxxxxxxxxxxxxxxxW2RGW1mmI",
    "scope": "https://www.googleapis.com/auth/cloud-platform",
    "token_type": "Bearer"
  }
````
Récupérez le "**refresh_token**" et mettez-le de côté.

### 4. Re-Générartion du token via refresh_token lors de chaque requête
Maintenez, vous pouvez passer à l'envoi de vos fichiers vers le Bucket.<br />
Vous devrez alors à chaque fois regénérer le token d'accès avant d'effectuer l'envoi.<br />

Ouvrez l'éditeur de texte et modifier la page [curl_send_to_bucket.php](https://github.com/MathieuDuboy/Api_Google_STT/blob/master/curl_send_to_bucket.php) en remplacant les identifiants par les vôtres puis sauvegardez.<br />
Lancez alors cette page avec MAMP depuis votre navigateur.<br />

Vous obtiendrez alors un message de validation avec les retours de la requête de succès. A vous de vérifier que le fichier a bien été transféré sur le bucket.