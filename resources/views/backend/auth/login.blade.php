@extends('layouts/blankLayout')

@section('title', 'Login')

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="{{ url('admin/') }}" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    {!! Helper::getLogoImg(120) !!}
                                </span>
                                {{-- <span
                                    class="app-brand-text demo text-body fw-bolder">{{ config('variables.templateName') }}</span> --}}
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Welcome to {{ env('APP_NAME', config('variables.templateName')) }}! 👋</h4>
                        <p class="mb-4">Please sign-in to your account</p>
                        {!! Helper::getDismissableErrorAlert($errors) !!}
                        {!! Helper::getDismissableAlert() !!}

                        <form id="formAuthentication" class="mb-3" action="{{ route('login.perform') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email or Username</label>
                                <input type="text" class="form-control email" id="email" name="email"
                                    placeholder="Enter your email or username" value="{{ old('email') }}" autofocus>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    <a href="{{ route('password.request') }}">
                                        <small>Forgot Password?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember" value="{{ true }}">
                                    <label class="form-check-label" for="remember-me">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>

                        {{-- <p class="text-center">
                            <span>New on our platform?</span>
                            <a href="{{ url('admin/auth/register-basic') }}">
                                <span>Create an account</span>
                            </a>
                        </p> --}}
                    </div>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
    </div>
    <script>
        $("#formAuthentication").validate({
            rules: {
                email: {
                    required: true 
                },
            },
            submitHandler: function(form) {
                // Form submission logic goes here if needed
                form.submit();
            }
        });
    </script>
@endsection
