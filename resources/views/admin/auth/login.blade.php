<x-admin.layouts.app :title="'Admin Login'">
    <div class="login-shell">
        <div class="login-card">
            <h1>Admin Login</h1>
            <p>Sign in to manage the website content and access the admin dashboard.</p>

            <form method="POST" action="{{ route('admin.login.store') }}">
                @csrf

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')<small>{{ $message }}</small>@enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                    @error('password')<small>{{ $message }}</small>@enderror
                </div>

                <label class="checkbox-row" for="remember">
                    <input id="remember" type="checkbox" name="remember">
                    <span>Keep me signed in</span>
                </label>    
                <br>
                <button type="submit" class="primary-btn" style="width: 100%">Login</button>
            </form>

            <!--<div class="notice">-->
            <!--    Default admin: <strong>admin@madsautorepair.com</strong><br>-->
            <!--    Default password: <strong>admin12345</strong>-->
            <!--</div>-->
        </div>
    </div>
</x-admin.layouts.app>
