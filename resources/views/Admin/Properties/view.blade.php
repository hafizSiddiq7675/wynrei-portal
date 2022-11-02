<div class="modal fade" id="viewPropertyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <span id="view-property-box"></span>
  </div>



<script>
    $(document).on('click', '.view-property', function(){
        var id = $(this).data('id');
        


        var url = "{{ route('property.show',':id') }}";
        url = url.replace(':id', id);

        var token = "{{ csrf_token() }}";

        $.ajax({
            type: 'POST',
                url: url,
                data: {'_token': token, '_method': 'GET'},
                success: function (response) {
                    // alert(response);
                    $('#view-property-box').html(response);
                    $('#viewPropertyModal').modal('show');


                }
        });
    })
</script>
