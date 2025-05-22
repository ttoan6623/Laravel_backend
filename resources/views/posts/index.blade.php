<!DOCTYPE html>
<html>
<head>
    <title>Danh sách bài viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/style1.css') }}">
    <style>
    .table-search-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        width: 100%;
        box-sizing: border-box;
    }

    .table-search-form {
        display: flex;
        align-items: center;
        gap: 5px;
        width: 100%;
        max-width: 350px;
        border-radius: 150px;
    }

    .table-search-form button {
        height: 38px;
        width: 45px;
        border: none;
        border-radius: 5px;
        background-color: #007bff;
        color: white;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.3s ease;

        position: relative;
        top: -7px;
    }
    .table-search-form input[type="text"] {
        flex-grow: 1;
        height: 38px;
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        font-size: 14px;
        box-sizing: border-box;
    }

    .table-search-form input[type="text"]:focus {
        border-color: #007bff;
        background-color: #ffffff;
    }

    .table-search-form button {
        height: 38px;
        width: 80px;
        border: none;
        border-radius: 5px;
        background-color: #007bff;
        color: white;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .table-search-form button:hover {
        background-color: #0056b3;
    }
    .table th, .table td {
        text-align: center;
        vertical-align: middle;
    }
    </style>
</head>
<body>
@extends('layouts.dashboard')
@section('content')
    <div class="main-content">
        <div class="container">
            <h1 class="text-center mb-3">Danh sách bài viết</h1>

            <div class="table-search-wrapper">
                <form class="table-search-form" action="{{ route('posts.index') }}" method="GET">
                    <input type="text" name="search" placeholder="Tìm kiếm bài viết" value="{{ $search ?? '' }}" />
                    <button type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <a href="{{ route('posts.create') }}" class="add-link">Thêm bài viết</a>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề</th>
                        <th>Danh mục</th>
                        <th>Ảnh</th>
                        <th>Tag</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->category->name ?? '-' }}</td>
                        <td>
                            @if($post->thumbnail)
                                <img src="{{ asset($post->thumbnail) }}" width="80" height="60"
                                    loading="lazy" alt="Thumbnail {{ $post->title }}"
                                    style="object-fit: cover; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            @endif
                        </td>
                        <td>
                            @foreach($post->tags as $tag)
                                <span class="badge bg-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-primary btn-sm">Xem</a>
                            <a href="#" class="btn btn-danger btn-sm"
                            onclick="event.preventDefault(); if(confirm('Bạn có chắc muốn xóa bài viết này không?')) document.getElementById('delete-post-{{ $post->id }}').submit();">
                                Xóa
                            </a>
                            <form id="delete-post-{{ $post->id }}" action="{{ route('posts.destroy', $post) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $posts->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchTrigger = document.querySelector('.search-trigger');
            const searchDropdown = document.querySelector('.table-search-dropdown');

            searchTrigger.addEventListener('click', function () {
                searchDropdown.classList.toggle('active');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function (event) {
                if (!searchTrigger.contains(event.target) && !searchDropdown.contains(event.target)) {
                    searchDropdown.classList.remove('active');
                }
            });
        });
    </script>
@endsection
</body>
</html>
