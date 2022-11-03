  <form id="update-user-form">
    @csrf
    <div class="modal fade" id="editusermodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <span id="edit-user">

        </span>
    </div>

  </form>


  <script>
    $(document).on('click', '.edit-user', function(){
        var id = $(this).data('id');



        var url = "{{ route('users.edit',':id') }}";
        url = url.replace(':id', id);

        var token = "{{ csrf_token() }}";

        $.ajax({
            type: 'POST',
                url: url,
                data: {'_token': token, '_method': 'GET'},
                success: function (response) {
                      
                    $('#edit-user').html(response);
                    $('#editusermodal').modal('show');


                }
        });
    })



    $(document).on( 'click' ,'#user-update-btn', function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                "_token": "{{ csrf_token() }}",
            }
        });


        $.ajax({
            url: "{{ route('users.store')}}",
            method: 'post',
            data: $('#update-user-form').serialize(),

            success: function(response)
            {
                $('#name-error-msg').html('');
                $('#email-error-msg').html('');
                $('#type-error-msg-update').html('');
                // console.log(response);

                if(response.success == true)
                {

                    swal({
                        title: "Updated",
                        text: response.data,
                        icon: "success",
                        button: "OK!",
                        timer: 1000,
                    });
                    $('#editusermodal').modal('hide');
                    $('#user-data-table').DataTable().ajax.reload();
                }else{

                    var error = response.data;


                    if(error == 'The name field is required.')
                    {
                        $('#name-error-msg').html(error);
                    }

                    if(error == 'The email field is required.')
                    {
                        $('#email-error-msg').html(error);
                    }

                    if(error == 'The email has already been taken.')
                    {
                        $('#email-error-msg').html(error);
                    }

                    if(error == 'The role id field is required.')
                    {
                        $('#role-error-msg-update').html('The user role  field is required.');
                    }




                }

            }

        });

    });

</script>
