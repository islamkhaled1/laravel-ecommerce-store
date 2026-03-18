<x-guest-layout title="Register">
    <h2 style="font-size: 24px; margin: 0 0 6px;">Create Account</h2>
    <p style="margin: 0 0 16px; color: #6b7280;">Register a new user account.</p>

    <form method="POST" action="{{ route('register') }}" style="display:grid;gap:14px;">
        @csrf

        <div>
            <label for="name" style="display:block;margin-bottom:4px;font-weight:bold;">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Your full name" style="width:100%;padding:9px;border:1px solid #ccc;border-radius:6px;">
            @error('name')<p style="color:#b91c1c;margin:6px 0 0;">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="email" style="display:block;margin-bottom:4px;font-weight:bold;">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="name@example.com" style="width:100%;padding:9px;border:1px solid #ccc;border-radius:6px;">
            @error('email')<p style="color:#b91c1c;margin:6px 0 0;">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password" style="display:block;margin-bottom:4px;font-weight:bold;">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Choose a password" style="width:100%;padding:9px;border:1px solid #ccc;border-radius:6px;">
            @error('password')<p style="color:#b91c1c;margin:6px 0 0;">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password_confirmation" style="display:block;margin-bottom:4px;font-weight:bold;">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat password" style="width:100%;padding:9px;border:1px solid #ccc;border-radius:6px;">
            @error('password_confirmation')<p style="color:#b91c1c;margin:6px 0 0;">{{ $message }}</p>@enderror
        </div>

        <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;">
            <a href="{{ route('login') }}" style="text-decoration:none;color:#2563eb;font-weight:bold;">
                Already registered?
            </a>

            <button type="submit" style="padding:10px 14px;border:none;background:#2563eb;color:#fff;border-radius:8px;cursor:pointer;font-weight:bold;">Register</button>
        </div>
    </form>
</x-guest-layout>
