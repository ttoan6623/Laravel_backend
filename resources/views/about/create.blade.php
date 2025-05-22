<!DOCTYPE html>
<html>
<head>
    <title>Tạo trang About mới</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('summernote/summernote-bs5.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism.min.css">
</head>
<body>
    <style>
        .note-editor, .note-frame {
            font-family: Arial, sans-serif !important;
            background: #fff !important;
            border: 1px solid #ccc !important;
        }
        .note-editable {
            min-height: 400px;
        }
        .preview-img {
            max-width: 200px;
            height: auto;
            margin: 10px 5px;
        }
    </style>

    <div class="main-content">
        <div class="container mt-5">
            <h1>Tạo trang About mới</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('about.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label>Title:</label>
                <input type="text" name="title" value="{{ old('title') }}" required>

                <label>Content:</label>
                <textarea name="content" required>{{ old('content') }}</textarea>

                <label>Thumbnail:</label>
                <input type="file" name="thumbnail">

                <button type="submit">Create</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('summernote/summernote-bs5.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script>
        jQuery(document).ready(function($) {
            $('#content').summernote({
                height: 400,
                toolbar: [
                    ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        let data = new FormData();
                        data.append('file', files[0]);
                        $.ajax({
                            url: '{{ route("about.upload-image") }}',
                            method: 'POST',
                            data: data,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                $('#content').summernote('insertImage', response.url);
                            },
                            error: function(xhr) {
                                alert('Lỗi khi tải ảnh: ' + (xhr.responseJSON?.error || 'Không thể tải ảnh'));
                            }
                        });
                    }
                }
            });

            $('#thumbnail').on('change', function(e) {
                const preview = $('#thumbnail-preview');
                preview.empty();
                const file = e.target.files[0];
                if (file) {
                    const img = $('<img>').attr({
                        src: URL.createObjectURL(file),
                        class: 'preview-img'
                    });
                    preview.append(img);
                }
            });

            $('#images').on('change', function(e) {
                const preview = $('#images-preview');
                preview.empty();
                const files = e.target.files;
                for (let file of files) {
                    const img = $('<img>').attr({
                        src: URL.createObjectURL(file),
                        class: 'preview-img'
                    });
                    preview.append(img);
                }
            });
        });
    </script>
</body>
</html>
