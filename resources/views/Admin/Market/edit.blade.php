  <!-- Modal -->

  <form id="update-market-form">
    @csrf
    <div class="modal fade" id="updateMarketmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <span id="market-update-section"></span>
      </div>
  </form>



<script>
    $(document).on('click', '.edit-market', function(){
        var id = $(this).data('id');


        var url = "{{ route('market.edit',':id') }}";
        url = url.replace(':id', id);

        var token = "{{ csrf_token() }}";

        $.ajax({
            type: 'POST',
                url: url,
                data: {'_token': token, '_method': 'GET'},
                success: function (response) {

                    $('#market-update-section').html(response);
                    $('#updateMarketmodal').modal('show');


                }
        });
    })



    $(document).on( 'click' ,'#market-btn-update', function (e) {
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        "_token": "{{ csrf_token() }}",
                    }
                });


                $.ajax({
                    url: "{{ route('market.store')}}",
                    method: 'post',
                    data: $('#update-market-form').serialize(),

                    success: function(response)
                    {
                        $('#name-error-msg-update').html('');

                        if(response.success == true)
                        {


                            swal({
                                title: "Updated",
                                text: response.data,
                                icon: "success",
                                button: "OK!",
                                timer: 1000,
                            });
                            
                            $('#updateMarketmodal').modal('hide');
                            $('#market-data-table').DataTable().ajax.reload();
                        }else{




                            var error = response.data;

                            if(error == 'The name field is required.')
                            {
                                $('#name-error-msg-update').html(error);
                            }


                        }

                    }

                });

            });
</script>




