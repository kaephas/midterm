<?php
/**
 * Created by PhpStorm.
 * User: Kaephas Kain
 * Date: 2019-04-12
 * Filename: index.php
 * Description: loads error reporting, composer, fat free, setting default route to views/home.html
 */

//Turn on error reporting
ini_set('display_errors' ,1);
error_reporting(E_ALL);


//require autoload file
require_once('vendor/autoload.php');

session_start();

//create an instance of the Base class
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

// options array
$f3->set('options', array('This midterm is easy.', 'I like midterms.', 'Today is Monday'));

//Define a default route (dating splash page)
$f3->route('GET /', function()
{
    echo '<h1>Midterm Survey</h1>';
    echo '<a href="survey">Take My Midterm Survey</a>';
});

$f3->route('GET|POST /survey', function($f3) {
    if(!empty($_POST)) {
        $name = $_POST['name'];
        $choices = $_POST['options'];

        $f3->set('name', $name);
        $f3->set('choices', $choices);

    }

    $view = new Template();
    echo $view->render('views/survey.html');
});


//run Fat-free
$f3 -> run();
