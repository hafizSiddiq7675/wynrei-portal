<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Property;
use App\Models\User;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = Property::all();
        $users = User::all();
        return view('Admin.Bid.index', compact('properties', 'users'));
    }




    public function data(Request $request)
    {


        $columns = array(
            0 =>'id',
            1 =>'property_address',
            2 =>'name',
            3 =>'email',
            4 =>'phone',
            5 =>'agree',
            6 =>'action'

        );

                $data = Bid::all();

                $totalData = $data->count();

                $totalFiltered = $totalData;

                $limit = $request->input('length');
                $start = $request->input('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');

                if(empty($request->input('search.value')))
                {

                        $bids = Bid::offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();

                }
                else {
                    $search = $request->input('search.value');



                        $bids =  Bid::where('id','LIKE',"%{$search}%")
                                    ->orWhere('property_address', 'LIKE',"%{$search}%")
                                    ->orWhere('name', 'LIKE',"%{$search}%")
                                    ->orWhere('email', 'LIKE',"%{$search}%")
                                    ->orWhere('phone', 'LIKE',"%{$search}%")
                                    ->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get();

                        $totalFiltered = Bid::where('id','LIKE',"%{$search}%")
                                    ->orWhere('property_address', 'LIKE',"%{$search}%")
                                    ->orWhere('name', 'LIKE',"%{$search}%")
                                    ->orWhere('email', 'LIKE',"%{$search}%")
                                    ->orWhere('phone', 'LIKE',"%{$search}%")
                                    ->count();

                }

                $data = array();
                if(!empty($bids))
                {
                foreach ($bids as $bid)
                {




                $nestedData['id'] = $bid->id;
                $nestedData['property_address'] = $bid->property_address;
                $nestedData['name'] = $bid->name;
                $nestedData['email'] = $bid->email;
                $nestedData['phone'] = $bid->phone;
                $nestedData['agree'] = $bid->agree;



                $nestedData['action'] = '

                <td class="button-action">
                    <a href="javascript:0" class="btn btn-sm btn-warning  edit-bid" data-id='.$bid->id.'  data-toggle="modal" data-target="#editusermodalss">Edit</a>
                    <a href="javascript:0" class="btn btn-sm btn-danger delete-bid" data-id='.$bid->id.'   data-bs-toggle="" data-bs-target="#delModal"><i class="fa-solid fa-trash-can"></i> Delete</a>
                </td>';

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
            ]);

            if($validator->fails()){

                return response()->json([
                    'success' => false,
                    'data'  => $validator->messages()->first()
                ]);

            }

            $bid = new Bid();
            $bid->property_address = $request->property_address;
            $bid->name = $request->name;
            $bid->email = $request->email;
            $bid->phone = $request->phone;
            $bid->bid_amount = $request->bid_amount;
            // $bid->agree = $request->agree;

            $bid->save();


            return response()->json([
                'success' => true,
                'data'  => 'Bid Created Successfuly'
            ]);


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
        //
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
    public function destroy($id)
    {
        //
    }
}
