<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: url('https://images.pexels.com/videos/5948574/pexels-photo-5948574.jpeg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            text-align: left;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        h2 {
            color: #6C63FF;
            text-align: center;
        }

        label, input {
            display: block;
            width: 100%;
            margin-top: 5px;
        }
        .form-container form input{
            font-size: 20px;
            height: 40px;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.1), inset -2px -2px 5px rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .form-container form label {
            color: white;
            font-size: 18px;
            font-weight: 500;
        }

        button {
            background: linear-gradient(to right, #6C63FF, #8E44AD);
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            margin-top: 10px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Quên mật khẩu</h2>
        @if(session('status'))
            <p class="success-message">{{ session('status') }}</p>
        @endif
        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <label for="email">Email của bạn:</label>
            <input type="email" name="email" id="email" required>
            <button type="submit">Gửi yêu cầu</button>
        </form>
    </div>
</body>
</html>
