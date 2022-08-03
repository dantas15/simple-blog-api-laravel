<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
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
