<?php
namespace App\Controllers;

class Dashboard extends BaseController
{
    public function admin()
    {
        return view('dashboard/admin');
    }

    public function ruangan()
    {
        return view('dashboard/ruangan');
    }

    public function it()
    {
        return view('dashboard/it');
    }
} 