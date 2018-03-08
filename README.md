#### Qitsune is a Laravel 5.5 Application with which you can Play a game

[![Greenkeeper badge](https://badges.greenkeeper.io/Chronyms/Qitsune.svg)](https://greenkeeper.io/)
[![Build Status](https://travis-ci.org/Chronyms/Qitsune.svg?branch=admin-panel)](https://travis-ci.org/Chronyms/Qitsune)
[![StyleCI](https://styleci.io/repos/101512980/shield?branch=admin-panel)](https://styleci.io/repos/101512980)
[![Build Status](https://scrutinizer-ci.com/g/Chronyms/Qitsune/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Chronyms/Qitsune/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Chronyms/Qitsune/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Chronyms/Qitsune/?branch=master)

#### READY FOR USE!

### Installationsanleitung
1. `git clone https://github.com/Chronyms/Qitsune.git` Ausführen
2. Erstelle eine MySql Datenbank für das Projekt:
    * `mysql -u root -p`
    * `CREATE DATABASE qitsune;`
3. Kopiere die .env im Root-Verzeichniss: `cp .env.example .env`
4. Editiere deine `.env` // NOTE: Google API Key will prevent maps error
5. Führe `composer update` im Root-Verzeichnisse
6. Führe `php artisan vendor:publish --provider="jeremykenedy\LaravelRoles\RolesServiceProvider" --tag=config` aus
8. Führe `php artisan vendor:publish --provider="jeremykenedy\LaravelRoles\RolesServiceProvider" --tag=seeds` aus
9. Führe `php artisan key:generate` aus
10. Führe `php artisan migrate` aus
11. Führe `composer dump-autoload` aus
12. Führe `php artisan db:seed` aus
