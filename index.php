<?php
/**
 * Main router file for the guest forms
 * 
 * This file is part of the OSIRIS package.
 * Copyright (c) 2024 Julia Koblitz, OSIRIS Solutions GmbH
 *
 * @package     OSIRIS Guest Forms
 * @since       0.1.0
 * 
 * @copyright	Copyright (c) 2024 Julia Koblitz, OSIRIS Solutions GmbH
 * @author		Julia Koblitz <julia.koblitz@osiris-solutions.de>
 * @license     MIT
 */

include_once 'CONFIG.php';

define('VERSION', '0.1.0');

// check if mandatory secret key is defined
if (!defined('SECRET_KEY')) {
    echo "Please define a secret key in CONFIG.php";
    die();
}

// backup in case of missing values
if (!defined('ROOTPATH'))
    define('ROOTPATH', '');
if (!defined('BASEPATH'))
    define('BASEPATH', $_SERVER['DOCUMENT_ROOT'] . ROOTPATH);
if (!defined('AFFILIATION'))
    define('AFFILIATION', '*AFFILIATION*');
if (!defined('INTRODUCTION_EN'))
    define('INTRODUCTION_EN', 'Welcome to our Institute. Please fill out the following form thoroughly, read the instructions and acknowledge their receipt.');
if (!defined('INTRODUCTION_DE'))
    define('INTRODUCTION_DE', 'Willkommen bei unserem Institut. Bitte füllen Sie das folgende Formular gewissenhaft aus, lesen Sie die Belehrungen und bestätigen Sie deren Erhalt.');
if (!defined('CONTENT_LEGAL_EN'))
    define('CONTENT_LEGAL_EN', 'I assure to observe security rules and other internal regulations. I have received the written “Safety Instructions”. Furthermore, I assure to treat confidential the information, results of measurements, descriptions, procedures, etc., as far as they are commercially usable. I will not announce them to any third party. <br>I will not use the achieved information for commercial purposes, neither personally nor by any company. I will not use them directly or indirectly, unless the Institute has given the explicit permission.<br> This obligation is not applicable if the information has already been announced by publications or has provable been made known to me from third parties without deriving directly or indirectly from the Institute.');
if (!defined('CONTENT_LEGAL_DE'))
    define('CONTENT_LEGAL_DE', 'Ich verpflichte mich, die in der bestehende Sicherheitsordnung sowie die übrigen betrieblichen Regelungen zu beachten. Die „Sicherheitsbelehrung“ habe ich in schriftlicher Form erhalten und werde diese befolgen. Ich verpflichte mich ferner, die mir in dem genannten Zeitraum bekannt werdenden Mitteilungen, Messprotokolle, Beschreibungen, Verfahren usw., soweit sie wirtschaftlich verwertbar sind, vertraulich zu behandeln und sie keinem Dritten bekannt zu geben.<br> Von entsprechenden Informationen werde ich weder persönlich noch durch Firmen gewerblich Gebrauch machen, d.h. sie weder direkt noch indirekt verwerten, es sei denn auf Grund einer ausdrücklichen Vereinbarung mit dem Institut. Diese Verpflichtung entfällt, soweit die genannten Mitteilungen nachweislich schon infolge von Publikationen Gemeingut sind bzw. werden, oder mir nachweislich von anderer Seite bekannt werden, ohne direkt oder indirekt von dem Institut zu stammen.');


include_once 'php/_config.php';

session_start();

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

include_once BASEPATH . "/php/Route.php";

Route::get('/', function () {
    include BASEPATH . "/header.php";
    echo "You have no access to this ressource.";
    include BASEPATH . "/footer.php";
});


