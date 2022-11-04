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
                Please <span class="text-primary">Verify Your Email Address</span>
               </h4>


                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif






                <div class="mt-5">

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},


                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                    <br><br><br><br>




                      <div class="text-center text-muted">
                        © 2022 All Rights Reserved. WYNREI Portal -
                      </div>
                      <div class="text-primary text-center">
                        Privacy Policy | Terms & Conditions
                      </div>
                </div>
               
            </div>
        </div>
       </div>
    </div>
</body>
</html>
