  <!-- Modal -->
  <form id="buyer-bid-from"  method="post" enctype="multipart/form-data">
    @csrf
  <div class="modal fade" id="buyerBidModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="staticBackdropLabel">Add Bid</h4>
        </div>
        <div class="modal-body">
          <div>
            <form action="">
                <div class="mt-4 mb-4">



                      <input type="text" name="buyer_property_id" id="buyer_property_id" value="">
                      <div class="input-group-md mt-3">
                        <label for=""> Bid Amount *</label>
                        <input type="number" name="bid_amount" id=""  class="form-control" placeholder="Enter Amount" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" >
                        <span id="buyer-bid-error-msg-add" class="text-danger pl-1"><span>

                      </div>

                      <!-- Default checkbox -->
                    <div class="form-check input-group-md mt-3">
                        <input class="form-check-input" name="agree" type="checkbox" value="1" id="flexCheckDefault" />
                        <label class="form-check-label" for="flexCheckDefault">I agree to the terms of service and terms of bidding on WynREI.com. This offer is not final and accepted until accepted by Seller. Once accepted, this offer becomes binding.</label>
                    </div>

                </div>
               </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
          <button type="button" id="buyer-bid-btn" class="btn btn-primary btn-md">Add </button>
        </div>
      </div>
    </div>
  </div>
  </form>


  <script>
   $(document).on('click', '.buyer-bid', function(){
        var id = $(this).data('id');
        $('#buyer_property_id').val(id);
   });


   ///////////////////////////////Submit
   $(document).on('click', '#buyer-bid-btn', function(e){
       e.preventDefault();
            alert('hi');
        $.ajaxSetup({
            headers: {
                "_token": "{{ csrf_token() }}",
            }
        });

       $.ajax({
            url: "{{ route('bid-buyer')}}",
            method: 'post',
            data: $('#buyer-bid-from').serialize(),
           success: (response) => {

            // $('#user-error-msg-add').html('');
            // $('#property-error-msg-add').html('');
            // $('#bid-error-msg-add').html('');
            // alert(response);
            if(response.success == true)
                {

                    swal({
                        title: "Bid Added",
                        text: response.data,
                        icon: "success",
                        button: "OK!",
                        timer: 1000,
                    });
                    $('#buyer-bid-from').trigger("reset");
                    $('#buyerBidModal').modal('hide');
                    $('#property-data-table').DataTable().ajax.reload();

                }else{
                    var error = response.data;

                    // alert(error);
                    if(error == 'The bid amount field is required.')
                    {

                        $('#buyer-bid-error-msg-add').html("The bid amount field is required.");
                    }
                }
           }
       });
    });
  </script>



