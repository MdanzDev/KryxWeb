<?php
if (!function_exists('load_env')) {
    function load_env() {
        $lines = file('.env');
        foreach ($lines as $line) {
            if (trim($line) === '' || str_starts_with(trim($line), '#')) {
                continue;
            }
            [$key, $value] = explode('=', trim($line), 2);
            putenv(sprintf('%s=%s', $key, $value));
        }
    }
}

load_env();
?>
