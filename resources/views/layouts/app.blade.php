<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>سیستم مدیریت تعمیرات تجهیزات | {{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/css/custom.css'])

    <!-- Scripts -->
    @vite(['resources/js/app.js'])

    <!-- Custom Styles -->
    <style>
        .scfers-primary {
            color: #1a56db;
        }

        .scfers-secondary {
            color: #0e9f6e;
        }

        .scfers-dark {
            color: #1f2937;
        }

        .scfers-light {
            color: #f9fafb;
        }

        .bg-scfers-primary {
            background-color: #1a56db;
        }

        .bg-scfers-secondary {
            background-color: #0e9f6e;
        }

        .bg-scfers-dark {
            background-color: #1f2937;
        }

        .bg-scfers-light {
            background-color: #f9fafb;
        }

        .border-scfers-primary {
            border-color: #1a56db;
        }

        .hover\:bg-scfers-primary:hover {
            background-color: #1a56db;
        }

        .hover\:bg-scfers-secondary:hover {
            background-color: #0e9f6e;
        }

        .page-header {
            background: linear-gradient(90deg, #1a56db, #0e9f6e);
            color: white;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .page-content {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin: 1rem;
            padding: 1.5rem;
        }

        .notification-badge {
            position: relative;
            top: -10px;
            right: -10px;
        }

        .sidebar {
            background-color: #1f2937;
            color: white;
            min-height: calc(100vh - 4rem);
            transition: all 0.3s;
        }

        .sidebar-item {
            transition: all 0.2s;
            border-radius: 4px;
        }

        .sidebar-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-item.active {
            background-color: #1a56db;
        }

        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
<!-- Navigation -->
@include('layouts.navigation')

<div class="flex flex-col md:flex-row min-h-screen">
    <!-- Sidebar Navigation -->
    <nav class="sidebar w-full md:w-64 p-4 hidden md:block">
        <div class="mb-8 text-center py-4 border-b border-gray-700">
            <h2 class="text-xl font-bold">سیستم تعمیرات تجهیزات</h2>
            <p class="text-sm text-gray-300 mt-1">شرکت نیشکر</p>
        </div>

        <ul class="space-y-2">
            <li>
                <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center p-3 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    داشبورد
                </a>
            </li>

            <li>
                <a href="{{ route('equipment.index') }}" class="sidebar-item flex items-center p-3 {{ request()->routeIs('equipment.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                    مدیریت تجهیزات
                </a>
            </li>

            <li>
                <a href="{{ route('repair-requests.index') }}" class="sidebar-item flex items-center p-3 {{ request()->routeIs('repair-requests.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    درخواست‌های تعمیر
                </a>
            </li>

            <li>
                <a href="{{ route('reports.equipment') }}" class="sidebar-item flex items-center p-3 {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    گزارشات
                </a>
            </li>

            @can('system_admin')
                <li>
                    <a href="{{ route('users.index') }}" class="sidebar-item flex items-center p-3 {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        مدیریت کاربران
                    </a>
                </li>
            @endcan
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="flex-1">
        <!-- Page Heading -->
        @isset($header)
            <header class="page-header py-4 px-6">
                <div class="max-w-7xl mx-auto">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="page-content max-w-7xl mx-auto">
            <!-- Notification Area -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 py-4 mt-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-600 dark:text-gray-400 text-sm">
                <p>سیستم مدیریت تعمیرات تجهیزات شرکت نیشکر &copy; {{ date('Y') }}</p>
                <p class="mt-1">توسعه یافته توسط تیم فنی شرکت</p>
            </div>
        </footer>
    </div>
</div>

<!-- Mobile Navigation -->
<div class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 md:hidden">
    <div class="flex justify-around py-2">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center p-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-xs mt-1">داشبورد</span>
        </a>

        <a href="{{ route('equipment.index') }}" class="flex flex-col items-center p-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
            </svg>
            <span class="text-xs mt-1">تجهیزات</span>
        </a>

        <a href="{{ route('repair-requests.index') }}" class="flex flex-col items-center p-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            <span class="text-xs mt-1">تعمیرات</span>
        </a>

        <a href="{{ route('reports.equipment') }}" class="flex flex-col items-center p-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="text-xs mt-1">گزارشات</span>
        </a>
    </div>
</div>

<!-- Scripts -->
<script>
    // Toggle sidebar on mobile
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('hidden');
    }

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipElements = document.querySelectorAll('[data-tooltip]');
        tooltipElements.forEach(el => {
            el.addEventListener('mouseenter', showTooltip);
            el.addEventListener('mouseleave', hideTooltip);
        });

        function showTooltip(e) {
            const tooltipText = this.getAttribute('data-tooltip');
            const tooltip = document.createElement('div');
            tooltip.className = 'absolute bg-gray-900 text-white text-xs rounded py-1 px-2 z-50';
            tooltip.textContent = tooltipText;
            tooltip.style.top = (this.getBoundingClientRect().top - 30) + 'px';
            tooltip.style.left = this.getBoundingClientRect().left + 'px';
            tooltip.id = 'custom-tooltip';
            document.body.appendChild(tooltip);
        }

        function hideTooltip() {
            const tooltip = document.getElementById('custom-tooltip');
            if (tooltip) {
                tooltip.remove();
            }
        }
    });
</script>
@stack('scripts')
</body>
</html>
