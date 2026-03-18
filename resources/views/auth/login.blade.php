<x-guest-layout title="Login">
    <h2 style="font-size: 24px; margin: 0 0 6px;">Login</h2>
    <p style="margin: 0 0 16px; color: #6b7280;">Sign in to continue shopping.</p>

    @if (session('status'))
        <div class="alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" style="display: grid; gap: 14px;">
        @csrf

        <div>
            <label for="email" style="display:block;margin-bottom:4px;font-weight:bold;">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@example.com" style="width:100%;padding:9px;border:1px solid #ccc;border-radius:6px;">
            @error('email')<p style="color:#b91c1c;margin:6px 0 0;">{{ $message }}</p>@enderror
        </div>

        <div>
            <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:4px;">
                <label for="password" style="font-weight:bold;">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size:12px;color:#2563eb;text-decoration:none;font-weight:bold;">
                        Forgot password?
                    </a>
                @endif
            </div>

            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" style="width:100%;padding:9px;border:1px solid #ccc;border-radius:6px;">
            @error('password')<p style="color:#b91c1c;margin:6px 0 0;">{{ $message }}</p>@enderror
        </div>

        <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;">
            <label for="remember_me" style="display:flex;align-items:center;gap:8px;color:#374151;">
                <input id="remember_me" type="checkbox" name="remember">
                <span>Remember me</span>
            </label>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" style="text-decoration:none;color:#2563eb;font-weight:bold;">
                    Create account
                </a>
            @endif
        </div>

        <div>
            <button type="submit" style="width:100%;padding:10px 14px;border:none;background:#2563eb;color:#fff;border-radius:8px;cursor:pointer;font-weight:bold;">Log in</button>
        </div>
    </form>
</x-guest-layout>
