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
            <div class="col-md-4 card auth-card ">
               <h4 class="mt-4 text-center"> 
                Please <span class="text-primary">Sign Up</span>
               </h4>
               <form action="">
                <div class="mt-5">
                    <div class=" input-group-md">
                        <input type="text" required class="form-control" placeholder="Enter First Name" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                      </div>
                      <div class=" input-group-md mt-3">
                        <input type="text" required class="form-control" placeholder="Enter Last Name" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                      </div>
                    <div class=" input-group-md mt-3">
                        <input type="text" required class="form-control" placeholder="Enter Your Password" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                      </div>
                      <div class="input-group-md mt-3">
                        <input type="text" required class="form-control" placeholder="Confirm Your Password" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                      </div>
                      <div class="mt-5">
                        <button class="btn btn-primary w-100">
                            SignUp
                        </button>
                      </div>
                      <div class="d-flex justify-content-between mt-2 mb-4">
                        <div class="text-primary auth-anker"><a href="#">
                            Forgot your Password?</a></div>
                        <div class="text-priamry auth-anker"><a href="/login">
                            Login</a></div>
                      </div>
                </div>
               </form>
            </div>
        </div>
       </div>
    </div>
</body>
</html>