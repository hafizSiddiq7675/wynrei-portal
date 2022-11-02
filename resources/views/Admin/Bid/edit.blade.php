  <!-- Modal -->
  <form id="update-bid-from"  method="post" enctype="multipart/form-data">
    @csrf
  <div class="modal fade" id="updateBidModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <span id="update-bid-section"></span>
  </div>
  </form>

  <script>
    $(document).on('click', '.edit-bid', function(){
        var id = $(this).data('id');



        var url = "{{ route('bid.edit',':id') }}";
        url = url.replace(':id', id);

        var token = "{{ csrf_token() }}";

        $.ajax({
            type: 'POST',
                url: url,
                data: {'_token': token, '_method': 'GET'},
                success: function (response) {

                    $('#update-bid-section').html(response);
                    $('#updateBidModal').modal('show');


                }
        });
    })





    /////submit

    $('#update-bid-from').submit(function(e) {
       e.preventDefault();
       var formData = new FormData(this);

       $.ajax({
          type:'POST',
          url: "{{ route('bid.store')}}",
           data: formData,
           contentType: false,
           processData: false,
           success: (response) => {

            $('#user-error-msg-update').html('');
            $('#property-error-msg-update').html('');
            $('#bid-error-msg-update').html('');


            if(response.success == true)
                {

                    swal({
                        title: "Updated",
                        text: response.data,
                        icon: "success",
                        button: "OK!",
                        timer: 1000,
                    });

                    $('#updateBidModal').modal('hide');
                    $('#bid-data-table').DataTable().ajax.reload();

                }else{
                    var error = response.data;


                    if(error == 'The property address field is required.')
                    {

                        $('#property-error-msg-update').html(error);
                    }

                    if(error == 'The user id field is required.')
                    {

                        $('#user-error-msg-update').html("The user  field is required");
                    }

                    if(error == 'The bid amount field is required.')
                    {

                        $('#bid-error-msg-update').html("The bid amount field is required.");
                    }
                }
           }
       });
    });
  </script>
