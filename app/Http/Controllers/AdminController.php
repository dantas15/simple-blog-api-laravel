<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @return JsonResponse
     */
    public function users(): JsonResponse
    {
        return response()->json([
            'data' => User::all() ?? [],
        ]);
    }
}
