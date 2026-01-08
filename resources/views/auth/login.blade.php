@extends('layouts.auth')
@section('content')
    <!-- Logo -->
    <div class="app-brand justify-content-center">
        <a href="#" class="app-brand-link gap-2">
            <span class="app-brand-text text-body fw-bolder">Sistem Persedian</span>
        </a>
    </div>

    @if(session('success'))
    <div id="flash-success"
        class="alert alert-success position-fixed top-0 start-50 translate-middle-x mt-3 px-4 py-2 shadow"
        role="alert"
        style="min-width:260px; z-index:1050; border-radius:8px; opacity:1; transition:opacity .6s;">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(function() {
            const alertBox = document.getElementById('flash-success');
            if (alertBox) {
                alertBox.style.opacity = "0";
                setTimeout(() => alertBox.remove(), 600);
            }
        }, 2500);
    </script>
    @endif

    @if(session('error'))
    <div id="flash-error"
        class="alert alert-danger position-fixed top-0 start-50 translate-middle-x mt-3 px-4 py-2 shadow"
        role="alert"
        style="min-width:260px; z-index:1050; border-radius:8px; opacity:1; transition:opacity .6s;">
        {{ session('error') }}
    </div>

    <script>
        setTimeout(function() {
            const alertBox = document.getElementById('flash-error');
            if (alertBox) {
                alertBox.style.opacity = "0";
                setTimeout(() => alertBox.remove(), 600);
            }
        }, 2500);
    </script>
    @endif

    <!-- /Logo -->
    <h4 class="mb-2 text-center">Silahkan Login Untuk Melanjutkan👋</h4>

    <form id="formAuthentication" class="mb-3" action="{{ route('loginAction') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Username</label>
            <input type="text" class="form-control" id="email" name="login" autofocus autocomplete="off" />
        </div>
        <div class="mb-3 form-password-toggle">
            <label for="password" class="form-label">Password</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
        </div>
        <div class="mb-3">
            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
        </div>
    </form>

    <p class="text-center">
        <span>New on our platform?</span>
        <a href="{{ route('register') }}">
            <span>Create an account</span>
        </a>
    </p>
@endsection
