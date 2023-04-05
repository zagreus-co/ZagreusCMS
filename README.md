<h1 align="center"> ZagreusCMS </h1>
<p align="center">Modular, and easy-to-use CMS that built under Laravel 10. </p>

<p align="center">
    <img src="https://img.shields.io/badge/php-8.1-green.svg">
    <img src="https://img.shields.io/github/stars/zagreus-co/ZagreusCMS.svg">
    <img src="https://img.shields.io/github/release/zagreus-co/ZagreusCMS.svg">
    <img src="https://img.shields.io/github/issues/zagreus-co/ZagreusCMS.svg">
</p>

### ⚡ Features and basic modules
* Analytic
* Multilingual blog
* Commenting
* Keyword
* In-page notification
* Key-value option management
* Meta tag Generator for better SEO
* Theming for both admin area and index

### 🧩 Requirements
These are the only requirements you need to get ZagreusCMS up and running smoothly.
```
- php v8.1 or higher
- node v10.16.0 or higher
- npm 6.9.0 or higher
- git 2.17.1 or higher
- any kind of SQL database
```


### 🔧 Instaltion

First your have to clone the repository on your machine or server
```bash
$ git clone https://github.com/zagreus-co/ZagreusCMS.git
```

#### Using Docker
```bash
# Start using docker-compose
$ docker-compose up
```
#### Run locally

1. Create a database on your machine
2. Rename `.env.example` to `.env` and put your database information* from lines 11 to 16
3.  run the following commands
```bash
# Download and install dependencies
$ composer install
$ npm install
$ npm run build
# Generate application key
$ php artisan key:generate
# Load migrations and seed database
$ php artisan migrate --seed
$ php artisan module:seed
$ php artisan zagreus:load-permissions
```
4. Start your local server:
```bash
# Using PHP Built-in server
$ php artisan serve

# Using Octane
$ php artisan octane:watch
```

5. Enjoy :)
	
    the basic sudo user credentials: `test@zagreus.company:123456`
	* We highly recommend changing this user email and password!

------------

##### Please note that ZagreusCMS is not built to be your primary Laravel CMS! it's a basic CMS boilerplate so you can modify and develop it in the way you want and build your Laravel projects!