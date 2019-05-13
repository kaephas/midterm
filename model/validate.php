<?php
/*
 * Validation methods for midterm survey
 *
 * @author Kaephas Kain
 *
 * Date: 5-13-2019
 * File: validate.php
 */

/**
 * Checks if name is not empty and is all letters
 * and adds to errors if not
 *
 * @param $name     name to be checked
 * @return bool     if valid
 */
function validName($name)
{
    global $f3;
    $isValid = true;
    if($name == "" || !ctype_alpha($name)) {
        $isValid = false;
        $f3->set('errors["name"]', 'Please enter a valid name.');
    }
    return $name != "" && ctype_alpha($name);
}

/**
 * Checks if choices made are in original array (anti-spoof)
 * and adds to errors if not or if none selected
 *
 * @param $choices  array of choices to be checked
 * @return bool     if array is valid
 */
function validChoice($choices)
{
    global $f3;
    $isValid = true;
    if(empty($choices)) {
        $isValid = false;
    } else {
        foreach($choices as $choice) {
            if(!in_array($choice, $f3->get('options'))) {
                $isValid = false;
            }
        }
    }
    if(!$isValid) {
        $f3->set('errors["choices"]', 'Please enter at least one choice.');
    }
    return $isValid;
}
