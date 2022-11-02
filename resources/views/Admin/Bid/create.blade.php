  <!-- Modal -->
  <form id="add-bid-from"  method="post" enctype="multipart/form-data">
    @csrf
  <div class="modal fade" id="addBidModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="staticBackdropLabel">Add Bid</h4>
        </div>
        <div class="modal-body">
          <div>
            <form action="">
                <div class="mt-4 mb-4">
                    <div class="">
                        <label for="">Property Address *</label>
                        <select required name="property_address" class="form-select form-control" aria-label="Default select example">
                            <option selected disabled>Select property </option>
                            @foreach ($properties as $property)
                                <option value="{{ $property->property_addres }}">{{ $property->property_addres }}</option>
                            @endforeach
                          </select>
                          <span id="property-error-msg-add" class="text-danger pl-1"><span>
                      </div>

                      <div class="mt-1">
                        <b for="">User *</b>
                        <select required name="user_id" class="form-select form-control user_id" aria-label="Default select example">
                            <option selected disabled>Select property </option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                          </select>
                          <span id="user-error-msg-add" class="text-danger pl-1"><span>

                      </div>

                      <div class="input-group-md mt-3">
                        <label for=""> Bid Ammount *</label>
                        <input type="number" name="bid_amount" id=""  class="form-control" placeholder="Enter Phone" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" >
                        <span id="bid-error-msg-add" class="text-danger pl-1"><span>

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
          <button type="submit" class="btn btn-primary btn-md">Add Bid</button>
        </div>
      </div>
    </div>
  </div>
  </form>



  <script>


    /////submit

    $('#add-bid-from').submit(function(e) {
       e.preventDefault();
       var formData = new FormData(this);

       $.ajax({
          type:'POST',
          url: "{{ route('bid.store')}}",
           data: formData,
           contentType: false,
           processData: false,
           success: (response) => {


            if(response.success == true)
                {

                    swal({
                        title: "Updated",
                        text: response.data,
                        icon: "success",
                        button: "OK!",
                        timer: 1000,
                    });
                    $('#add-bid-from').trigger("reset");
                    $('#addBidModal').modal('hide');
                    $('#bid-data-table').DataTable().ajax.reload();

                }else{
                    var error = response.data;

                    alert(error);
                    if(error == 'The property address field is required.')
                    {

                        $('#property-error-msg-add').html(error);
                    }

                    if(error == 'The user id field is required.')
                    {

                        $('#user-error-msg-add').html("The user  field is required");
                    }

                    if(error == 'The bid amount field is required.')
                    {

                        $('#bid-error-msg-add').html("The bid amount field is required.");
                    }
                }
           }
       });
    });
  </script>
