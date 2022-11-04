
@include('dashboard')
@section('content')
<div class = "card p-3 table-card">
<div class="d-flex justify-content-end mb-3">
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBidModal"> + Add Bid</button>
</div>
<form id="add-property-from"  method="post" enctype="multipart/form-data">
  @csrf
 
 @foreach($properties as $propert)
    <div class=" mb-4">

        <div class="row">

            <div class="col-6">
                <div class=" input-group-md">
                    <label for="">Property Address *</label>
                    <input type="text" name="property_addres" readonly class="form-control"  value = "{{$propert->property_addres}} " aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                </div>
            </div>

            <div class="col-6">
                <div class=" input-group-md ">
                    <label for="">Address line 2</label>
                    <input type="text" name="address_line_2" readonly value="{{$propert->address_line_2}}" class="form-control"  aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                </div>
            </div>

            <div class="col-6">
                <div class="input-group-md mt-3">
                    <label for="">City *</label>
                    <input type="text" name="city" readonly value="{{$propert->city}}"  class="form-control" placeholder="Enter City" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                </div>
            </div>


            <div class="col-6">
                <div class="input-group-md mt-3">
                    <label for="">State *</label>
                    <input type="text" name="state" readonly value="{{$propert->state}}"  class="form-control" placeholder="Enter State" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                </div>
            </div>

            <div class="col-6">
                <div class="input-group-md mt-3">
                    <label for="">Zip Code *</label>
                    <input type="text" name="zip_code" readonly value="{{$propert->zip_code}}" class="form-control" placeholder="Enter Zip Code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                </div>
            </div>

            <div class="col-6">
                <div class="input-group-md mt-3">
                    <label for="">Closing Date *</label>
                    <input type="date" name="closing_date" readonly value="{{$propert->closing_date}}" class="form-control" placeholder="Enter Zip Code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                </div>
            </div>

            <div class="col-12">
                <div class="input-group-md mt-3" >
                    <label for="">Property Description *</label><br>
                    <div>
                    <textarea style="width: 100%"  readonly value="{{$propert->property_description}}" name="property_description"  rows="4" cols="80" maxlength="200"></textarea>
                    </div>
                </div>
            </div>

            <br>


        </div>
        
        <div class="row">
        <div class="row mt-1">
            <label for=""> Photoes</label>
            <div class="col-12">

            @foreach($photoes as $data)
            
                <img src="{{ asset(''.$data->photo.'') }}" alt="" height="100" width="100" class="mr-2">
            @endforeach

            </div>
            </div>

        </div>


        <div class="row">
            <div class="row mt-1">
            <label for="">Old Documnet</label>
                <div class="col-12">

                @foreach($documents as $data)
                    <img src="{{ asset(''.$data->document.'') }} " alt="" height="100" width="100" class="mr-2">
                @endforeach

                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-6">
                <div class="input-group-md mt-3">
                    <label for="">Asking Price *</label>
                    <input type="text" name="asking_price" readonly value="{{$propert->asking_price}}" class="form-control" placeholder="Enter Asking Price" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                </div>
            </div>

            <div class="col-6">
                <div class="input-group-md mt-3">
                    <label for="">ARV *</label>
                    <input type="text" name="arv"  readonly value="{{$propert->arv}}" class="form-control" placeholder="Enter ARV " aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                </div>
            </div>

            <div class="col-6">
                <div class="input-group-md mt-3">
                    <label for="">Rehab Estimate *</label>
                    <input type="text" name="rehab_estimate" readonly value="{{$propert->rehab_estimate}}"  class="form-control" placeholder="Enter Rehab Estimate" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                </div>
            </div>

            <div class="col-6">
                <div class="input-group-md mt-3">
                    <label for="">Rental Comps *</label>
                    <input type="text" name="rental_comps" readonly value="{{$propert->rental_comps}}"  class="form-control" placeholder="Enter Rental Comps" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                </div>
            </div>

            <div class="col-6">
                <div class="input-group-md mt-3">
                    <label for="">Bedrooms *</label>
                    <input type="number" name="bedrooms" readonly value="{{$propert->bedrooms}}" class="form-control" placeholder="Enter Bedrooms" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                </div>
            </div>

            <div class="col-6">
                <div class="input-group-md mt-3">
                    <label for="">Bathrooms *</label>
                    <input type="number" name="bathrooms"  readonly value="{{$propert->bathrooms}}"class="form-control" placeholder="Enter Bathrooms" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                </div>
            </div>

            <div class="col-6">
                <div class="input-group-md mt-3">
                    <label for="">Square Footage *</label>
                    <input type="text" name="square_footage" readonly value="{{$propert->square_footage}}" class="form-control" placeholder="Enter Square Footage" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                </div>
            </div>

            <div class="col-6">
                <div class="input-group-md mt-3">
                    <label for="">Year Built *</label>
                    <input type="number" name="year_built" readonly value="{{$propert->year_built}}" class="form-control" placeholder="Enter Year Built" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                </div>
            </div>

            <div class="col-6">
                <div class="input-group-md mt-3">
                    <label for="">Property Type *</label>
                    <select required name="property_type" class="form-select form-control">
                        @if($options_family =='Single-family')
                        <option value="Single-family" selected>Single-family</option>
                        @elseif($options_family =='Multi-family')
                        <option value="Multi-family">Multi-family</option>
                        @elseif($options_family =='Commercial')
                        <option value="Commercial">Commercial</option>
                        @elseif($options_family =='Industrial')
                        <option value="Industrial">Industrial</option>
                        @endif
                    </select>
                    <span id="property-error-msg-add" class="text-danger pl-1"><span>

                </div>
            </div>

            <div class="col-6">
                <div class="input-group-md mt-3">
                    <label for="">Market *</label>
                    <select required name="market_id" class="form-control form-select">
                        <option  disabled>Select Market</option>
                        @foreach ($markets as $market)
                        <?php 
                            $selected = ''; 
                            if($market->id == $propert->market_id )
                            {
                                $selected = 'selected';
                            }

                        ?>
                        <option {{$selected}} value="{{ $market->id }}">{{ $market->name }}</option>
                        @endforeach
                        
                    </select>
                    <span id="market-error-msg-add" class="text-danger pl-1"><span>

                </div>
            </div>
        </div>
    </div>
@endforeach
    </form>
</div>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!-- Modal -->
  <form id="add-bid-from" action="bid-create" method="get" enctype="multipart/form-data">
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

            $('#user-error-msg-add').html('');
            $('#property-error-msg-add').html('');
            $('#bid-error-msg-add').html('');

            if(response.success == true)
                {

                    swal({
                        title: "Added",
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
