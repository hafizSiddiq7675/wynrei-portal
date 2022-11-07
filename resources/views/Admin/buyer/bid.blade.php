  <!-- Modal -->
  <form id="add-bid-from"  method="post" enctype="multipart/form-data">
    @csrf
  <div class="modal fade" id="buyerBidModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="staticBackdropLabel">Add Bid</h4>
        </div>
        <div class="modal-body">
          <div>
            <form action="">
                <div class="mt-4 mb-4">




                      <div class="input-group-md mt-3">
                        <label for=""> Bid Amount *</label>
                        <input type="number" name="bid_amount" id=""  class="form-control" placeholder="Enter Amount" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" >
                        <span id="bid-error-msg-add" class="text-danger pl-1"><span>

                      </div>

                      <!-- Default checkbox -->
                    <div class="form-check input-group-md mt-3">
                        <input class="form-check-input" name="agree" type="checkbox" value="1" id="flexCheckDefault" />
                        <label class="form-check-label" for="flexCheckDefault">I agree to the terms of service and terms of bidding on WynREI.com. This offer is not final and accepted until accepted by Seller. Once accepted, this offer becomes binding.</label>
                    </div>

                </div>
               </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-md">Add </button>
        </div>
      </div>
    </div>
  </div>
  </form>


 



