<?php
namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function listUsers()
    {
        $users = User::all();
        return view('users-list', ['users' => $users]);
    }

    public function register(Request $request, Response $response)
    {
        $data = $request->all();
        $response->setStatusCode(200);
        Log::info('incoming request', $request->all());
        $this->createUser($data);
        return $response->send();
    }

    private function createUser(array $data)
    {
        $user = new User();
        $user->email = $data['email'];
        $user->name = $data['name'];
        $user->password = Hash::make('password');
        $user->save();
    }
}