@extends('layouts.dashboard')

<link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('admin/css/style1.css') }}">

@section('content')
    <main class="about-page">
        <div class="main-content">
            <h1 class="about-title">{{ $about->title }}</h1>

            @if($about->thumbnail)
                <div class="about-thumbnail">
                    <img src="{{ asset($about->thumbnail) }}" alt="Thumbnail" class="thumbnail-img">
                </div>
            @endif

            <div class="about-content">
                {!! $about->content !!}
            </div>

            <div class="edit-button" style="margin-bottom: 20px;">
                <a href="{{ route('about.edit', $about->id) }}" class="btn btn-warning">Chỉnh sửa</a>
            </div>

        </div>
    </main>

    <style>
        .about-page {
            max-width: 600px;
            margin: 0 auto;
            padding: 0px 20px;
            color: #333;
            text-align: center;
        }

        .about-title {
            font-size: 28px;
            font-weight: bold;
        }

        .about-subtitle {
            font-size: 14px;
            color: rgb(45, 39, 39);
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .about-content {
            margin-bottom: 30px;
            font-size: 16px;
            line-height: 1.6;
            text-align: left;
        }

        .about-content img {
            max-width: 100%;
            height: auto;
        }

        .about-thumbnail {
            margin-bottom: 30px;
        }

        .thumbnail-img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }

        .about-images {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .additional-img {
            max-width: 200px;
            height: auto;
            border-radius: 4px;
        }

        .no-content {
            font-size: 16px;
            color: rgb(245, 245, 245);
            text-align: center;
        }
    </style>
@endsection
