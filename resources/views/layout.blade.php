<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
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
            flex-wrap: wrap;
            gap: 10px;
        }
        .brand {
            font-weight: bold;
            font-size: 20px;
        }
        .nav-links {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }
        .nav-links a,
        .nav-links button {
            text-decoration: none;
            border: 0;
            background: #3d556d;
            color: #fff;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
        }
        .nav-links a:hover,
        .nav-links button:hover {
            background: #4c6a86;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px 20px;
        }
        footer {
            margin-top: 20px;
            padding: 0 20px 20px;
            color: #aaa;
            text-align: center;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 16px;
            background: #fff;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.06);
        }
        .grid {
            display: grid;
            gap: 16px;
        }
        .grid-2 {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }
        .grid-5 {
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            border-bottom: 1px solid #eee;
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }
        th {
            background: #f8fafc;
            color: #374151;
        }
        .status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }
        .status.pending { background: #fef3c7; color: #92400e; }
        .status.approved { background: #d1fae5; color: #065f46; }
        .status.rejected { background: #fee2e2; color: #991b1b; }
        .btn {
            border: 0;
            border-radius: 6px;
            padding: 6px 10px;
            color: #fff;
            cursor: pointer;
            font-size: 12px;
            font-weight: bold;
        }
        .btn-approve { background: #059669; }
        .btn-reject { background: #dc2626; }
        .btn-pending { background: #d97706; }
        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        @media (max-width: 700px) {
            .container {
                padding: 16px;
            }
        }
    </style>
</head>
<body>
    @php
        $cartCount = array_sum(array_column(session('cart', []), 'quantity'));
    @endphp

    <header>
        <div class="brand">{{ config('app.name') }}</div>

        @auth
            <div class="nav-links">
                @if(auth()->user()->is_admin)
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                @endif
                <a href="{{ route('products.index') }}">Products</a>
                @if(auth()->user()->is_admin)
                    <a href="{{ route('orders.index') }}">Orders</a>
                    <span style="background:#f59e0b;color:#111;padding:6px 10px;border-radius:6px;font-size:12px;font-weight:bold;">ADMIN</span>
                @else
                    <a href="{{ route('cart.index') }}">Cart ({{ $cartCount }})</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit">Log Out</button>
                </form>
            </div>
        @endauth
    </header>

    <main class="container">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    <footer>
        <p style="letter-spacing: 0.08em; font-weight: 700; text-transform: uppercase;">e-commerce store</p>
    </footer>
</body>
</html>
