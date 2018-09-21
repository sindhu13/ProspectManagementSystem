@extends('layouts.login')

@section('content')
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                @if ($errors->has('email'))
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>{{ $errors->first('email') }}</strong>
                    </div>
                @endif
                <section class="login_content">
                <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                    @csrf
                    <h1>Login Form</h1>
                    <div>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Username" required autofocus>
                    </div>
                    <div>
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div>
                        <!-- <a class="btn btn-default submit" href="index.html">Log in</a> -->
                        <button type="submit" class="btn btn-primary">
                            {{ __('Login') }}
                        </button>
                        <!-- <a class="reset_pass" href="#">Lost your password?</a> -->
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <div class="clearfix"></div>
                        <br />

                        <div>
                            <p>©2018 All Rights Reserved. Toyota Merkeda Motor.</p>
                        </div>
                    </div>
                </form>
                </section>
            </div>
        </div>
    </div>
@endsection
