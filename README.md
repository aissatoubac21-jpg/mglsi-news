# mglsi_news

Projet académique réalisé pour le cours d'Architecture Logicielle. Ce dépôt illustre l'évolution d'une application PHP entre une version "simple" (sans architecture) et une version professionnelle basée sur le pattern MVC.

## Structure du projet

- **Branche `simple`** : Contient la version initiale où le code SQL, la logique métier et le HTML sont mélangés.
- **Branche `mvc`** : Contient la version refactorisée en 4 couches (Domaine, Persistance, Contrôle, Présentation) pour garantir la maintenabilité et la sécurité.

## Points clés de l'architecture V2
- **Couche Persistance** : Utilisation du pattern DAO pour centraliser les requêtes SQL et du pattern Singleton pour la connexion à la base de données.
- **Couche Contrôle** : Implémentation d'un Front Controller (`index.php`) qui centralise le routage des actions.
- **Sécurité** : Utilisation systématique des requêtes préparées avec PDO pour prévenir les injections SQL.

## Installation
1. Cloner le dépôt.
2. Importer le script SQL fourni dans une base de données nommée `mglsi_news`.
3. Configurer les accès à la base de données (si nécessaire).
