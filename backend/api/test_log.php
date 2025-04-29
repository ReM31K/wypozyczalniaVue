<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$logFile = __DIR__ . '/log.txt';

// Простіше тестування запису
if (file_put_contents($logFile, "Test log message\n", FILE_APPEND)) {
    echo "Log written successfully!";
} else {
    echo "Failed to write log.";
}
