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
alert(id);


        var url = "{{ route('bid.edit',':id') }}";
        url = url.replace(':id', id);

        var token = "{{ csrf_token() }}";

        $.ajax({
            type: 'POST',
                url: url,
                data: {'_token': token, '_method': 'GET'},
                success: function (response) {
                        alert(response);
                    $('#update-bid-section').html(response);
                    $('#updateBidModal').modal('show');


                }
        });
    })
  </script>
