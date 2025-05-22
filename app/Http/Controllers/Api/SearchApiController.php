<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchApiController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query('q', '');

        if (empty($query)) {
            return response()->json([
                'message' => 'Search query is required',
                'data' => []
            ], 400);
        }

        $posts = Post::query()
            ->where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->orWhereHas('tags', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->orWhereHas('category', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->with(['category', 'tags'])
            ->latest()
            ->paginate(10);

        return response()->json([
            'message' => $posts->isEmpty() ? 'Không tìm thấy bài viết phù hợp.' : 'Search results retrieved successfully',
            'data' => $posts
        ], 200);
    }

    public function filter(Request $request)
    {
        $category = $request->query('category');
        $tags = $request->query('tags');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        $query = Post::query()->with(['category', 'tags']);

        // Lọc theo danh mục
        if ($category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('name', $category);
            });
        }

        // Lọc theo thẻ (tags)
        if ($tags) {
            $tagsArray = array_map('trim', explode(',', $tags));
            $query->whereHas('tags', function ($q) use ($tagsArray) {
                $q->whereIn('name', $tagsArray);
            });
        }

        // Lọc theo khoảng thời gian
        if ($start_date) {
            $query->whereDate('created_at', '>=', $start_date);
        }
        if ($end_date) {
            $query->whereDate('created_at', '<=', $end_date);
        }

        $posts = $query->latest()->paginate(10);

        return response()->json([
            'message' => $posts->isEmpty() ? 'Không tìm thấy bài viết phù hợp.' : 'Filtered results retrieved successfully',
            'data' => $posts
        ], 200);
    }
}
