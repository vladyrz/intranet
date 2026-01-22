<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;

class EasyChatController extends Controller
{
    public function redirect()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $key = env('EASYCHAT_SECRET');
        $easyChatUrl = env('EASYCHAT_URL');

        if (!$key || !$easyChatUrl) {
            abort(500, 'EasyChat configuration missing in .env');
        }

        $payload = [
            'id' => $user->id,
            'nombre' => $user->name, // Assuming 'name' is the field for user's name
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + (60 * 60) // Token valid for 1 hour
        ];

        $token = JWT::encode($payload, $key, 'HS256');

        return redirect("$easyChatUrl?token=$token");
    }
}
