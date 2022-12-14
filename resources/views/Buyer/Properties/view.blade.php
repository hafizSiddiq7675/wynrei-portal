@include('dashboard')
@include('Admin.Bid.create')

<form id="add-property-from"  method="post" enctype="multipart/form-data">
    @csrf

  <div class="modal fade" id="addPropertyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="staticBackdropLabel">Add Property</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div>
            <form action="">
                <div class=" mb-4">

                    <div class="row">

                        <div class="col-6">
                            <div class=" input-group-md">
                                <label for="">Property Address *</label>
                                <input type="text" name="property_addres" required class="form-control" placeholder="Enter Property Address" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class=" input-group-md ">
                                <label for="">Address line 2</label>
                                <input type="text" name="address_line_2"  class="form-control" placeholder="Enter Address line 2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group-md mt-3">
                                <label for="">City *</label>
                                <input type="text" name="city" required class="form-control" placeholder="Enter City" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                            </div>
                        </div>


                        <div class="col-6">
                            <div class="input-group-md mt-3">
                                <label for="">State *</label>
                                <input type="text" name="state" required class="form-control" placeholder="Enter State" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group-md mt-3">
                                <label for="">Zip Code *</label>
                                <input type="text" name="zip_code" required class="form-control" placeholder="Enter Zip Code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group-md mt-3">
                                <label for="">Closing Date *</label>
                                <input type="date" name="closing_date" required class="form-control" placeholder="Enter Zip Code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="input-group-md mt-3" >
                                <label for="">Property Description *</label><br>
                                <div>
                                <textarea style="width: 100%" required name="property_description"  rows="4" cols="80" maxlength="200"></textarea>
                                </div>
                            </div>
                        </div>

                        <br>


                    </div>

                    <div class="row">
                        <div class="col-12" id="photoes-box" >
                            <span><b>Photoes</b></span>
                            <div class="d-flex justify-content-end">
                                <button id="add-photo-btn" class="btn btn-success">+</button>
                            </div>

                            <span id="add-more-photoes">
                                <div class="custom-file mt-2">
                                    <input required name="photo[]" type="file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose Photo</label>
                                </div>
                            </span>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12" id="document-box" >
                            <span><b>Documnet</b></span>
                            <div class="d-flex justify-content-end">
                                <button id="add-document-btn" class="btn btn-success">+</button>
                            </div>

                            <span id="add-more-document">
                                <div class="custom-file mt-2">
                                    <input name="document[]" type="file" class="custom-file-input" id="customFile" required>
                                    <label class="custom-file-label" for="customFile">Choose Document</label>
                                </div>
                            </span>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-6">
                            <div class="input-group-md mt-3">
                                <label for="">Asking Price *</label>
                                <input type="text" name="asking_price" required class="form-control" placeholder="Enter Asking Price" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group-md mt-3">
                                <label for="">ARV *</label>
                                <input type="text" name="arv" required class="form-control" placeholder="Enter ARV " aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group-md mt-3">
                                <label for="">Rehab Estimate *</label>
                                <input type="text" name="rehab_estimate" required class="form-control" placeholder="Enter Rehab Estimate" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group-md mt-3">
                                <label for="">Rental Comps *</label>
                                <input type="text" name="rental_comps" required class="form-control" placeholder="Enter Rental Comps" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group-md mt-3">
                                <label for="">Bedrooms *</label>
                                <input type="number" name="bedrooms" required class="form-control" placeholder="Enter Bedrooms" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group-md mt-3">
                                <label for="">Bathrooms *</label>
                                <input type="number" name="bathrooms" required class="form-control" placeholder="Enter Bathrooms" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group-md mt-3">
                                <label for="">Square Footage *</label>
                                <input type="text" name="square_footage" required class="form-control" placeholder="Enter Square Footage" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group-md mt-3">
                                <label for="">Year Built *</label>
                                <input type="number" name="year_built" required class="form-control" placeholder="Enter Year Built" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group-md mt-3">
                                <label for="">Property Type *</label>
                                <select required name="property_type" class="form-select form-control">
                                    <option selected disabled>Select Property</option>
                                    <option value="Single-family">Single-family</option>
                                    <option value="Multi-family">Multi-family</option>
                                    <option value="Commercial">Commercial</option>
                                    <option value="Industrial">Industrial</option>
                                </select>
                                <span id="property-error-msg-add" class="text-danger pl-1"><span>

                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group-md mt-3">
                                <label for="">Market *</label>
                                <select required name="market_id" class="form-control form-select">
                                    <option selected disabled>Select Market</option>
                                    @foreach ($markets as $market)
                                    <option value="{{ $market->id }}">{{ $market->name }}</option>
                                    @endforeach


                                </select>
                                <span id="market-error-msg-add" class="text-danger pl-1"><span>

                            </div>
                        </div>



                    </div>


                </div>
               </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-md">Add</button>
        </div>
      </div>
    </div>
  </div>
</form>

  <script>
    var i = 0;
    $(document).on('click', '#add-photo-btn', function(){
        i = i + 1 ;
       var html =
       `
       <div class="row" id="more-photo-${i}">
        <div class="col-md-10">

            <div class="custom-file mt-3">
                <input type="file" name="photo[]" class="custom-file-input" id="customFile" required>
                <label class="custom-file-label" for="customFile">Choose Photo</label>
            </div>


        </div>
        <div class="col-md-2 d-flex justify-content-end mt-3">
            <span data-id="${i}" class="btn btn-danger  remove-photo" >Remove<span>
        </div>
        </div>



       `;

       $('#add-more-photoes').append(html);
    });

    $(document).on('click', '.remove-photo', function(){
        var id = $(this).data('id');

        $('#more-photo-'+id).remove();

    });



    ///// document
    var i = 0;
    $(document).on('click', '#add-document-btn', function(){
        i = i + 1 ;
       var html =
       `
       <div class="row" id="more-document-${i}">
        <div class="col-md-10">


            <div class="custom-file mt-3">
                <input type="file" name="document[]" class="custom-file-input" id="customFile" required>
                <label class="custom-file-label" for="customFile">Choose Document</label>
            </div>

        </div>
        <div class="col-md-2 d-flex justify-content-end mt-3">
            <span data-id="${i}" class="btn btn-danger  remove-document" >Remove<span>
        </div>
        </div>


       `;

       $('#add-more-document').append(html);
    });

    $(document).on('click', '.remove-document', function(){
        var id = $(this).data('id');
        $('#more-document-'+id).remove();
    });




    //////Form Submit


    $('#add-property-from').submit(function(e) {
       e.preventDefault();


       var formData = new FormData(this);

       $.ajax({
          type:'POST',
          url: "{{ route('property.store')}}",
           data: formData,
           contentType: false,
           processData: false,
           success: (response) => {

            $('#property-error-msg-add').html('');
            $('#market-error-msg-add').html('');

            if(response.success == true)
                {
                    swal({
                        title: "Updated",
                        text: response.data,
                        icon: "success",
                        button: "OK!",
                        timer: 1000,
                    });
                    $('#add-property-from').trigger("reset");
                    $('#addPropertyModal').modal('hide');
                    $('#property-data-table').DataTable().ajax.reload();

                }else{
                    var error = response.data;

                    if(error == 'The market id field is required.')
                    {
                        $('#market-error-msg-add').html(error);
                    }

                    if(error == 'The property type field is required.')
                    {
                        $('#property-error-msg-add').html(error);
                    }
                }
           }
       });
    });
  </script>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

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
          <button type="submit" class="btn btn-primary btn-md">Add </button>
        </div>
      </div>
    </div>
  </div>
  </form>












