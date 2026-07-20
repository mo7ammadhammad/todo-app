<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - Advanced Todo</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #4a3f7a, #2b2254);
            min-height: 100vh; display: flex; justify-content: center; align-items: center; margin: 0;
        }
        .auth-container {
            background: white; width: 100%; max-width: 400px; padding: 35px; border-radius: 25px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); text-align: center;
        }
        h2 { color: #1e293b; margin-bottom: 25px; }
        input {
            width: 100%; padding: 14px; margin-bottom: 15px; border: 1px solid #cbd5e1; border-radius: 12px; font-size: 15px; outline: none; box-sizing: border-box;
        }
        button {
            width: 100%; padding: 14px; border: none; border-radius: 12px; font-weight: bold; cursor: pointer; font-size: 15px; transition: 0.2s; margin-bottom: 10px;
        }
        .btn-login { background: #4a3f7a; color: white; }
        .btn-register { background: #e2e8f0; color: #1e293b; }
        .error { color: #f87171; font-size: 14px; margin-bottom: 15px; text-align: right; }
    </style>
</head>
<body>
    <div class="auth-container">
        <h2>🚀 Advanced Todo</h2>
        
        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('auth.login') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="البريد الإلكتروني" required>
            <input type="password" name="password" placeholder="كلمة المرور" required>
            <button type="submit" class="btn-login">تسجيل الدخول</button>
            <button type="submit" formaction="{{ route('auth.register') }}" class="btn-register">إنشاء حساب جديد</button>
        </form>
    </div>
</body>
</html>