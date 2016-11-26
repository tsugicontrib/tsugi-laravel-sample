# tsugi-laravel

A Library to Use Tsugi in Laravel

# Configuring Tsugi

Make a copy of `config-dist.php` from Tsugi into the top level directory of your Laravel 
Application - do not put this in the `app` folder - it needs to find the `vendor` folder.

# Adding the Dependency to composer.json

(For Now)

    "tsugi/lib": "dev-master#78ab4eb4aa8b75d68a9226701da413fe7afee266"

# Bypassing CSRF

In order to allow a POST withour CSRF, you need to bypass it in Laravel.Edit
the `app/Http/Middleware/VerifyCsrfToken.php` file to look siplar to the following:

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

# Make a New Controller

Of course you can do this to an existing controller, but for this example we will make a new controller:

    php artisan make:controller ltiSample
    
    vi ./app/Http/Controllers/ltiSample.php




