# documentation Sample

## Getting started

This project runs with Laravel version 10.47.0.
This project runs with php version 8.1.

Assuming you don't have this installed on your machine: [Laravel](https://laravel.com), [Composer](https://getcomposer.org).

## How to clone the code.

```bash
git clone https://github.com/Demenkesh/law_firm_x.git
```
## How to install it .

```bash
# install dependencies
composer update

# create .env file and generate the application key
cp .env.example .env
php artisan key:generate

```

# Configure your .env file with your database credentials, mail and other settings.

## Then migrate the database :

```bash
php artisan migrate
```

## Then run the cronjob to be checking , the cronjob runs once a day that after 24hrs if will run againn ,provided you did not stop it :

```bash
php artisan cronjob:run
```

## Then launch the server:

```bash
php artisan serve
```
The Laravel sample project is now up and running! Access it at http://localhost:8000 or http://127.0.0.1:8000.

Develop a simple CRM application for Law Firm X using Laravel allowing easy lookup and profiling of clients, sending welcome emails on profile creation, optional profile image with reminders, filtering clients by last name, and viewing individual client profiles without a login system.
# law_firm_x
