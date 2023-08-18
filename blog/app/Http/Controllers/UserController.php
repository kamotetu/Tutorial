<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::id();
        $user = User::query()
            ->where('id', '=', $user_id)
            ->with(['articles' => function ($query) {
                $query->orderByDesc('id');
            }])
            ->first();

        return view(
            'user.index',
            [
                'user' => $user,
            ]
        );
    }
}
