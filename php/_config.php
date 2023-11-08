<?php


date_default_timezone_set("Europe/Berlin");

// based on original work from the PHP Laravel framework
if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle)
    {
        return $needle !== '' && strpos($haystack, $needle) !== false;
    }
}


function lang($en, $de = null)
{
    $lang = $_SESSION['lang'] ?? 'de';
    if ($de === null || $lang == 'en') return $en;
    return $de;
}

function redirect($url)
{
    $string = '<script type="text/javascript">';
    $string .= 'window.location = "' . $url . '"';
    $string .= '</script>';

    echo $string;
}

function roundclever($float)
{
    if ($float > 100) return round($float);
    if ($float > .001) return round($float, 3);
    if ($float > 1) return round($float, 1);
    return sprintf("%.1e", $float);
}


function time_format($timestamp, $format = "d.m.y")
{
    $timestamp = strtotime($timestamp);
    return date($format, $timestamp);
}

function time_elapsed_string($datetime, $full = false, $type = 'str')
{
    $now = new DateTime;
    if ($type == 'str') {
        $ago = new DateTime($datetime);
    } else {
        $ago = new DateTime();
        $ago->setTimestamp($datetime);
    }
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => lang('year', 'Jahre'),
        'm' => lang('month', 'Monate'),
        'w' => lang('week', 'Woche'),
        'd' => lang('day', 'Tage'),
        'h' => lang('hour', 'Stunde'),
        'i' => lang('minute', 'Minute'),
        's' => lang('second', 'Sekunde'),
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? lang('s', 'n') : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? lang('', 'vor ') . implode(', ', $string) . lang(' ago', '') : lang('just now', 'gerade eben');
}

function decode_mail($mail)
{
    $alpha = "1q9we2rt.3zu4io@pa5-sdfg8hj6kl_yxc0v7bnm";
    // $alpha = explode("",$alpha);
    // $original = explode("",$mail);
    $remodeled = array();
    foreach ($mail as $i => $letter) {
        $newletter = $alpha[$i];
        array_push($remodeled, $newletter);
    }
    return join("", $remodeled);
}

function printMsg($msg = null, $type = 'info', $header = "default")
{
    if ($msg === null && isset($_SESSION['msg'])) {
        $msg = $_SESSION['message'];
        unset($_SESSION["message"]);
    }
    if ($msg === null && !isset($_GET["msg"])) return;
    $msg = $msg ?? $_GET["msg"];
    $text = "";
    $header = $header;
    $class = "";
    if ($type == 'success') {
        $class = "success";
        if ($header == "default") {
            $header = lang("Success!", "Erfolg!");
        }
    } elseif ($type == 'error') {
        $class = "danger";
        if ($header == "default") {
            $header = lang("Error", "Fehler");
        }
    } elseif ($type == 'info') {
        $class = "primary";
        if ($header == "default") {
            $header = "";
        }
    }
    switch ($msg) {
        case 'success':
            $header = lang("Dataset added", "Datensatz hinzugefügt");
            $text = lang("The dataset was successfully added to the database.", "Der Datensatz wurde erfolgreich der Datenbank hinzugefügt.");
            $class = "success";
            break;

        case 'upload-success':
            $header = lang("Upload successful", "Upload erfolgreich");
            $text = lang("Your file was successfully uploaded to the server.", "Deine Datei wurde erfolgreich auf dem Server hochgeladen.");
            $class = "success";
            break;

        case 'welcome':
            $header = lang("Welcome,", "Willkommen,") . " " . ($_SESSION["name"] ?? '') . ".";
            $text = lang("You are now logged in.", "Du bist jetzt eingeloggt.");
            $class = "success";
            break;

        default:
            $text = str_replace("-", " ", $msg);
            break;
    }
    $get = currentGET(['msg']) ?? "";
    echo "<div class='alert alert-$class alert-block show' role='alert'>
          <a class='close' href='$get' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </a> ";
    if (!empty($header)) {
        echo " <h4 class='title'>$header</h4>";
    }
    echo "$text
      </div>";
}




