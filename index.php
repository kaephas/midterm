<?php
/**
 * Created by PhpStorm.
 * @author Kaephas Kain
 * Date: 5-13-2019
 * Filename: index.php
 * Description: loads error reporting, composer, fat free, setting default route to views/home.html
 */

//Turn on error reporting
ini_set('display_errors' ,1);
error_reporting(E_ALL);

//require autoload file
require_once('vendor/autoload.php');
// validation functions
require_once('model/validate.php');
// start session after require (no classes but good habit)
session_start();

//create an instance of the Base class
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

// options array
$f3->set('options', array('This midterm is easy', 'I like midterms', 'Today is Monday'));

//Define a default route
$f3->route('GET /', function()
{
    echo '<h1>Midterm Survey</h1>';
    echo '<a href="survey">Take My Midterm Survey</a>';
});

// survey route
$f3->route('GET|POST /survey', function($f3) {
    // check if post/form submit and validate
    if(!empty($_POST)) {
        $name = $_POST['name'];
        $choices = $_POST['choices'];

        $f3->set('name', $name);
        $f3->set('choices', $choices);

        // make sure both run in case of errors in both
        $goodName = validName($name);
        $goodChoices =  validChoice($choices);

        // if both are valid, reroute
        if($goodName && $goodChoices) {
            $_SESSION['name'] = $name;
            $_SESSION['choices'] = $choices;

            $f3->reroute('/summary');
        }

    }
    // first load or invalid form
    $view = new Template();
    echo $view->render('views/survey.html');
});

// summary route
$f3->route('GET /summary', function($f3) {
    // separate all selections with comma and space
    $f3->set('showChoices', implode(', ', $_SESSION['choices']));
    // load summary view
    $view = new Template();
    echo $view->render('views/summary.html');
});

//run Fat-free
$f3 -> run();
