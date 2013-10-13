# HeartBeat Statusboard

**Heartbeat** is a simple (& responsive) site-tracking statusboard (and twitter dashboard) that allows you to set up a list of sites and servers to check, and will alert you via email (and a visual prompt on-screen) when a site does not respond with a satisfiable response (usually a slow response time or a none-200 status code).

## Features

- See a list of your sites with instant highlighting of those experiencing problems.
- Email alerts when a site goes down and comes back up.
- Optional twitter feed to the side of the statusboard, using whatever search term you'd like.

## Installation

### Edit The config file.

Edit the file at `app/config/heartbeat.php` and fill in the details. Twitter values are required if you want to display tweets (twitter requests will silently fail otherwise).

### Setup the DB & Dependencies

The application is built upon [Laravel 4](http://laravel.com) and requires `PHP 5.3` (this will soon be moving to 5.4), and also requires [Composer](http://getcomposer.org) to install dependencies.

Drop the application onto your server at `http://myserver.com` using SSH or FTP.

Go into the application directory and run :

```bash
# Download Composer
$ curl -S http://getcomposer.org/installer | php
# Install dependencies
$ php composer.phar install
```

Create a MySQL database for your project.

Edit the `app/config/database.php` to use your database settings.

Once you've done that, run the following command in the application directory:

```shell
$ php artisan migrate
```

*There you go, your statusboard is now set up, but with no sites in there to check.*

### Adding Sites

You can add sites to check by editing `app/config/sites.php`, this is simply a two-level-deep array of sites and groupings. The top level is the server name or group name, and the rest are Site names as `key` and the URL as the `value`.

```php
<?php
return array(
	'Group / Server Name' => array(
		'Site Name' => 'http://www.example.com',
		'Site Name' => 'http://www.example.com',
		'Site Name' => 'http://www.example.com',
		'Site Name' => 'http://www.example.com',
		'Site Name' => 'http://www.example.com',
	),
);
```

Then use Laravel's `db:seed` command to add them to the database:

```bash
$ php artisan db:seed
```