function currentGET(array $exclude = [], array $include = [])
{
    if (empty($_GET) && empty($include)) return '?';

    $get = "?";
    foreach (array_merge($_GET, $include) as $name => $value) {
        if (in_array($name, $exclude)) continue;
        if ($name == 'msg') continue;
        if (is_array($value)) {
            foreach ($value as $v) {
                // if (empty($v)) continue;
                if ($get !== "?") $get .= "&";
                $get .= $name . "[]=" . $v;
            }
        } elseif (!empty($value)) {
            if ($get !== "?") $get .= "&";
            $get .= $name . "=" . $value;
        }
    }
    return $get;
}

function sortbuttons(string $colname)
{
    $order = $_GET["order"] ?? "";
    $asc = $_GET["asc"] ?? 1;
    $get = currentGET(['order', 'asc']);
    // $get = $_SERVER['REQUEST_URI'] . $get;
    if ($order == $colname && $asc == 1) {
        echo "<a href='$get&order=$colname&asc=0'><i class='fas fa-sort-up'></i></a>";
    } elseif ($order == $colname && $asc == 0) {
        echo "<a href='$get'><i class='fas fa-sort-down'></i></a>";
    } else {
        echo "<a href='$get&order=$colname&asc=1'><i class='fas fa-sort'></i></a>";
    }
}


function hiddenFieldsFromGet(array $exclude = [], array $include = [])
{
    if (empty($_GET) && empty($include)) return;
    if (is_string($exclude)) $exclude = array($exclude);

    foreach (array_merge($_GET, $include) as $name => $value) {
        if (in_array($name, $exclude)) continue;
        if ($name == 'msg') continue;
        if (is_array($value)) {
            foreach ($value as $v) {
                // if (empty($v)) continue;
                echo '<input type="hidden" name="' . $name . '[]" value="' . $v . '">';
            }
        } elseif (!empty($value) || $value == 0) { //otherwise asc does not work
            echo '<input type="hidden" name="' . $name . '" value="' . $value . '">';
        }
    }
}


function commalist(array $array, $sep="and")
{
    if (empty($array)) return "";
    if (count($array) < 3) return implode(" $sep ", $array);
    $str = implode(", ", array_slice($array, 0, -1));
    return $str . ", $sep " . end($array);
}


function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    return $length > 0 ? substr($haystack, -$length) === $needle : true;
}


function dump($element, $as_json = false)
{
    echo '<pre class="code">';
    if ($as_json && is_array($element)) {
        $element = array_merge($element);
        echo json_encode($element, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        if (!empty(json_last_error())) {
            var_dump(json_last_error_msg()) . PHP_EOL;
            var_export($element);
        }
    } else {
        var_dump($element);
    }
    echo "</pre>";
}


function valueFromDateArray($date)
{
    // this function is used to generate a input:date-like string from arrays
    if (empty($date) || !isset($date['year'])) return '';
    $d = new DateTime();
    $d->setDate(
        $date['year'],
        $date['month'] ?? 1,
        $date['day'] ?? 1
    );
    return date_format($d, "Y-m-d");
}

function format_date($date)
{
    // dump($date);
    $d = getDateTime($date);
    return date_format($d, "d.m.Y");
}


function getDateTime($date)
{
    if (isset($date['year'])) {
        //date instanceof MongoDB\Model\BSONDocument
        $d = new DateTime();
        $d->setDate(
            $date['year'],
            $date['month'] ?? 1,
            $date['day'] ?? 1
        );
    } else {
        try {
            $d = date_create($date);
        } catch (TypeError $th) {
            $d = null;
        }
    }
    return $d;
}


function fromToDate($from, $to)
{
    if (empty($to) || $from == $to) {
        return format_date($from);
    }
    // $to = date_create($to);
    $from = format_date($from);
    $to = format_date($to);

    $f = explode('.', $from, 3);
    $t = explode('.', $to, 3);

    $from = $f[0] . ".";
    if ($f[1] != $t[1] || $f[2] != $t[2]) {
        $from .= $f[1] . ".";
    }
    if ($f[2] != $t[2]) {
        $from .= $f[2];
    }

    return $from . '-' . $to;
}
