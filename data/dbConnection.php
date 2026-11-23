<?php

declare(strict_types=1);

use Dom\Sqlite;

class dbConnection
{

    private PDO $pdo;

    public function __construct()
    {
        $dbPath = __DIR__ . "/database.sqlite";
        $this->pdo = new PDO("sqlite:" . $dbPath, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        $this->initializeSchema();
    }

    //DBが存在するかを確認して、存在すればそのDBを使う。存在しなければ作成する」
    private function initializeSchema(): void
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS tasks (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            status TEXT NOT NULL,
            created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
        )";

        $this->pdo->exec($sql);
    }


    public function getAllTasks(): array
    {
        //$this->createDummyRecord();
        $sql = "SELECT * FROM tasks;";
        $stmt = $this->pdo->query($sql);
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $tasks;
    }

    public function AddTask(string $name): void
    {
        //$this->createDummyRecord();

        try {
            $stmt = $this->pdo->prepare('INSERT INTO tasks (name, status) VALUES (:name, "todo")');
            $stmt->execute(["name" => $name]);
        } catch (PDOException $e) {
            http_response_code(400);
            header('Content-Type: application/json; charset=utf-8');
            echo $e->getMessage();
            exit;
        }

        http_response_code(200);
        header('Content-Type: application/json; charset=utf-8');
        echo "成功";
        exit;
    }

    public function createDummyRecord()
    {
        $this->pdo->exec('INSERT INTO tasks (name, status) VALUES ("hoge", "done")');
    }
}
