<x-admin.layouts.app :title="'Change Password'">
    <div class="admin-shell">
        @include('admin.partials.sidebar')

        <main class="main">
            <div class="topbar">
                <div>
                    <h1 class="page-title">Change Password</h1>
                    <p class="page-subtitle">Update your admin login password.</p>
                </div>
            </div>

            <section class="panel">
                <div class="panel-body" style="max-width: 720px;">
                    @if (session('status'))
                        <div class="notice" style="margin-top:0; margin-bottom:18px;">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.password.update') }}">
                        @csrf

                        <div class="field">
                            <label for="current_password">Current Password</label>
                            <input id="current_password" type="password" name="current_password" required>
                            @error('current_password')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="password">New Password</label>
                            <input id="password" type="password" name="password" required>
                            @error('password')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required>
                        </div>

                        <button type="submit" class="primary-btn" style="max-width:260px; margin-top: 18px;">Update Password</button>
                    </form>
                </div>
            </section>
        </main>
    </div>
</x-admin.layouts.app>
