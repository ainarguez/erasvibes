<?php

namespace App\Http\Controllers;

use App\Http\Middleware\IsAdmin;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(IsAdmin::class);  //  protege el acceso al controlador
    }

    public function index()
    {
        return view('admin.index');
    }
}
