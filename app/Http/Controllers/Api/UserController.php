<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view users'])->only('index');
    }

    public function index()
    {
        return response()->json([
            'users' => User::all()
        ]);
    }
}
