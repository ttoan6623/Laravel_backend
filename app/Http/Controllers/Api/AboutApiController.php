<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutPage;
use Illuminate\Support\Facades\Storage;

class AboutApiController extends Controller
{
    public function show()
    {
        $about = AboutPage::first();

        if (!$about) {
            return response()->json(['message' => 'Không tìm thấy trang About'], 404);
        }

        $about->thumbnail = $about->thumbnail ? asset($about->thumbnail) : null;

        return response()->json([
            'title' => $about->title,
            'content' => $about->content,
            'thumbnail' => $about->thumbnail,
        ]);
    }

    public function update(Request $request)
    {
        $about = AboutPage::first();

        if (!$about) {
            return response()->json(['message' => 'Không tìm thấy trang About'], 404);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
        ]);

        $about->title = $data['title'];
        $about->content = $data['content'];

        if ($request->hasFile('thumbnail')) {
            if ($about->thumbnail && Storage::disk('public')->exists($about->thumbnail)) {
                Storage::disk('public')->delete($about->thumbnail);
            }
            $about->thumbnail = $request->file('thumbnail')->store('about/thumbnails', 'public');
        }

        $about->save();

        $about->thumbnail = $about->thumbnail ? asset($about->thumbnail) : null;

        return response()->json([
            'message' => 'Cập nhật thành công',
            'about' => [
                'title' => $about->title,
                'content' => $about->content,
                'thumbnail' => $about->thumbnail,
            ]
        ]);
    }
}
