<?php

namespace App\Http\Controllers;

use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MarketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.Market.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function data(Request $request)
    {


        $columns = array(
            0 =>'id',
            1 =>'name',
            2 =>'action'

        );

                $data = Market::all();

                $totalData = $data->count();

                $totalFiltered = $totalData;

                $limit = $request->input('length');
                $start = $request->input('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');

                if(empty($request->input('search.value')))
                {

                        $markets = Market::offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();

                }
                else {
                    $search = $request->input('search.value');



                        $markets =  Market::where('id','LIKE',"%{$search}%")
                                    ->orWhere('name', 'LIKE',"%{$search}%")
                                    ->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get();

                        $totalFiltered = Market::where('id','LIKE',"%{$search}%")
                                    ->orWhere('name', 'LIKE',"%{$search}%")
                                    ->count();

                }

                $data = array();
                if(!empty($markets))
                {
                foreach ($markets as $market)
                {




                $nestedData['id'] = $market->id;
                $nestedData['name'] = $market->name;


                $nestedData['action'] = '

                <td class="button-action">
                    <a href="javascript:0" class="btn btn-sm btn-warning  edit-market" data-id='.$market->id.'  data-toggle="modal" data-target="#editusermodalss">Edit</a>
                    <a href="javascript:0" class="btn btn-sm btn-danger delete-market" data-id='.$market->id.'   data-bs-toggle="" data-bs-target="#delModal"><i class="fa-solid fa-trash-can"></i> Delete</a>
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
                'name' => 'required',

            ]);

            if($validator->fails()){

                return response()->json([
                    'success' => false,
                    'data'  => $validator->messages()->first()
                ]);

            }


            if($request->market_id != '')
            {


                $market = Market::where('id', $request->market_id)->first();
                $market->name = $request->name;
                $market->save();

                return response()->json([
                    'success' => true,
                    'data'  => 'Market Updated Successfuly'
                ]);



            }else{

                $market = new Market();
                $market->name = $request->name;
                $market->save();

                return response()->json([
                    'success' => true,
                    'data'  => 'Market Created Successfuly'
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
        $market = Market::where('id', $id)->first();

        $html = '
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="staticBackdropLabel">Edit Market</h4>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div>

                    <div class="mt-4 mb-4">
                    <input type="hidden" value="'.$market->id.'" name="market_id" class="form-control" placeholder="Enter Name of Market (city)" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">

                        <div class=" input-group-md">
                            <label for="">Name of Market (city) *</label>
                            <input type="text" value="'.$market->name.'" name="name" class="form-control" placeholder="Enter Name of Market (city)" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                          </div>
                          <span id="name-error-msg-update" class="text-danger pl-1"><span>

                    </div>

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
              <button type="button" id="market-btn-update" class="btn btn-primary btn-md">Update</button>
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
    public function destroy($id)
    {
        $market = Market::where('id', $id)->delete();
        return true;
    }
}
