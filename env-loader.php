<?php
if (!function_exists('load_env')) {
    function load_env() {
        $env_path = '.env';
        if (!file_exists($env_path)) {
            error_log("Error: .env file is missing");
            return;
        }

        $lines = file($env_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) {
                continue;
            }
            [$key, $value] = explode('=', trim($line), 2);
            putenv(sprintf('%s=%s', $key, $value));
        }
    }
}

load_env();
?>
