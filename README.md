Laravel 4 package allowing to implement nologin authentication functionnality.

# Installation

composer.json:

	"require": {
		...
		"houle/nologin": "dev-master"
	},
	"repositories": [{
        "type": "git",
        "url": "git@bitbucket.org:Houle/nologin.git"
    }]

    $ composer update

Add service provider in app/config/app.php

	'providers' => array(
		...
		'Houle\Nologin\NologinServiceProvider'
	),

Publish configuration:

	$ php artisan config:publish houle/nologin
