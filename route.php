<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/functions.php';

class Route
{

    private array $routes = [];

    /**
     * ルートを登録する
     */
    public function get(string $path, array $handler): void
    {
        $this->routes["GET_" . $path] = $handler;
    }

    public function post(string $path, array $handler): void
    {
        $this->routes["POST_" . $path] = $handler;
    }

    /**
     * リクエストを解析し、マッチするハンドラーを実行する
     */
    public function dispatch(string $path, string $method): void
    {
        //pathのうち必要な情報以外はフィルターするようにする
        $check = $method . "_" . $path;
        if (array_key_exists($check, $this->routes)) {
            //TaskControllerが入っている。
            $class = new $this->routes[$check][0]();
            call_user_func([$class, $this->routes[$check][1]]);
            //対応するメソッドが入っている
        } else {
            errorOutput(404, 'Not Found');
        }
    }


    /**
     * レスポンスをJSONとして出力する共通メソッド
     */
}
