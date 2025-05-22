<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <div class="container mt-5">
                <h1>Danh sách liên hệ</h1>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Hiển thị danh sách liên hệ -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Nội dung</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $contact)
                        <tr>
                            <td>{{ $contact->id }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ Str::limit($contact->message, 50) }}</td>
                            <td>
                                <a href="{{ url('/contacts/' . $contact->id) }}" class="btn btn-sm btn-info">Xem chi tiết</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endsection
</body>
</html>
