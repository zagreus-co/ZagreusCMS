<h1 align="center"> ZagreusCMS </h1>
<p align="center">Modular, Multilingual, and easy-to-use CMS that built under Laravel 8. </p>

<p align="center">
<img src="https://img.shields.io/github/license/zagreus-co/ZagreusCMS">
<img src="https://img.shields.io/badge/php-7.4-green.svg">
<img src="https://img.shields.io/github/stars/zagreus-co/ZagreusCMS.svg">
<img src="https://img.shields.io/github/release/zagreus-co/ZagreusCMS.svg">
<img src="https://img.shields.io/github/issues/zagreus-co/ZagreusCMS.svg">
</p>

### ⚡ Basic modules
* Analytic
* Multilingual blog
* Commenting
* Sitemap and SEO
* Keyword
* In-page notification
* Key-value option management
* Theming for both admin area and index

### 🧩 Requirements
These are the only requirements you need to get ZagreusCMS up and running smoothly.
```
- php v7.4 or higher
- node v10.16.0 or higher
- npm 6.9.0 or higher
- git 2.17.1 or higher
- any kind of SQL database
```


### 🔧 Instaltion

1. Clone the repository on your machine
```bash
$ git clone https://github.com/zagreus-co/ZagreusCMS.git
```
2. Create database on your machine
3. Rename `.env.example` to `.env` and put your database information* from line 11 to 16
4.  run the following commands
```bash
# Download and install dependencies
$ composer install
$ npm install
$ npm run dev

# Generate application key
$ php artisan key:generate

# Load migrations and seed database
$ php artisan migrate
$ php artisan module:seed
$ php artisan zagreus:load-permissions
```
5. Enjoy :)
	
    the basic sudo user credentials: `test@zagreus.company:123456`
	* we highly recomend to change this user email and password!

### 📃 To do list
We use [Trello](https://trello.com/b/zsIRoFej/zagreuscms) to track our to-do list and things we have to do!

make sure your check our [to-do list in trello](https://trello.com/b/zsIRoFej/zagreuscms) to, and find a way to contribute!

------------

##### Please note that ZagreusCMS is not built to be your primary Laravel CMS! it's a basic CMS that's built on the basic requirements so you can modify it in a way you want and build your Laravel projects!
