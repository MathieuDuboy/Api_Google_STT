# Api_Google_STT
But de la manipulation principale : Envoyer un fichier .flac sur un bucket spécifique via PHP cURL

## Sommaire
1. Pré-requis
2. Génération & récupération du code d'authorisation
3. Génération & récupération du token d'accès
4. Générartion du refresh_token lors de chaque requête
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

Depuis un navigateur web, copiez et collez cet URL en ayant modifié les champs avec vos valeurs : 
````
https://accounts.google.com/o/oauth2/auth?
client_id=922xxxxxxxxx013-xxxxxxxx.apps.googlexxxxxxxxxxxxnt.com
&response_type=code
&access_type=offline
&redirect_uri=http://localhost:8888/get_code.php
&scope=https://www.googleapis.com/auth/cloud-platform
&approval_prompt=force
````

