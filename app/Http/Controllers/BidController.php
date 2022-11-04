<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Property;
use App\Models\User;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Acl;
use App\Libraries\Helper;
use Illuminate\Support\Facades\Mail;
use App\Mail\BidMail;

class BidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware(Acl::class);
    }


    public function index()
    {

        $properties = Property::all();
        $users = User::all();
        $user =  auth::user();
        $role = Helper::role($user);
        return view('Admin.Bid.index', compact('properties', 'users', 'role'));
    }




    public function data(Request $request)
    {


        $columns = array(
            0 =>'id',
            1 =>'property_address',
            2 => 'bid_amount',
            3 =>'name',
            4 =>'email',
            5 =>'phone',
            6 =>'agree',
            7 =>'status',
            8 =>'action'

        );
                $user =  auth::user();
                $role = Helper::role($user);

                if($role == 'Agent')
                {

                    $property_address = Property::where('user_id', $user->id)->pluck('property_addres')->toArray();
                    $data =  Bid::whereIn('property_address', $property_address)->get();

                }else{
                    $data = Bid::all();
                }


                $totalData = $data->count();

                $totalFiltered = $totalData;

                $limit = $request->input('length');
                $start = $request->input('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');

                if(empty($request->input('search.value')))
                {

                    if($role == 'Agent')
                    {
                         $property_address = Property::where('user_id', $user->id)->pluck('property_addres')->toArray();
                        // $data =  Bid::whereIn('property_address', $property_address)->get();
                        $bids = Bid::whereIn('property_address', $property_address)
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


                    }else{
                        $bids = Bid::offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
                    }


                }
                else {
                    $search = $request->input('search.value');

                    if($role == 'Agent')
                    {
                        $property_address = Property::where('user_id', $user->id)->pluck('property_addres')->toArray();


                        $bids =  Bid::whereIn('property_address',  $property_address)->where(function ($q) use ($search) {
                            $q->orWhere('id','LIKE',"%{$search}%")
                                ->orWhere('property_address', 'LIKE',"%{$search}%")
                                ->orWhere('bid_amount', 'LIKE',"%{$search}%")
                                ->orWhere('agree', 'LIKE',"%{$search}%")
                                ->orWhereHas(
                                    'user',
                                    function ($q2) use ($search) {
                                        $q2->where('name', 'LIKE',"%{$search}%")
                                        ->orWhere('email', 'LIKE',"%{$search}%")
                                        ->orWhere('phone', 'LIKE',"%{$search}%");

                                    }
                                );

                            })
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order, $dir)
                            ->get();


                            $totalFiltered =  Bid::whereIn('property_address',  $property_address)->where(function ($q) use ($search) {
                                $q->orWhere('id','LIKE',"%{$search}%")
                                    ->orWhere('property_address', 'LIKE',"%{$search}%")
                                    ->orWhere('bid_amount', 'LIKE',"%{$search}%")
                                    ->orWhere('agree', 'LIKE',"%{$search}%")
                                    ->orWhereHas(
                                        'user',
                                        function ($q2) use ($search) {
                                            $q2->where('name', 'LIKE',"%{$search}%")
                                            ->orWhere('email', 'LIKE',"%{$search}%")
                                            ->orWhere('phone', 'LIKE',"%{$search}%");

                                        }
                                    );

                                })

                            ->count();




                    }else{


                        $bids = Bid::where('id','LIKE',"%{$search}%")
                            ->orWhere('property_address', 'LIKE',"%{$search}%")
                            ->orWhere('bid_amount', 'LIKE',"%{$search}%")
                            ->orWhere('agree', 'LIKE',"%{$search}%")
                            ->orWhereHas(
                                'user',
                                function ($q) use ($search) {
                                    $q->where('name', 'LIKE',"%{$search}%")
                                    ->orWhere('email', 'LIKE',"%{$search}%")
                                    ->orWhere('phone', 'LIKE',"%{$search}%");

                                }
                            )
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                        ->get();

                        $totalFiltered = Bid::where('id','LIKE',"%{$search}%")
                            ->orWhere('property_address', 'LIKE',"%{$search}%")
                            ->orWhere('bid_amount', 'LIKE',"%{$search}%")
                            ->orWhere('agree', 'LIKE',"%{$search}%")
                            ->orWhereHas(
                                'user',
                                function ($q) use ($search) {
                                    $q->where('name', 'LIKE',"%{$search}%")
                                    ->orWhere('email', 'LIKE',"%{$search}%")
                                    ->orWhere('phone', 'LIKE',"%{$search}%");

                                }
                            )
                        ->count();

                    }








                }

                $data = array();
                if(!empty($bids))
                {
                foreach ($bids as $bid)
                {


                $user = User::where('id', $bid->user_id)->first();
                $agree = 'No';
                if($bid->agree == '1')
                {
                   $agree = 'Yes';
                }

                $class = 'danger';
                if($bid->status == 'Accepted')
                {
                    $class = 'success';
                }

                if($bid->status == 'Rejected')
                {
                    $class = 'danger';
                }

                if($bid->status == 'Pending')
                {
                    $class = 'warning';
                }

                $nestedData['id'] = $bid->id;
                $nestedData['property_address'] = $bid->property_address;
                $nestedData['bid_amount'] = $bid->bid_amount;
                $nestedData['name'] = $user->name;
                $nestedData['email'] = $user->email;
                $nestedData['phone'] = $user->phone;
                $nestedData['agree'] = $agree;

                $user =  auth::user();
                $role = Helper::role($user);




                $nestedData['status'] = '

                <td class="button-action">
                    <div class="btn-group">
                        <button type="button" class="btn btn-'.$class.' dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            '.$bid->status.'
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item text-success status-bid" data-status="Accepted" data-id="'.$bid->id.'" href="javascript:0"><b>Accept</b></a>

                            <a class="dropdown-item text-danger status-bid" data-status="Rejected" data-id="'.$bid->id.'" href="javascript:0"><b> Reject </b></a>


                            <a class="dropdown-item text-warning status-bid" data-status="Pending" data-id="'.$bid->id.'" href="javascript:0"><b>Pending</b></a>

                        </div>
                    </div>

                </td>';




                if($role == 'SuperAdmin')
                {
                    $nestedData['action'] = '

                        <td class="button-action">
                            <a href="javascript:0" class="btn btn-sm btn-warning  edit-bid" data-id='.$bid->id.'  data-toggle="modal" data-target="#editusermodalss">Edit</a>
                            <a href="javascript:0" class="btn btn-sm btn-danger delete-bid" data-id='.$bid->id.'   data-bs-toggle="" data-bs-target="#delModal"><i class="fa-solid fa-trash-can"></i> Delete</a>
                        </td>
                    ';
                }else{

                    $nestedData['action'] = '';

                }




                $data[] = $nestedData;




                }
                }

                $json_data = array(
                    "draw"            => intval($request->input('draw')),
                    "recordsTotal"    => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data"            => $data
                    );

                echo json_encode($json_data);
    }



    public function user(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        $response = [
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
        ];

        return $response;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $data = $request->all();
            $validator = Validator::make($data, [
                'property_address' => 'required',
                'user_id' => 'required',
                'bid_amount' => 'required',
            ]);

            if($validator->fails()){

                return response()->json([
                    'success' => false,
                    'data'  => $validator->messages()->first()
                ]);

            }


            if($request->bid_id != '')
            {
                $bid =  Bid::where('id', $request->bid_id)->first();
                $bid->property_address = $request->property_address;
                $bid->user_id = $request->user_id;
                $bid->bid_amount = $request->bid_amount;
                $bid->agree = $request->agree;

                $bid->save();

                $property = Property::where('property_addres', $request->property_address)->first();
                $user = User::where('id', $property->user_id)->first();

                $customer = User::where('id', $request->user_id)->first();
                $data = [
                    'bid' => $request->bid_amount,
                    'customer' => $customer,
                    'link' => env('APP_URL').'bid'
                ];


                Mail::to($user->email)->send(new BidMail($data));

                return response()->json([
                    'success' => true,
                    'data'  => 'Bid Updated Successfuly',

                ]);



            }else{
                $bid = new Bid();
                $bid->property_address = $request->property_address;
                $bid->user_id = $request->user_id;
                $bid->bid_amount = $request->bid_amount;
                $bid->agree = $request->agree;

                $bid->save();


                $property = Property::where('property_addres', $request->property_address)->first();
                $user = User::where('id', $property->user_id)->first();

                $customer = User::where('id', $request->user_id)->first();
                $data = [
                    'bid' => $request->bid_amount,
                    'customer' => $customer,
                    'link' => env('APP_URL').'bid'
                ];
                Mail::to($user->email)->send(new BidMail($data));



                return response()->json([
                    'success' => true,
                    'data'  => 'Bid Created Successfuly'
                ]);





            }





    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bid = Bid::where('id', $id)->first();
        $users = User::all();
        $properties = Property::all();

        $checked = '';
        if($bid->agree == '1')
        {
            $checked = 'checked';
        }

        $html = '

        <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="staticBackdropLabel">Update Bid</h4>
          </div>
          <div class="modal-body">
            <div>

              <input type="hidden" name="bid_id" id="" value="'.$bid->id.'" class="form-control" placeholder="Enter Phone" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" >
                  <div class="mt-4 mb-4">
                      <div class="">
                          <label for="">Property Address *</label>
                          <select required name="property_address" class="form-select form-control" aria-label="Default select example">
                              <option selected disabled>Select property </option>';
                              foreach ($properties as $property)
                              {
                                $selected = '';
                                if($property->property_addres == $bid->property_address)
                                {
                                    $selected = 'selected';
                                }
                                $html .= ' <option '.$selected.' value="'. $property->property_addres .'">'. $property->property_addres .'</option>';
                              }


                            $html .='</select>
                            <span id="property-error-msg-update" class="text-danger pl-1"><span>
                        </div>

                        <div class="mt-1">
                          <b for="">User *</b>
                          <select required name="user_id" class="form-select form-control user_id" aria-label="Default select example">
                              <option selected disabled>Select property </option>';
                              foreach ($users as $user)
                              {
                                $selected = '';
                                if($user->id == $bid->user_id)
                                {
                                    $selected = 'selected';
                                }

                                $html .= '<option '.$selected.' value="'. $user->id .'">'. $user->name .'</option>';
                              }


                            $html .= '</select>
                            <span id="user-error-msg-update" class="text-danger pl-1"><span>

                        </div>

                        <div class="input-group-md mt-3">
                          <label for=""> Bid Ammount *</label>
                          <input type="number" name="bid_amount" value="'.$bid->bid_amount.'" id=""  class="form-control" placeholder="Enter Phone" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" >
                          <span id="bid-error-msg-update" class="text-danger pl-1"><span>

                        </div>

                        <!-- Default checkbox -->
                      <div class="form-check input-group-md mt-3">
                          <input class="form-check-input" '.$checked.' name="agree" type="checkbox" value="1" id="flexCheckDefault" />
                          <label class="form-check-label" for="flexCheckDefault">I agree to the terms of service and terms of bidding on WynREI.com. This offer is not final and accepted until accepted by Seller. Once accepted, this offer becomes binding.</label>
                      </div>

                  </div>

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-md">Update</button>
          </div>
        </div>
      </div>


        ';

        return $html;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


     public function status(Request $request)
     {

        $bid = Bid::where('id', $request->bid_id)->first();
        $bid->status = $request->status;

        $bid->save();

        return response()->json([
            'success' => true,
            'data'  => 'Bid Status Updated Successfuly'
        ]);

     }




    public function destroy($id)
    {
        $bid = Bid::where('id', $id)->delete();
        return true;
    }
}
