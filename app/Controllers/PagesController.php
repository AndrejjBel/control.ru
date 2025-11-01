<?php

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;

class PagesController extends Controller
{
    public function index(): View
    {
        return view('/admin/admin', ['title' => 'Home', 'description' => 'Home description']);
    }

    public function info(): View
    {
        return view('/info',
            [
                'data'  => [
                    'body_classes' => 'home',
                    'temp_header' => 'header-pages',
                    'title' => 'Контроль калорий',
                    'description' => 'Контроль калорий description',
                    'mod' => 'home'
                ]
            ]
        );
    }
}
