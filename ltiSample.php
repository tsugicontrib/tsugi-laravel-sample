<?php

namespace App\Http\Controllers;

require_once app_path() ."/../config.php";

use Illuminate\Http\Request;
use Tsugi\Laravel\LTIX;

class ltiSample extends Controller
{

    public function hello(Request $request) {

        $launch = LTIX::laravelSetup($request, LTIX::ALL);
        if ( $launch->redirect_url ) return redirect($launch->redirect_url);

        ob_start();
        echo("<pre>\n");
        echo("\nLaunch:\n");
        var_dump($launch);
/*
        echo("\nSession:\n");
        var_dump($request->session());
        echo("\nPost:\n");
        var_dump($_POST);

        global $CFG;
        echo("\nCFG:\n");
        var_dump($CFG);
*/
        echo("</pre>\n");
        return ob_get_clean();
    }
}
