<?php
namespace Src\Controllers;

class UserController
{
    public function index()
    {
        echo json_encode([
            "success" => true,
            "data" => [
                ["id" => 1, "name" => "Admin", "email" => "admin@example.com"],
                ["id" => 2, "name" => "Arnitha", "email" => "arnithasarapang29@gmail.com"]
            ]
        ]);
    }

    public function show($params)
    {
        $id = $params['id'] ?? null;

        echo json_encode([
            "success" => true,
            "data" => [
                "id" => $id,
                "name" => "User $id"
            ]
        ]);
    }
}
