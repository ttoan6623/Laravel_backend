<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $postsCount = Post::count();

        $commentsCount = Comment::count();

        $categoriesCount = Category::count();

        $followersCount = 103;
        $viewsCount = 1060;

        return view('components.container', compact(
            'followersCount',
            'commentsCount',
            'postsCount',
            'categoriesCount',
            'categoriesCount'
        ));
    }
}
