@extends('dashboard')
@section('content')

    <div class="card p-3 table-card">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addusermodal">Add User</button>
        </div>
       <div class="table-responsive" >
        <table class="table table-hover" id="user-data-table" width="100%">
            <div>
                <thead class="bg-primary text-white header-border text-center">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email </th>
                      <th scope="col">Type </th>
                      <th scope="col">Phone </th>
                      <th width="30%" scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody class="text-center">
                    {{-- <tr>
                      <th>1</th>
                      <td>Otto</td>
                      <td>abcd</td>
                      <td class="">
                        <div class="d-flex justify-content-center">
                          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addusermodal">add</button>
                          <button class="btn btn-info btn-sm ml-1">view</button>
                            <button class="btn btn-danger btn-sm ml-1">delele</button>
                          <button class="btn btn-warning btn-sm ml-1" data-bs-toggle="modal" data-bs-target="#editusermodal">edit</button>
                        </div>
                      </td>
                    </tr> --}}
                  </tbody>
            </div>

          </table>
       </div>
    </div>

  @include('Admin.user.create')
  @include('Admin.user.edit')




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {

        var table =  $('#user-data-table').DataTable({

            "bSort": true,
            "paging": true,
            "scrollCollapse": true,
            "lengthChange": true,
            "pageLength": 20,
            "responsive": true,
            "processing": false,
            "serverSide": true,
            "lengthMenu": [ 5, 10, 20, 30, 50 ],
            "order": [[ 0, "asc" ]],


            "ajax":{
                    "url": "{{ route('user-data') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },

            "columns": [

                { "data": "id" },
                { "data": "name" },
                { "data": "email" },
                { "data": "type" },
                { "data": "phone" },
                { "data": "action" , orderable: false, searchable: false }
            ]

        });

    });









    $(document).on('click', '.delete-user', function(){
            var id = $(this).data('id');


            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover user account!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {

                var url = "{{ route('users.destroy',':id') }}";
                url = url.replace(':id', id);

                var token = "{{ csrf_token() }}";

                $.ajax({
                    type: 'Delete',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {

                            $('#user-data-table').DataTable().ajax.reload();
                            swal("Poof! User has been deleted!", {
                                icon: "success",
                                timer: 1000,
                            });
                        }
                });




                } else {
                    swal("Your user account is safe!");
                }
            });





    });
</script>

@endsection
