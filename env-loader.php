<?php
function getenv($key) {
    $env = file(__DIR__ . '/../admin/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($env as $line) {
        list($k, $v) = explode('=', $line, 2);
        if (trim($k) === $key) {
            return trim($v);
        }
    }
    return null;
}
?>
