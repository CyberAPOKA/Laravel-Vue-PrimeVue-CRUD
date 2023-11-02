<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $canLogin = Route::has('login');
        $canRegister = Route::has('register');
        $users = User::get(['id', 'name', 'email']);

        return Inertia::render('Welcome', [
            'canLogin' => $canLogin,
            'canRegister' => $canRegister,
            'users' => $users
        ]);
    }
}
