  <!-- Modal -->
  <form id="update-property-from"  method="post" enctype="multipart/form-data">
    @csrf

  <div class="modal fade" id="updatePropertyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <span id="update-property-box"></span>
  </div>
</form>


  <script>
    $(document).on('click', '.edit-property', function(){
        var id = $(this).data('id');



        var url = "{{ route('property.edit',':id') }}";
        url = url.replace(':id', id);

        var token = "{{ csrf_token() }}";

        $.ajax({
            type: 'POST',
                url: url,
                data: {'_token': token, '_method': 'GET'},
                success: function (response) {
                    
                    $('#update-property-box').html(response);
                    $('#updatePropertyModal').modal('show');


                }
        });
    })









    var i = 0;
    $(document).on('click', '#add-photo-btn-edit', function(){
        i = i + 1 ;
       var html =
       `
       <div class="row" id="more-photo-edit-${i}">
        <div class="col-md-10">

            <div class="custom-file mt-3">
                <input type="file" name="photo[]" class="custom-file-input" id="customFile" required>
                <label class="custom-file-label" for="customFile">Choose Photo</label>
            </div>


        </div>
        <div class="col-md-2 d-flex justify-content-end mt-3">
            <span data-id="${i}" class="btn btn-danger  remove-photo-edit" >Remove<span>
        </div>
        </div>



       `;

       $('#add-more-photoes-edit').append(html);
    });

    $(document).on('click', '.remove-photo-edit', function(){
        var id = $(this).data('id');

        $('#more-photo-edit-'+id).remove();

    });



    ///// document
    var i = 0;
    $(document).on('click', '#add-document-btn-edit', function(){
        i = i + 1 ;
       var html =
       `
       <div class="row" id="more-document-edit-${i}">
        <div class="col-md-10">


            <div class="custom-file mt-3">
                <input type="file" name="document[]" class="custom-file-input" id="customFile" required>
                <label class="custom-file-label" for="customFile">Choose Document</label>
            </div>

        </div>
        <div class="col-md-2 d-flex justify-content-end mt-3">
            <span data-id="${i}" class="btn btn-danger  remove-document-edit" >Remove<span>
        </div>
        </div>


       `;

       $('#add-more-document-edit').append(html);
    });

    $(document).on('click', '.remove-document-edit', function(){
        var id = $(this).data('id');
        $('#more-document-edit-'+id).remove();
    });





        //////Form Submit


        $('#update-property-from').submit(function(e) {
       e.preventDefault();

       var formData = new FormData(this);

       $.ajax({
          type:'POST',
          url: "{{ route('property.store')}}",
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
                    $('#updatePropertyModal').modal('hide');
                    $('#property-data-table').DataTable().ajax.reload();

                }else{
                    var error = response.data;
                    // alert(error)
                    // $('#setting_key_error').html(error);
                }
           }
       });
    });
  </script>
