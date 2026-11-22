<?php

declare(strict_types=1);

require_once __DIR__ . '/route.php';
require_once __DIR__ . '/controllers/tasks.php';
require_once __DIR__ . '/includes/functions.php';

//正しいリクエスト以外はフィルターしたい。
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];

$router = new Route();

//ルートを登録
$router->get('/tasks', [TaskController::class, 'index']);
$router->post('/tasks', [TaskController::class, 'store']);
$router->get('/tasks/:id', [TaskController::class, 'show']);


//受け取ったパスをもとに関数を呼ぶ
if (str_contains($path, "../")) {
    errorOutput(403, "パストラバーサルは禁止されています");
} else {
    $router->dispatch($path, $method);
}

//存在しなければnot foundにする。


//こいつらの組み合わせで分岐させるようにする
