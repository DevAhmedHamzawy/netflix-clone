<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $users_count = User::whereRole('user')->count();
        $categories_count = Category::count();
        $movies_count = Movie::wherePercent(100)->count();
        return view('dashboard.welcome', compact('users_count', 'movies_count', 'categories_count'));
    }

}
