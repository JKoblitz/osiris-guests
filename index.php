<?php
include_once 'CONFIG.php';
include_once 'php/_config.php';

session_start();

if (isset($_GET['lang'])){
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

    if (empty($id)  || !file_exists(BASEPATH.'/forms/' . $id . '.json')) die('{"message":"Form not found"}');

    $content = file_get_contents(BASEPATH.'/forms/' . $id . '.json');
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
    file_put_contents(BASEPATH.'/forms/' . $id . '.json', $json);

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
        file_put_contents(BASEPATH.'/forms/' . $id . '.json', $json);
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
