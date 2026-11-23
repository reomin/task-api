<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../data/dbConnection.php';

class TaskController
{
    public function index(): void
    {
        $db = new dbConnection();
        $tasks = $db->getAllTasks();

        http_response_code(200);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($tasks, JSON_UNESCAPED_UNICODE);
        exit;
    }

    //POST   /tasks        タスク作成（bodyからtitleを受け取る）
    public function store(): void
    {
        $httpBody = file_get_contents('php://input');
        $data = json_decode($httpBody, true);

        if (array_key_exists('name', $data)) {
            $name = $data['name'];
        } else {
            errorOutput(400, "リクエストボディにnameが含まれていません");
        }

        $db = new dbConnection();
        $db->AddTask($name);
    }


    //dummy用のcurl
    //curl -X POST localhost:8000/tasks -H "Content-Type: application/json" -d '{"name":"test","status":"todo"}'
}
