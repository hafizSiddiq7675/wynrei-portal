<!-- Modal -->
<form id="add-user-form">
        @csrf
    <div class="modal fade" id="addusermodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="staticBackdropLabel">Add user</h4>
            </div>
            <div class="modal-body">
                <div>

                    <div class="mt-4 mb-4">
                        <div class=" input-group-md">
                            <b>Name : </b>
                            <input type="text" name ="name" class="form-control" placeholder="Enter Name" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" value="">
                            <span id="name-error-msg-add" class="text-danger pl-1"><span>
                        </div>
                        <div class=" input-group-md mt-3">
                            <b>Email : </b>
                            <input type="email"  name ="email"   class="form-control" placeholder="Enter Email" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg"  value="">
                            <span id="email-error-msg-add" class="text-danger pl-1"><span>
                        </div>

                        <div class=" input-group-md mt-3">
                            <b>Password : </b>
                            <input type="password"  name ="password"   class="form-control" placeholder="Enter Password" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg"  value="">
                            <span id="password-error-msg-add" class="text-danger pl-1"><span>
                        </div>

                        <div class=" input-group-md mt-3">
                            <b>Confirm Password : </b>
                            <input type="password"  name ="password_confirmation"   class="form-control" placeholder="Confirm Password" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg"  value="">

                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
              <button type="button"  id="user-add-btn" class="btn btn-primary btn-md">Add</button>
            </div>
          </div>
        </div>
    </div>
</form>


<script>

    $(document).on( 'click' ,'#user-add-btn', function (e) {
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        "_token": "{{ csrf_token() }}",
                    }
                });


                $.ajax({
                    url: "{{ route('users.store')}}",
                    method: 'post',
                    data: $('#add-user-form').serialize(),

                    success: function(response)
                    {
                        $('#name-error-msg-add').html('');
                        $('#email-error-msg-add').html('');
                        $('#password-error-msg-add').html('');

                        if(response.success == true)
                        {


                            swal({
                                title: "Success",
                                text: response.data,
                                icon: "success",
                                button: "OK!",
                                timer: 1000,
                            });
                            $('#addusermodal').modal('hide');
                            $('#user-data-table').DataTable().ajax.reload();
                        }else{




                            var error = response.data;

                            if(error == 'The name field is required.')
                            {
                                $('#name-error-msg-add').html(error);
                            }

                            if(error == 'The email field is required.')
                            {
                                $('#email-error-msg-add').html(error);
                            }

                            if(error == 'The email has already been taken.')
                            {
                                $('#email-error-msg-add').html(error);
                            }


                            if(error == 'The password field is required.')
                            {
                                $('#password-error-msg-add').html(error);
                            }

                            if(error == 'The password confirmation does not match.')
                            {
                                $('#password-error-msg-add').html(error);
                            }


                        }

                    }

                });

            });

    </script>

