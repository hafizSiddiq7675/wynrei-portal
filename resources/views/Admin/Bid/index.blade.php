@extends('dashboard')
@section('content')
    <div class="card p-3 table-card">
        <input type="hidden" name="check-role" id="check-role" value="{{ $role }}" >
        @if ($role == 'SuperAdmin')
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBidModal"> + Add Bid</button>
        </div>
        @endif

       <div class="table-responsive">
        <table class="table table-hover" id="bid-data-table" width="100%">
            <thead class="bg-primary text-white header-border text-center">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Property Address</th>
                <th scope="col">Bid Amount</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Agree</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <tr>
                {{-- <th>1</th>
                <td>proprty id</td>
                <td>Mark</td>
                <td>123</td>
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


    @include('Admin.Bid.create')
    @include('Admin.Bid.edit')



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>




  <script>
    $(document).ready(function () {

var table =  $('#bid-data-table').DataTable({

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
            "url": "{{ route('bid-data') }}",
            "dataType": "json",
            "type": "POST",
            "data":{ _token: "{{csrf_token()}}"}
        },

    "columns": [

        { "data": "id" },
        { "data": "property_address" },
        { "data": "bid_amount" },
        { "data": "name" },
        { "data": "email" },
        { "data": "phone" },
        { "data": "agree" },
        { "data": "status" , orderable: false, searchable: false },
        { "data": "action" , orderable: false, searchable: false }
    ]

});


    var role = $('#check-role').val();
    if(role == 'Agent')
    {
        table.column( 8 ).visible( false );
    }

    if(role == 'Buyer')
    {
        table.column( 8 ).visible( false );
    }

});




        $(document).on('click', '.delete-bid', function(){
            var id = $(this).data('id');

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this bid record!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {

                var url = "{{ route('bid.destroy',':id') }}";
                url = url.replace(':id', id);

                var token = "{{ csrf_token() }}";

                $.ajax({
                    type: 'Delete',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {

                            $('#bid-data-table').DataTable().ajax.reload();
                            swal("Poof! bid has been deleted!", {
                                icon: "success",
                                timer: 1000,
                            });
                        }
                });




                } else {
                    swal("Your bid is safe!");
                }
            });





        });




        /////////////Bid Status

        $(document).on('click', '.status-bid', function(){
        var id = $(this).data('id');
        var status = $(this).data('status');


        var url = "{{ route('bid-status') }}";


        var token = "{{ csrf_token() }}";

        $.ajax({
            type: 'POST',
                url: url,
                data: {'_token': token, '_method': 'POST', 'status' : status, 'bid_id' : id},
                success: function (response) {

                    swal({
                        title: "Status",
                        text: response.data,
                        icon: "success",
                        button: "OK!",
                        timer: 1000,
                    });

                    $('#bid-data-table').DataTable().ajax.reload();


                }
        });
    })



  </script>


@endsection
