# **ToDoList - Marc Lassort**

This application is the 8th project of the OpenClassrooms PHP/Symfony Web Developer training.  
ToDoList is a web app that allows its users to manage daily tasks, and our job is to improve the app's code quality, to add new functionalities, to correct anomalies and to implement automated tests. 

# **How to install the app**

## **Pre-Requisites**

- **Database**: MySQL
- **PHP version**: >=8.0.8
- **Softwares**:

* **NPM**: `npm install`
* **Composer**: `composer install`

## **Symfony packages**

- **PhpUnit-Bridge**: implements automated functional and unitary tests

## **Installation**

1. Download or clone the GitHub repository.
2. Run `composer install`. (It is possible that some bundles do not have the right version. In that case, run `composer update`.)
3. Make the following configuration settings.

## **Database configuration**

To set up your database, edit your `.env` as such:

DATABASE_URL="mysql://root:root@127.0.0.1:8889/todolist?serverVersion=5.7.34"

Make sure first that in your `.env` file, `APP_ENV` is set as `dev`. 

Then, you can create your database as running the following command lines:

`symfony console doctrine:database:create`
`symfony console doctrine:migrations:migrate`
`symfony console doctrine:fixtures:load`

When everything is in order and you can connect using `anonyme` as a username and `test` as a password, go to your `.env` file, and make sure that `APP_ENV` is set as `prod`. 

## **Run a local web server**

You can execute this command line to run a local web server: `symfony serve -d`

**NOW you can run the app!**