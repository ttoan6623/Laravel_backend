<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostApiController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10)->through(function ($post) {
            $post->thumbnail = $post->thumbnail ? asset($post->thumbnail) : null;
            $post->images = $post->images ? array_map(function ($image) {
                return asset($image);
            }, is_string($post->images) ? json_decode($post->images, true) : $post->images) : [];
            return $post;
        });

        return response()->json($posts);
    }

    public function show(Post $post)
    {
        $post->thumbnail = $post->thumbnail ? asset($post->thumbnail) : null;
        $post->images = $post->images ? array_map(function ($image) {
            return asset($image);
        }, is_string($post->images) ? json_decode($post->images, true) : $post->images) : [];

        return response()->json($post);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            'tags' => 'nullable|array',
        ]);

        $data = $request->only(['title', 'content', 'category_id']);

        // Xử lý thumbnail
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('posts/thumbnails', 'public');
        }

        // Xử lý images
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('posts/images', 'public');
            }
            $data['images'] = json_encode($imagePaths);
        }

        $post = Post::create($data);

        if ($request->has('tags')) {
            $tagIds = [];
            foreach ($request->tags as $tagName) {
                $tag = \App\Models\Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName)]
                );
                $tagIds[] = $tag->id;
            }
            $post->tags()->sync($tagIds);
        }

        $post->thumbnail = $post->thumbnail ? asset($post->thumbnail) : null;
        $post->images = $post->images ? array_map(function ($image) {
            return asset($image);
        }, json_decode($post->images, true) ?: []) : [];

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post
        ], 201);
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required',
            'category_id' => 'sometimes|required|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            'tags' => 'nullable|array',
        ]);

        $data = $request->only(['title', 'content', 'category_id']);

        // Xử lý thumbnail
        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail && Storage::disk('public')->exists($post->thumbnail)) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('posts/thumbnails', 'public');
        }

        // Xử lý images
        if ($request->hasFile('images')) {
            if ($post->images) {
                $oldImages = is_string($post->images) ? json_decode($post->images, true) : $post->images;
                foreach ($oldImages as $oldImage) {
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('posts/images', 'public');
            }
            $data['images'] = json_encode($imagePaths);
        }

        $post->update($data);

        if ($request->has('tags')) {
            $tagIds = [];
            foreach ($request->tags as $tagName) {
                $tag = \App\Models\Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName)]
                );
                $tagIds[] = $tag->id;
            }
            $post->tags()->sync($tagIds);
        }

        $post->thumbnail = $post->thumbnail ? asset($post->thumbnail) : null;
        $post->images = $post->images ? array_map(function ($image) {
            return asset($image);
        }, json_decode($post->images, true) ?: []) : [];

        return response()->json([
            'message' => 'Post updated successfully',
            'post' => $post
        ]);
    }

    public function destroy(Post $post)
    {
        if ($post->thumbnail && Storage::disk('public')->exists($post->thumbnail)) {
            Storage::disk('public')->delete($post->thumbnail);
        }
        if ($post->images) {
            $images = is_string($post->images) ? json_decode($post->images, true) : $post->images;
            foreach ($images as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }
        $post->tags()->detach();
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }

    public function related(Post $post)
    {
        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($relatedPost) {
                $relatedPost->thumbnail = $relatedPost->thumbnail ? asset($relatedPost->thumbnail) : null;
                $relatedPost->images = $relatedPost->images ? array_map(function ($image) {
                    return asset($image);
                }, is_string($relatedPost->images) ? json_decode($relatedPost->images, true) : $relatedPost->images) : [];
                return $relatedPost;
            });

        return response()->json($relatedPosts);
    }

    public function postsByCategory($categoryId)
    {
        $posts = Post::where('category_id', $categoryId)
            ->latest()
            ->get()
            ->map(function ($post) {
                $post->thumbnail = $post->thumbnail ? asset($post->thumbnail) : null;
                $post->images = $post->images ? array_map(function ($image) {
                    return asset($image);
                }, is_string($post->images) ? json_decode($post->images, true) : $post->images) : [];
                return $post;
            });

        return response()->json($posts);
    }

    public function tags(Post $post)
    {
        $tags = $post->tags()->get();
        return response()->json($tags);
    }
}
