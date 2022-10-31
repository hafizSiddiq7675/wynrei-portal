@extends('dashboard')
@section('content')
    <div class="card p-3 table-card">
       <div class="table-responsive">
        <table class="table table-hover">
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
                <th>1</th>
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
                </td>
              </tr>
            </tbody>
          </table>
       </div>
    </div>
  
  <!-- Modal -->
  <div class="modal fade" id="addusermodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="staticBackdropLabel">Add Property</h4>
        </div>
        <div class="modal-body">
          <div>
            <form action="">
                <div class="mt-4 mb-4">
                    <div class=" input-group-md">
                        <input type="text" required class="form-control" placeholder="Enter Address" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                      </div>
                    <div class=" input-group-md mt-3">
                        <input type="text" required class="form-control" placeholder="Enter City" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                      </div>
                      <div class="input-group-md mt-3">
                        <input type="text" required class="form-control" placeholder="Enter State" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                      </div>
                      <div class="input-group-md mt-3">
                        <input type="text" required class="form-control" placeholder="Enter Zip" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                      </div>
                </div>
               </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-md">Add</button>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="editusermodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="staticBackdropLabel">Edit Property</h4>
        </div>
        <div class="modal-body">
          <div>
            <form action="">
                <div class="mt-4 mb-4">
                    <div class=" input-group-md">
                        <input type="text" required class="form-control" placeholder="Enter Address" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                      </div>
                    <div class=" input-group-md mt-3">
                        <input type="text" required class="form-control" placeholder="Enter City" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                      </div>
                      <div class="input-group-md mt-3">
                        <input type="text" required class="form-control" placeholder="Enter State" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                      </div>
                      <div class="input-group-md mt-3">
                        <input type="text" required class="form-control" placeholder="Enter Zip" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                      </div>
                </div>
               </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-md">Edit</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


@endsection