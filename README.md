# Notes

This is a demo project for notes like "Post its".

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

Configure an email to send notifications.

### Installing

After cloning the project, install the dependencies with the following command

```
composer install
```

Generate a key for the application

```
php artisan key:generate
```
- Note: You need to copy ``.env.example`` in a ``.env``

Create a link for the storage path

```
php artisan storage:link
```

Run the migrations

```
php artisan migrate --seed
```

Then set the configuration for the Passport package

```
php artisan passport:install
```

## Testing

In the ``.env.testing`` configure an account to send notifications when notes created.

Create a ``database.slqite`` in database directory and execute the following commands

```
php artisan migrate:fresh --seed --env=testing
php artisan passport:install --force --env=testing
```

Now to run the tests
```
php artisan test
```

* Note: For notifications run this commands ``php artisan queue:work``

# Demo in Postman

Check the API in:

[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/94aa11f104c03ccd2dd9)
