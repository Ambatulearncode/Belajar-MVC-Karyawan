<?php

namespace Core;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        // Tambahkan $view ke data
        $data['view'] = $view;

        // Extract data untuk digunakan di view
        extract($data);

        // Include main layout
        include __DIR__ . "/../app/views/layouts/main.php";
    }

    protected function renderPartial(string $partial, array $data = [])
    {
        extract($data);
        include_once __DIR__ . "/../app/views/partials/{$partial}.php";
    }
}
