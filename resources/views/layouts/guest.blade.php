@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

        <style>
            body {
                font-family: Tahoma, sans-serif;
                margin: 0;
                background: #f2f4f7;
                color: #1f2937;
            }
            header {
                background-color: #2c3e50;
                color: white;
                padding: 12px 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 10px;
                flex-wrap: wrap;
            }
            .brand {
                font-weight: bold;
                font-size: 20px;
            }
            .nav-links {
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
            }
            .nav-links a {
                text-decoration: none;
                background: #3d556d;
                color: #fff;
                padding: 8px 12px;
                border-radius: 6px;
                font-size: 14px;
            }
            .nav-links a:hover {
                background: #4c6a86;
            }
            .container {
                max-width: 960px;
                margin: 0 auto;
                padding: 24px 20px;
            }
            .card {
                border: 1px solid #ddd;
                border-radius: 10px;
                padding: 20px;
                background: #fff;
                box-shadow: 0 0 8px rgba(0, 0, 0, 0.06);
                max-width: 560px;
                margin: 0 auto;
            }
            .alert-success {
                background-color: #d4edda;
                color: #155724;
                padding: 10px;
                border-radius: 5px;
                margin-bottom: 14px;
            }
            footer {
                margin-top: 20px;
                padding: 0 20px 20px;
                color: #aaa;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <header>
            <div class="brand">{{ config('app.name') }}</div>
            <div class="nav-links">
                <a href="{{ route('login') }}">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            </div>
        </header>

        <main class="container">
            <div class="card">
                {{ $slot }}
            </div>
        </main>

        <footer>
            <p style="letter-spacing: 0.08em; font-weight: 700; text-transform: uppercase;">e-commerce store</p>
        </footer>
    </body>
</html>
