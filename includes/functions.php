<?php

declare(strict_types=1);

function errorOutput(int $code, string $message): never
{
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');

    $output = ['status' => "error", 'message' => $message];
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
};
