Laravel 4 package allowing to implement nologin authentication functionnality.

# Installation

composer.json:

	"require": {
		...
		"houle/nologin": "dev-master"
	},
	"repositories": [{
        "type": "git",
        "url": "git@github.com:fr6/nologin.git"
    }]

    $ composer update

Add service provider in app/config/app.php

	'providers' => array(
		...
		'Houle\Nologin\NologinServiceProvider'
	),

Publish configuration:

	$ php artisan config:publish houle/nologin

# Usage

### Restrict page access

Specify the nologin filter in your routes.php file:

	Route::group(array('before' => 'nologin'), function(){
		Route::get('/', function() {
			//...
		});	
	});

### Overwrite login views 

Copy files:

	vendor/houle/nologin/src/views/login.blade.php
	vendor/houle/nologin/src/views/login-confirm.blade.php

to:

	app/views/nologin/
