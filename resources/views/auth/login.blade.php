<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{asset('auth/css/style.css')}}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>WYNREI</title>
</head>
<body>
    <div class="container">
       <div class="vertical-alignment">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 card auth-card ">
               <h4 class="mt-4 text-center">
                Please <span class="text-primary">Sign Ins</span>
               </h4>
               <form method="POST" action="{{ route('login') }}">
                    @csrf
                <div class="mt-5">
                    <div class=" input-group-md">
                        <input type="email" name="email"  class="form-control" placeholder="Enter User Name" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg"  value="{{ old('email') }}" autofocus>
                        @error('email')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>

                      <div class="input-group-md mt-3">
                        <input type="password" name="password" required class="form-control" placeholder="Enter your password" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                      </div>
                      <div class="input-group-md mt-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                        {{-- <input type="password" name="password" required class="form-control" placeholder="Enter your password" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg"> --}}
                      </div>
                      <div class="mt-5">
                        <button type="submit" class="btn btn-primary w-100">
                            SignIn
                        </button>
                      </div>
                      <div class="d-flex justify-content-between mt-2 mb-4">
                        @if (Route::has('password.request'))
                        <div class="text-primary auth-anker"><a href="{{ route('password.request') }}">
                            Forgot your Password?</a>
                        </div>
                        @endif

                      </div>
                      <div class="text-center text-muted">
                        ?? 2022 All Rights Reserved. WYNREI Portal -
                      </div>
                      <div class="text-primary text-center">
                        Privacy Policy | Terms & Conditions
                      </div>
                </div>
               </form>
            </div>
        </div>
       </div>
    </div>
</body>
</html>
