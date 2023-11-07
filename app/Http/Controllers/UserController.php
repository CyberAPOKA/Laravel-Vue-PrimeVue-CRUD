<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function create(UserRequest $request)
    {
        // sleep(5);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make('password')
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        // dd($request->all(), $id);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email')
        ]);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        $user->delete();
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
