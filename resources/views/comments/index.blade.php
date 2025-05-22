<!DOCTYPE html>
<html>
<head>
    <title>Danh sách bài viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
@extends('layouts.dashboard')
@section('content')
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/style1.css') }}">
    <style>
        .table th.id-col, .table td.id-col {
            width: 50px;
            text-align: center;
            vertical-align: middle;
        }
        .table th.title-col, .table td.title-col {
            width: 350px;
            text-align: center;
            vertical-align: middle;
        }
        .table th.image-col, .table td.image-col {
            width: 120px;
            text-align: center;
            vertical-align: middle;
        }
        .table th.action-col, .table td.action-col {
            width: 150px;
            text-align: center;
            vertical-align: middle;
        }
        .table td.image-col img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            display: block;
            margin: 0 auto;
        }
        .action-links .btn {
            margin: 0 5px;
        }
    </style>
    <div class="main-content">
        <div class="container">
            <h1>Danh sách bài viết</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="id-col">ID</th>
                        <th class="title-col">Tiêu đề</th>
                        <th class="image-col">Ảnh</th>
                        <th class="action-col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td class="id-col">{{ $post->id }}</td>
                        <td class="title-col">{{ $post->title }}</td>
                        <td>
                            @if($post->thumbnail)
                                <img src="{{ asset($post->thumbnail) }}" width="80" height="60"
                                    loading="lazy" alt="Thumbnail {{ $post->title }}"
                                    style="object-fit: cover; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            @endif
                        </td>
                        <td class="action-col">
                            <a href="{{ route('comments.show', $post) }}" class="btn btn-sm btn-primary">
                                Quản lý bình luận
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $posts->links() }}
        </div>
    </div>
@endsection
</body>
</html>
