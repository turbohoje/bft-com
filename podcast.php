<?php

$file = $_GET['f'];
$filepath = "mp3/$file";

if (!file_exists($filepath)) {
    print "no file";
    exit(1);
}

$mime_type = mime_content_type($filepath);



spl_autoload_register(function($className) {
    if($className[0] == '\\') {
        $className = substr($className, 1);
    }
    // Leave if class should not be handled by this autoloader
    if(strpos($className, 'UnitedPrototype\\GoogleAnalytics') !== 0) return;
    $classPath = strtr(substr($className, strlen('UnitedPrototype')), '\\', '/') . '.php';
    if(file_exists(__DIR__ . $classPath)) {
        require(__DIR__ . $classPath);
    }
});

use UnitedPrototype\GoogleAnalytics;

function Download($path, $speed = null, $multipart = true){
    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    if (is_file($path = realpath($path)) === true) {
        $file = @fopen($path, 'rb');
        $size = sprintf('%u', filesize($path));
        $speed = (empty($speed) === true) ? 1024 : floatval($speed);

        if (is_resource($file) === true) {
            set_time_limit(0);
            if (strlen(session_id()) > 0) {
                session_write_close();
            }
            if ($multipart === true) {
                $range = array(0, $size - 1);
                if (array_key_exists('HTTP_RANGE', $_SERVER) === true) {
                    $range = array_map('intval', explode('-', preg_replace('~.*=([^,]*).*~', '$1', $_SERVER['HTTP_RANGE'])));
                    if (empty($range[1]) === true) {
                        $range[1] = $size - 1;
                    }
                    foreach ($range as $key => $value) {
                        $range[$key] = max(0, min($value, $size - 1));
                    }
                    if (($range[0] > 0) || ($range[1] < ($size - 1))) {
                        header(sprintf('%s %03u %s', 'HTTP/1.1', 206, 'Partial Content'), true, 206);
                    }
                }
                header('Accept-Ranges: bytes');
                header('Content-Range: bytes ' . sprintf('%u-%u/%u', $range[0], $range[1], $size));
            } else {
                $range = array(0, $size - 1);
            }
            header('Pragma: public');
            header('Cache-Control: public, no-cache');
            header('Content-Type: application/octet-stream');
            header('Content-Length: ' . sprintf('%u', $range[1] - $range[0] + 1));
            header('Content-Disposition: attachment; filename="' . basename($path) . '"');
            header('Content-Transfer-Encoding: binary');
            if ($range[0] > 0) {
                fseek($file, $range[0]);
            }
            else{
                //log if we are starting from 0
                log_download($path);
            }
            while ((feof($file) !== true) && (connection_status() === CONNECTION_NORMAL)) {
                echo fread($file, round($speed * 1024));
                flush();
                sleep(1);
            }
            fclose($file);
        }
        exit();
    } else {
        header(sprintf('%s %03u %s', 'HTTP/1.1', 404, 'Not Found'), true, 404);
    }

    return false;
}


function log_download($wholepath){
    $path = str_replace($_SERVER['CONTEXT_DOCUMENT_ROOT'], '/', $wholepath);

    $tracker = new GoogleAnalytics\Tracker('UA-42536493-5', 'burningfreetime.com');

    $visitor = new GoogleAnalytics\Visitor();
    $visitor->setIpAddress($_SERVER['REMOTE_ADDR']);
    $visitor->setUserAgent($_SERVER['HTTP_USER_AGENT']);
    //$visitor->setScreenResolution('1024x768');
    //// Assemble Session information
    //// (could also get unserialized from PHP session)
    $session = new GoogleAnalytics\Session();

    // Assemble Page information
    $page = new GoogleAnalytics\Page($path);
    $page->setTitle($path);

    // Track page view
    $tracker->trackPageview($page, $session, $visitor);
}

Download($filepath);

?>
