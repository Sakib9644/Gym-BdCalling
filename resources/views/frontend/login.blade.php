<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="{{ asset('app.css') }}">
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-3Qy7fV2HLY9X8c5iKc+3h2H3D1R+6T6h3XZxZZL8lfS21h4dy5G9r3N6w2wv7tlp" crossorigin="anonymous">
    
    <!-- JavaScript files -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                <div class="card-body">
                                    <x-auth-session-status class="mb-4" :status="session('status')" />

                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="form-group mb-3">
                                            <x-input-label for="email" :value="__('Email')" />
                                            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>

                                        <div class="form-group mb-4">
                                            <x-input-label for="password" :value="__('Password')" />
                                            <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                            </div>
                                            <button type="submit" class="btn btn-info w-100 mb-2">
                                              {{ __('Login as Admin') }}
                                          </button>

                                        <!-- Remember Me -->
                                        <div class="form-check mb-3">
                                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                            <label for="remember_me" class="form-check-label">{{ __('Remember me') }}</label>
                                        </div>

                                        <div class="d-flex justify-content-between mb-3">
                                            @if (Route::has('password.request'))
                                                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                                    {{ __('Forgot your password?') }}
                                                </a>
                                            @endif
                                        </div>
                                        <!-- Login Links -->
                                      </form>
                                      <div class="d-flex justify-content-between">
                                          <a href="/trainer" class="btn btn-success me-2">
                                              {{ __('Login as Trainer') }}
                                          </a>
                                          <a href="/trainee" class="btn btn-primary">
                                              {{ __('Login as Trainee') }}
                                          </a>
                                      </div>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="{{ route('register') }}">Need an account? Sign up!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
