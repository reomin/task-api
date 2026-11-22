<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

class TaskController
{
    public function index(): void
    {
        $tasks = [
            "tasks" => []
        ];

        http_response_code(200);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($tasks, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function store(): void
    {
        $tasks = [
            "task" => ["id" => 1, "title" => "サンプル"]
        ];

        http_response_code(201);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($tasks, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
