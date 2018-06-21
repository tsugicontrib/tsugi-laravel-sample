# tsugi-laravel-sample

Note: This is not a Laravel Application - it just describes how to make
a Laravel application and include Tsugi.

It is early days for this library / approach.
I have done this without using "Middleware" - which reveals the
nature of things to the app developer,
perhaps in too much detail for convienient use.

Those with more Laravel Expertise are welcome to add to this idea.

# Install the Tsugi Application Management Console

You will need to install the Tsugi Management Console from https://github.com/tsugiproject/tsugi
and configure it and create all the database tables.  This can run on a completely different
web environment than your Laravel code - but it does need access to the same database as 
your Laravel instance to set up keys, etc.  By default there will be a 12345 / secret key 
inserted and usable if you are in DEVELOPER mode.

# Install Laravel

If you have not already done so install Laravel:

    composer global require "laravel/installer=~1.1"

# Make a laravel application named zippy

If you don't already have an application, create one:

    composer create-project laravel/laravel zippy --prefer-dist

    $ cd zippy
    $ ls
    CONTRIBUTING.md bootstrap   phpunit.xml server.php
    app     composer.json   public      vendor
    artisan     composer.lock   readme.md

Looks like a fine Laravel application

# Adding Tsugi in Your Laravel App

Make a copy of `config.php` from Tsugi into the top
level directory of your Laravel Application - do not
put this in the `zippy/app` folder - it needs to find
the `vendor` folder.

Edit the file to set up the various bits.  Mostly it will be
the same as your Tsugi management
controller `config.php` but with a different `wwwroot`.

# Adding the Dependency to composer.json

Look at the latest commit in https://github.com/tsugiproject/tsugi-php/
Use this commit and add the following line to your `composer.json`.

    "tsugi/lib": "dev-master5987314f603257fb19564cc04ec56e3e3412b95b#"

    "type": "project",
    "require": {
        "php": ">=7.0.0",
        "fideloper/proxy": "~3.3",
        "laravel/framework": "5.5.*",
        "laravel/tinker": "~1.0",
        "tsugi/lib": "dev-master#5987314f603257fb19564cc04ec56e3e3412b95b"
    },

Then run

    composer update

For now, just hang with trunk because you might find and fix bugs as this gets off the ground.

# Bypassing CSRF

In order to allow a POST withour CSRF, you need to bypass it in Laravel.  Edit
the `app/Http/Middleware/VerifyCsrfToken.php` file to look similar to the following:

    <?php

    namespace App\Http\Middleware;

    use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

    class VerifyCsrfToken extends BaseVerifier
    {
        /**
         * The URIs that should be excluded from CSRF verification.
         *
         * @var array
         */
        protected $except = [
            'lti', 'lti/*'
        ];
    }

See also https://laravel.com/docs/5.1/routing#csrf-protection

# Make a New Controller and Add a Route

Of course you can do this to an existing controller, but for this example we will make a new controller.

Edit `routes\web.php` to point to your controller

    Route::get('/lti', 'ltiSample@hello');
    Route::post('/lti', 'ltiSample@hello');

Make the controller:

    php artisan make:controller ltiSample
    
    vi ./app/Http/Controllers/ltiSample.php
    
Here is my super-simple controller https://github.com/tsugiproject/tsugi-laravel-sample/blob/master/ltiSample.php
if you just want to use it.

# Run a Test

Start the server

    php artisan serve
    
Navigate to http://localhost:8000/lti - you should see an error message since it is not launched using LTI.

Go to https://www.tsugi.org/lti-test/lms.php and enter

    http://localhost:8000/lti

As the URL, and press "Launch".  If all goes well, your Tsugi Laravel application should process the POST
and do the rediect and dump out the Launch data.

# Library Code for Tsugi Laravel

This is just another class in the Tsugi PHP library

https://github.com/tsugiproject/tsugi-php/tree/master/src/Laravel

# Possible Improvements

I would think that at some point this might make better send as a filter so the 
redirect and 403 processing can be done more seamlessly.  But that requires
more Laravel learning that I have presently.



