<?php

namespace Core;

class Controller
{
    protected function view(string $view, array $data = [])
    {
        extract($data);

        $viewFile = __DIR__ . "/../app/views/" . $view . ".php";

        // ! Validasi file ada gak.
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View tidak ditemukan: " . $view . ".php di folder app/views/");
        }
    }

    protected function redirect($url)
    {
        header("Location: " . $url);
        exit;
    }
}
