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
**Code secret du client** : BLVKg9BxxxxxxxxxxxxxOA57e<br />



