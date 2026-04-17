@extends('backend.layout.master')
@section('content')

<div id="auth-view">
    <div class="auth-card">
        <div class="auth-logo">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRLMBJ7llJpN8xVe93gwvNziaTpbb9A9m0B8Q&s" alt="State Life Logo">
        </div>

        <div id="auth-alert" class="hidden mb-4" style="color: var(--danger); text-align: center; font-size: 0.875rem;"></div>

        <form method="post" action="{{route('admin.login.user')}}">
            @csrf
            <h3 class="mb-4 text-center font-bold text-dark">Portal Access</h3>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="text" id="login-email" name="email" class="form-control" placeholder="Enter Email" required>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="login-password" class="form-control" placeholder="••••••••" required>
            </div>
            <input type="submit" value="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">

            {{--<div class="auth-toggle">
                    New agent? <a href="#" id="go-to-signup">Create account</a>
                </div>
                 --}}
        </form>

        <form id="signup-form" class="hidden">
            <h3 class="mb-4 text-center font-bold text-dark">Register Agent</h3>
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" id="signup-name" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" id="signup-email" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" id="signup-password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-secondary" style="width: 100%;">Create Account</button>
            <div class="auth-toggle">
                Already registered? <a href="#" id="go-to-login">Sign in</a>
            </div>
        </form>
    </div>
</div>
@endsection