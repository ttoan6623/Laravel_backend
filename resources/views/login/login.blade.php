<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
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
            color: #333;
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
            box-sizing: border-box;
        }

        .form-container h2 {
            margin-bottom: 20px;
            font-size: 32px;
            color: #6C63FF;
            font-weight: 700;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        label {
            color: #fff;
            font-size: 20px;
            display: block;
            text-align: left;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.8);
            font-size: 16px;
            box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.1), inset -2px -2px 5px rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            background: #ffffff;
            box-shadow: 0 0 10px rgba(108, 99, 255, 0.8);
            outline: none;
            transform: scale(1.02);
        }

        button {
            background: linear-gradient(to right, #6C63FF, #8E44AD);
            color: #fff;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(245, 243, 243, 0.5);
            transition: transform 0.2s ease, background 0.3s ease;
            display: block;
            width: 100%;
            margin-top: 10px;
        }

        button:hover {
            background: linear-gradient(to right, #574FBB, #6C44FF);
            transform: translateY(-3px);
        }

        .errors {
            color: #e74c3c;
            margin: 20px 0;
        }

        p {
            text-align: center;
        }

        p a {
            color: #6C63FF;
            text-decoration: none;
            font-weight: 500;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Đăng nhập</h2>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <label for="name">Tên người dùng:</label>
            <input type="text" id="name" name="name" required>

            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>

            <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
            <button type="submit">Đăng nhập</button>
        </form>

        <p>Chưa có tài khoản? <a href="#">Đăng ký ngay</a></p>
    </div>
</body>
</html>
