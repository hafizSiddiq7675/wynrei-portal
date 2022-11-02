  <!-- Modal -->

  <form id="add-market-form">
    @csrf
    <div class="modal fade" id="addMarketmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="staticBackdropLabel">Add Market</h4>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div>
                <form action="">
                    <div class="mt-4 mb-4">
                        <div class=" input-group-md">
                            <label for="">Name of Market (city) *</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Name of Market (city)" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                          </div>
                          <span id="name-error-msg-add" class="text-danger pl-1"><span>

                    </div>
                   </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
              <button type="button" id="market-btn" class="btn btn-primary btn-md">Add</button>
            </div>
          </div>
        </div>
      </div>
  </form>





  <script>
            $(document).on( 'click' ,'#market-btn', function (e) {
                e.preventDefault();
                
                $.ajaxSetup({
                    headers: {
                        "_token": "{{ csrf_token() }}",
                    }
                });


                $.ajax({
                    url: "{{ route('market.store')}}",
                    method: 'post',
                    data: $('#add-market-form').serialize(),

                    success: function(response)
                    {
                        $('#name-error-msg-add').html('');

                        if(response.success == true)
                        {


                            swal({
                                title: "Created",
                                text: response.data,
                                icon: "success",
                                button: "OK!",
                                timer: 1000,
                            });
                            $('#add-market-form').trigger("reset");
                            $('#addMarketmodal').modal('hide');
                            $('#market-data-table').DataTable().ajax.reload();
                        }else{




                            var error = response.data;

                            if(error == 'The name field is required.')
                            {
                                $('#name-error-msg-add').html(error);
                            }


                        }

                    }

                });

            });
  </script>