Route::get('/api/get/([a-z0-9]*)', function ($id) {

    if (!isset($_GET['secret'])) die('{"message":"Secret key is missing"}');
    if ($_GET['secret'] !== SECRET_KEY) die('{"message":"Secret key is wrong"}');

    if (empty($id)  || !file_exists(BASEPATH . '/forms/' . $id . '.json')) die('{"message":"Form not found"}');

    $content = file_get_contents(BASEPATH . '/forms/' . $id . '.json');
    $form = json_decode($content, true);
    if (empty($form)) die('{"message":"Form is empty"}');

    header("Content-Type: application/json");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo json_encode($form, JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
});

Route::post('/api/post', function () {

    // save posted values
    $values = file_get_contents("php://input");
    $values = json_decode($values, true);
    // dump($values);

    if (!isset($values['secret'])) die('{"message":"Secret key is missing"}');
    if ($values['secret'] !== SECRET_KEY) die('{"message":"Secret key is wrong"}');

    // except for secret key
    unset($values['secret']);
    $id = $values['id'];

    $json = json_encode($values, JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES);
    file_put_contents(BASEPATH . '/forms/' . $id . '.json', $json);

    echo '{"message":"Success"}';
});

Route::get('/success', function () {
    include BASEPATH . "/header.php";
    include BASEPATH . "/success.php";
    include BASEPATH . "/footer.php";
});


Route::get('/([a-z0-9]*)', function ($id) {
    include BASEPATH . "/header.php";
    if (empty($id)  || !file_exists('forms/' . $id . '.json')) {
        echo "Dieses Formular existiert nicht.";
    } else {

        $content = file_get_contents('forms/' . $id . '.json');
        $form = json_decode($content, true);
        if (empty($form)) {
            echo "Das Formular ist leer.";
        } else {
            include BASEPATH . "/form.php";
        }
    }
    include BASEPATH . "/footer.php";
});


Route::post('/([a-z0-9]*)', function ($id) {
    include BASEPATH . "/header.php";
    if (empty($id)  || !file_exists('forms/' . $id . '.json')) {
        echo "Dieses Formular existiert nicht.";
    } else {

        $values = $_POST['values'];
        $id = $values['id'];

        // add information on creating process
        $values['updated'] = date('Y-m-d');

        // check if check boxes are checked
        $values['legal']['general'] = boolval($values['legal']['general'] ?? false);
        $values['legal']['data_security'] = boolval($values['legal']['data_security'] ?? false);
        $values['legal']['data_protection'] = boolval($values['legal']['data_protection'] ?? false);
        $values['legal']['safety_instruction'] = boolval($values['legal']['safety_instruction'] ?? false);


        $content = file_get_contents('forms/' . $id . '.json');
        $form = json_decode($content, true);

        $values = array_merge($form, $values);

        $json = json_encode($values, JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES);
        file_put_contents(BASEPATH . '/forms/' . $id . '.json', $json);
        header("Location: " . ROOTPATH . "/success");
    }
    include BASEPATH . "/footer.php";
});

// Add a 404 not found route
Route::pathNotFound(function ($path) {
    // Do not forget to send a status header back to the client
    // The router will not send any headers by default
    // So you will have the full flexibility to handle this case
    // header('HTTP/1.0 404 Not Found');
    http_response_code(404);
    $error = 404;
    // header('HTTP/1.0 404 Not Found');
    include BASEPATH . "/header.php";
    // $browser = $_SERVER['HTTP_USER_AGENT'];
    // var_dump($browser);
    // include BASEPATH . "/pages/error.php";
    echo "Error 404";
    include BASEPATH . "/footer.php";
});

// Add a 405 method not allowed route
Route::methodNotAllowed(function ($path, $method) {
    // Do not forget to send a status header back to the client
    // The router will not send any headers by default
    // So you will have the full flexibility to handle this case
    header('HTTP/1.0 405 Method Not Allowed');
    $error = 405;
    include BASEPATH . "/header.php";
    // include BASEPATH . "/pages/error.php";
    echo "Error 405";
    include BASEPATH . "/footer.php";
});


Route::run(ROOTPATH);
