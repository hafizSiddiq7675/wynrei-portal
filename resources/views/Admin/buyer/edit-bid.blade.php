  <!-- Modal -->
  <form id="buyer-bid-from"  method="post" enctype="multipart/form-data">
    @csrf
  <div class="modal fade" id="buyerEditBidModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="staticBackdropLabel">Add Bid</h4>
        </div>
        <div class="modal-body">
          <div id="edit-buyer-bid-box">

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
    $(document).on('click', '.buyer-bid-edit', function(){
        var id = $(this).data('id');

            // alert(id);

        var url = "{{ route('edit-bid-buyer',':id') }}";
        url = url.replace(':id', id);

        var token = "{{ csrf_token() }}";

        $.ajax({
            type: 'POST',
                url: url,
                data: {'_token': token, '_method': 'GET'},
                success: function (response) {
                        // alert(response);
                    $('#edit-buyer-bid-box').html(response);
                    $('#buyerEditBidModal').modal('show');


                }
        });
    })
  </script>
