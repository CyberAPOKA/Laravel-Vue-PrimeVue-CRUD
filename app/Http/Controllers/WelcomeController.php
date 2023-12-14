<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Log;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $users = User::get(['id', 'name', 'email', 'birthdate', 'gender', 'cpf', 'phone_number', 'city', 'status', 'role', 'email_verified_at']);

        return Inertia::render('Welcome', [
            'users' => $users
        ]);
    }

    public function logs()
    {
        $logs = Log::all();

        return Inertia::render('Logs', [
            'logs' => $logs
        ]);
    }
}
