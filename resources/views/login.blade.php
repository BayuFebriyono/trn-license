<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <style>
        .login {
            min-height: 100vh;
        }

        .bg-image {
            background-image: url('{{ asset('img/gallery/pc.jpg') }}');
            background-size: cover;
            background-position: center;
        }

        .login-heading {
            font-weight: 300;
        }

        .btn-login {
            font-size: 0.9rem;
            letter-spacing: 0.05rem;
            padding: 0.75rem 1rem;
        }

    </style>
</head>

<body>

    <div class="container-fluid ps-md-0">
        <div class="row g-0">
            <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
            <div class="col-md-8 col-lg-6">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-9 col-lg-8 mx-auto">
                                <h3 class="login-heading mb-4">Welcome back!</h3>
                                @if (session('error'))
                                <div class="alert alert-warning" role="alert">
                                    Username Atau Password <b>Salah!</b>
                                   </div>
                                @endif
                                <!-- Sign In Form -->
                                <form method="POST" action="{{ url('/login') }}">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="text" name="username" class="form-control" id="floatingInput"
                                            placeholder="Username" required>
                                        <label for="floatingInput">Username</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" name="password" class="form-control" id="floatingPassword"
                                            placeholder="Password" required>
                                        <label for="floatingPassword">Password</label>
                                    </div>


                                    <div class="d-grid">
                                        <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2"
                                            type="submit">Sign in</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
