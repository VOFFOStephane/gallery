# Gallery

Application Symfony (galerie d'oeuvres) avec authentification, gestion des utilisateurs
et back-office admin. Projet réalisé dans le cadre de la formation BES Webdev à l'EAFC
Namur Cadets.

## Prérequis

- PHP 8.2 ou supérieur
- Composer
- MySQL (ou MariaDB)

## Installation

```bash
composer install
```

Copier `.env` en `.env.local` et adapter `DATABASE_URL` à votre configuration MySQL
locale (utilisateur, mot de passe, nom de la base).

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

## Données de démonstration

Les fixtures créent des catégories, des techniques, des oeuvres et des utilisateurs
(dont 50 comptes générés aléatoirement). À exécuter après les migrations :

```bash
php bin/console doctrine:fixtures:load
```

Cette commande vide et recrée entièrement la base — à ne jamais lancer en production.

### Comptes créés par les fixtures

Mot de passe pour les trois : `password`

| Rôle          | Email             |
|---------------|-------------------|
| Utilisateur   | Stephane@net.com  |
| Admin         | JohnDoe@mail.com  |
| Super admin   | PatMar@mail.com   |

## Lancer le projet

```bash
symfony server:start
```

ou, sans Symfony CLI :

```bash
php -S 127.0.0.1:8000 -t public public/index.php
```

## Back-office

Réservé aux comptes `ROLE_ADMIN` :

- `/admin/posts` — gestion des oeuvres (créer, modifier, masquer, supprimer)
- `/admin/users` — liste des utilisateurs

## Structure

- `src/Entity` — Painting, Category, Technique, User, Contact
- `src/Controller/Admin` — back-office
- `src/Controller/Profile` — profil de l'utilisateur connecté
- `src/DataFixtures` — données de démonstration
