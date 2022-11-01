@extends('dashboard')
@section('content')
    <div class="card p-3 table-card">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPropertyModal">Add Property</button>
        </div>
       <div class="table-responsive">
        <table class="table table-hover" id="property-data-table" width="100%">
            <thead class="bg-primary text-white header-border text-center">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Address</th>
                <th scope="col">City </th>
                <th scope="col">State</th>
                <th scope="col">Zip</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <tr>
                {{-- <th>1</th>
                <td>abc</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>abcd</td>
                <td class="">
                  <div class="d-flex justify-content-center">
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addusermodal">add</button>
                    <button class="btn btn-info btn-sm ml-1">view</button>
                      <button class="btn btn-danger btn-sm ml-1">delele</button>
                    <button class="btn btn-warning btn-sm ml-1" data-bs-toggle="modal" data-bs-target="#editusermodal">edit</button>
                  </div>
                </td> --}}
              </tr>
            </tbody>
          </table>
       </div>
    </div>

@include('Admin.Properties.create')
@include('Admin.Properties.edit')




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <script>
    $(document).ready(function () {

var table =  $('#property-data-table').DataTable({

    "bSort": true,
    "paging": true,
    "scrollCollapse": true,
    "lengthChange": true,
    "pageLength": 20,
    "responsive": true,
    "processing": false,
    "serverSide": true,
    "lengthMenu": [ 5, 10, 20, 30, 50 ],
    "order": [[ 0, "desc" ]],


    "ajax":{
            "url": "{{ route('property-data') }}",
            "dataType": "json",
            "type": "POST",
            "data":{ _token: "{{csrf_token()}}"}
        },

    "columns": [

        { "data": "id" },
        { "data": "property_addres" },
        { "data": "city" },
        { "data": "state" },
        { "data": "zip_code" },
        { "data": "action" , orderable: false, searchable: false }
    ]

});

});





    $(document).on('click', '.delete-property', function(){
            var id = $(this).data('id');


            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {

                var url = "{{ route('property.destroy',':id') }}";
                url = url.replace(':id', id);

                var token = "{{ csrf_token() }}";

                $.ajax({
                    type: 'Delete',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {

                            $('#property-data-table').DataTable().ajax.reload();
                            swal("Poof! Property has been deleted!", {
                                icon: "success",
                                timer: 1000,
                            });
                        }
                });




                } else {
                    swal("Your Category is safe!");
                }
            });





    });
  </script>

@endsection
