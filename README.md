# Gestionnaire-Stockage-Lien
##  Installation (Teste en local)

Si vous voulez installer ce projet sur votre ordinateur avec WAMP ou XAMPP :

1. **Cloner le projet** : Téléchargez les fichiers et placez-les dans votre dossier `www/` ou `htdocs/`.
2. **Créer la Base de Données** :
   - Ouvrez votre **phpMyAdmin**.
   - Créez une base de données nommée `gestion_liens`.
   - Cliquez sur l'onglet **Importer** et choisissez le fichier `gestion_liens.sql` présent dans ce dépôt.
3. **Configurer la connexion** :
   - Le fichier `db.php` est déjà configuré pour **localhost** (utilisateur `root`, sans mot de passe).
   - Si vos identifiants locaux sont différents, modifiez-les dans `db.php`.
4. **Lancer l'application** : Ouvrez votre navigateur et allez sur `http://localhost/nom-du-dossier/index.php`.
