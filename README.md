[![Software License](https://img.shields.io/github/license/zagreus-co/ZagreusCMS)](LICENSE.md) [![PHP7 Compatible](https://img.shields.io/badge/php-7.4-green.svg)](https://packagist.org/packages/asgardcms/platform) ![](https://img.shields.io/github/stars/zagreus-co/ZagreusCMS.svg) ![](https://img.shields.io/github/release/zagreus-co/ZagreusCMS.svg) ![](https://img.shields.io/github/issues/zagreus-co/ZagreusCMS.svg)

# ZagreusCMS

### Instaltion

1. Clone the repository on your machine
2. Create database on your machine
3.  Configure the .env file and enter database information (you can use .env.example)
4.  run the following commands
	`composer install`
    `npm install`
	`npm run dev`
    `php artisan key:generate`
	`php artisan migrate`
	`php artisan module:seed`
	`php artisan zagreus:load-permissions`
5. Enjoy :)
	the basic sudo user credentials: `test@zagreus.company:123456`
	* we highly recomend to change this user email and password!

------------

##### Please note that ZagreusCMS is not built to be your primary Laravel CMS! it's a basic CMS that's built on the basic requirements so you can modify it in a way you want and build your Laravel projects!
