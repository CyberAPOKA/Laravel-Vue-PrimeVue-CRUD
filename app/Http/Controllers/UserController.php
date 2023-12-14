<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class UserController extends Controller
{
    public function create(UserRequest $request)
    {
        // sleep(3);
        // dd($request->all());

        $birthdate = Carbon::parse($request->input('birthdate'))->format('Y-m-d');

        $cpf = str_replace(['.', '-'], '', $request->input('cpf'));

        $phone_number = str_replace(['(', ')', ' ', '-'], '', $request->input('phone_number'));

        // $city = $request->input('city') ? $request->input('city')['cname'] : null;

        $email_verified_at = null;

        if ($request->input('email_verified_at') === true) {
            $email_verified_at = now();
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make('password'),
            'gender' => $request->input('gender'),
            'cpf' => $cpf,
            'birthdate' => $birthdate,
            'phone_number' => $phone_number,
            'city' => $request->input('city'),
            'status' => $request->input('status'),
            'role' => $request->input('role'),
            'email_verified_at' => $email_verified_at,
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        // sleep(3);
        
        $user = User::findOrFail($id);

        $birthdate = Carbon::parse($request->input('birthdate'))->format('Y-m-d');

        $cpf = str_replace(['.', '-'], '', $request->input('cpf'));

        $phone_number = str_replace(['(', ')', ' ', '-'], '', $request->input('phone_number'));

        $email_verified_at = null;

        if ($request->input('email_verified_at') === true) {
            $email_verified_at = now();
        }

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make('password'),
            'gender' => $request->input('gender'),
            'cpf' => $cpf,
            'birthdate' => $birthdate,
            'phone_number' => $phone_number,
            'city' => $request->input('city'),
            'status' => $request->input('status'),
            'role' => $request->input('role'),
            'email_verified_at' => $email_verified_at,
        ]);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        $user->delete();
    }

    public function exportExcel()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
