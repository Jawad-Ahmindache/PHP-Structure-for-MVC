
# Fonctionnement du coeur de l'appli

Point d'entrée --> Index.php  

## Class UserDetection

Cette classe permet d'avoir des informations sur le client :
- Son user agent
- La langue qu'il utilise
- Check son token csrf
- Le pays d'où il vient


## Class App

Cette classe permet d'initialiser l'appli elle fait :
- Les méthodes pour formater les messages de sortie de l'application
- Elle attribue un thème et une langue par défaut à l'application en fonction de UserDetection
- Va chercher les routes correspondant à un module dans l'url
- Attribue une route par défaut si la requête n'est pas en AJAX
- Check si un theme existe
- Check si un module existe


