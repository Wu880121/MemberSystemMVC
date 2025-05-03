<?php

function logError(Throwable $e)
{
    $logDir = __DIR__ . '/../logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0777, true);
    }

    $logFile = $logDir . '/error.log';

    $message = sprintf(
        "[%s] %s in %s on line %d\nStack trace:\n%s\n\n",
        date('Y-m-d H:i:s'),
        $e->getMessage(),
        $e->getFile(),
        $e->getLine(),
        $e->getTraceAsString()
    );

    file_put_contents($logFile, $message, FILE_APPEND);
}
