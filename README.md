# Loyalty Application


# How it Works
This is a REST API for a simple loyalty points system. This API should allow
users to earn and redeem points for their loyalty. Your task is to create a PHP script that implements this
REST API. You should use the Slim Framework ( http://www.slimframework.com/) to build the API.

API supports the following endpoints:
GET /users: Retrieve a list of all users and their current points balance.
POST /users: Create a new user with an initial points balance of 0.
POST /users/{id}/earn: Earn points for a user. The request should include the number of points to
earn and a description of the transaction.
POST /users/{id}/redeem: Redeem points for a user. The request should include the number of
points to redeem and a description of the transaction.
DELETE /users/{id}: Delete a user by their ID.

The user data should be stored in a MySQL database. You should create a users table with the following
columns:
● id (int, primary key)
● name (varchar(255))
● email (varchar(255))
● points_balance (int)

## Install the Application

Run these commands from the directory in which you want to install the application.
PHP 7.4 or newer is required.

```bash
git clone 
cd loyalty-app
composer install
```

Replace `loyalty-app` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writable.

To run the application in development, you can run these commands 

```bash
cd loyalty-app
composer start
```

Or you can use `docker-compose` to run the app with `docker`, so you can run these commands:
```bash
cd loyalty-app
docker-compose up -d
```
After that, open `http://localhost:8080` in your browser.


## Test the Application

Run this command in the application directory to run the test suite

```bash
composer test
```