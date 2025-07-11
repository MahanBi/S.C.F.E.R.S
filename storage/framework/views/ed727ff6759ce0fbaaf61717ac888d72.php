<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>سیستم مدیریت تعمیرات تجهیزات | <?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
            background: linear-gradient(135deg, #1a56db 0%, #0e9f6e 100%);
            background-attachment: fixed;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-title {
            color: #1a56db;
            font-weight: 700;
            font-size: 1.8rem;
            margin-top: 1rem;
        }

        .login-subtitle {
            color: #4b5563;
            font-size: 1rem;
        }

        .scfers-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #1a56db 0%, #0e9f6e 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .scfers-logo-inner {
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .input-field {
            border-radius: 8px;
            border: 1px solid #d1d5db;
            padding: 0.75rem 1rem;
            transition: all 0.3s;
            width: 100%;
        }

        .input-field:focus {
            border-color: #1a56db;
            box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.1);
            outline: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1a56db 0%, #0e9f6e 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .footer-links {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
            gap: 1rem;
        }

        .footer-link {
            color: #4b5563;
            font-size: 0.875rem;
            transition: color 0.3s;
        }

        .footer-link:hover {
            color: #1a56db;
            text-decoration: underline;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #9ca3af;
            margin: 1.5rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e5e7eb;
        }

        .divider::before {
            margin-right: 0.5rem;
        }

        .divider::after {
            margin-left: 0.5rem;
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="font-sans text-gray-900 antialiased">
<div class="min-h-screen flex flex-col sm:justify-center items-center py-6 px-4">
    <div class="login-header">
        <div class="scfers-logo">
            <div class="scfers-logo-inner">SC</div>
        </div>
        <h1 class="login-title">سیستم مدیریت تعمیرات تجهیزات</h1>
        <p class="login-subtitle">شرکت نیشکر</p>
    </div>

    <div class="w-full sm:max-w-md login-card px-6 py-8 overflow-hidden">
        <?php echo e($slot); ?>


        <div class="divider">یا</div>

        <div class="footer-links">
            <a href="<?php echo e(route('login')); ?>" class="footer-link">ورود به سیستم</a>
            <a href="<?php echo e(route('register')); ?>" class="footer-link">ثبت نام</a>
            <a href="<?php echo e(route('password.request')); ?>" class="footer-link">بازیابی رمزعبور</a>
        </div>
    </div>

    <footer class="mt-8 text-center text-white text-sm">
        <p>سیستم مدیریت تعمیرات تجهیزات شرکت نیشکر &copy; <?php echo e(date('Y')); ?></p>
        <p class="mt-1">توسعه یافته توسط تیم فنی شرکت</p>
    </footer>
</div>
</body>
</html>
<?php /**PATH C:\Users\digiland\S.C.F.E.R.S\resources\views/layouts/guest.blade.php ENDPATH**/ ?>