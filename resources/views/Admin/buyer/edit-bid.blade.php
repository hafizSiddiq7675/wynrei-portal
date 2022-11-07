  <!-- Modal -->
  <form id="edit-buyer-bid-from"  method="post" enctype="multipart/form-data">
    @csrf
  <div class="modal fade" id="buyerEditBidModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="staticBackdropLabel">Update Bid</h4>
        </div>
        <div class="modal-body">
          <div id="edit-buyer-bid-box">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
          <button type="button" id="buyer-bid-btn-update" class="btn btn-primary btn-md">Update </button>
        </div>
      </div>
    </div>
  </div>
  </form>

  <script>
    $(document).on('click', '.buyer-bid-edit', function(){
        var id = $(this).data('id');

        var url = "{{ route('edit-bid-buyer',':id') }}";
        url = url.replace(':id', id);

        var token = "{{ csrf_token() }}";

        $.ajax({
            type: 'POST',
                url: url,
                data: {'_token': token, '_method': 'GET'},
                success: function (response) {

                    $('#edit-buyer-bid-box').html(response);
                    $('#buyerEditBidModal').modal('show');


                }
        });
    })




       ///////////////////////////////Submit
   $(document).on('click', '#buyer-bid-btn-update', function(e){
       e.preventDefault();

        $.ajaxSetup({
            headers: {
                "_token": "{{ csrf_token() }}",
            }
        });

       $.ajax({
            url: "{{ route('bid-buyer')}}",
            method: 'post',
            data: $('#edit-buyer-bid-from').serialize(),
           success: (response) => {

            $('#buyer-bid-error-msg-update').html('');
        
            if(response.success == true)
                {

                    swal({
                        title: "Bid Updated",
                        text: response.data,
                        icon: "success",
                        button: "OK!",
                        timer: 1000,
                    });
                    $('#edit-buyer-bid-from').trigger("reset");
                    $('#buyerEditBidModal').modal('hide');
                    $('#property-data-table').DataTable().ajax.reload();

                }else{
                    var error = response.data;

                    if(error == 'The bid amount field is required.')
                    {

                        $('#buyer-bid-error-msg-update').html("The bid amount field is required.");
                    }
                }
           }
       });
    });
  </script>
