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

                @if($errors->has('invalid'))

                    <div class="alert alert-danger">
                        <strong>Sorry!</strong> <span> {{ $errors->first('invalid') }} </span>.
                      </div>
                @endif

               <h4 class="mt-4 text-center">
                Reset <span class="text-primary">Password</span>
               </h4>
                <form action="{{ route('store.password') }}" method="POST">
                    @csrf
                <div class="mt-5">
                    <input type="hidden" name="token" readonly class="form-control" placeholder="Enter Your Password" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" value="{{ $token }}">

                    <div class=" input-group-md mb-3">
                        <input type="email" name="email" readonly class="form-control" placeholder="Enter Your Password" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" value="{{ $email }}">
                      </div>
                        <div class=" input-group-md">
                        <input type="password" name="password" required class="form-control" placeholder="Enter Your Password" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                      </div>
                      <div class=" input-group-md mt-3">
                        <input type="password" name="password_confirmation" required class="form-control" placeholder="Confirm Your Password" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                      </div>
                      <div class="mt-4">
                        <button class="btn btn-primary w-100">
                            Submit
                        </button>
                      </div>
                      <div class="d-flex justify-content-center mt-2 mb-4">
                        <div class="text-primary auth-anker"><a href="{{ route('login') }}">
                            Login</a></div>

                      </div>
                      <div class="text-center text-muted">
                        © 2022 All Rights Reserved. WYNREI Portal -
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
