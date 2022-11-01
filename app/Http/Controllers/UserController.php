<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.user.index');
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
            2 =>'email',
            3 =>'type',
            4 =>'phone',
            5 =>'action'

        );

                $data = User::all();

                $totalData = $data->count();

                $totalFiltered = $totalData;

                $limit = $request->input('length');
                $start = $request->input('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');

                if(empty($request->input('search.value')))
                {

                        $users = User::offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();

                }
                else {
                    $search = $request->input('search.value');



                        $users =  User::where('id','LIKE',"%{$search}%")
                                    ->orWhere('name', 'LIKE',"%{$search}%")
                                    ->orWhere('email', 'LIKE',"%{$search}%")
                                    ->orWhere('type', 'LIKE',"%{$search}%")
                                    ->orWhere('phone', 'LIKE',"%{$search}%")
                                    ->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get();

                        $totalFiltered = User::where('id','LIKE',"%{$search}%")
                                    ->orWhere('name', 'LIKE',"%{$search}%")
                                    ->orWhere('email', 'LIKE',"%{$search}%")
                                    ->orWhere('type', 'LIKE',"%{$search}%")
                                    ->orWhere('phone', 'LIKE',"%{$search}%")
                                    ->count();

                }

                $data = array();
                if(!empty($users))
                {
                foreach ($users as $user)
                {




                $nestedData['id'] = $user->id;
                $nestedData['name'] = $user->name;
                $nestedData['email'] = $user->email;
                $nestedData['type'] = $user->type;
                $nestedData['phone'] = $user->phone;




                $nestedData['action'] = '

                <td class="button-action">
                    <a href="javascript:0" class="btn btn-sm btn-warning  edit-user" data-id='.$user->id.'  data-toggle="modal" data-target="#editusermodalss">Edit</a>
                    <a href="javascript:0" class="btn btn-sm btn-danger delete-user" data-id='.$user->id.'   data-bs-toggle="" data-bs-target="#delModal"><i class="fa-solid fa-trash-can"></i> Delete</a>
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
        if($request->user_id != '')
        {
            $validator = Validator::make($data, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $request->user_id. ',id',
            ]);

        }else{

            $validator = Validator::make($data, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed'
            ]);

        }


        if($validator->fails()){
            return response()->json([
                'success' => false,
                'data'  => $validator->messages()->first()
            ]);

        }

        if($request->user_id != '')
        {
           $user = User::where('id', $request->user_id)->first();
           $user->name = $request->name;
           $user->email = $request->email;
           $user->type = $request->type;
           $user->phone = $request->phone;
           if(isset($request->password))
           {
            $user->password = Hash::make($request->password);
           }
           $user->save();



           return response()->json([
                'success' => true,
                'data'  => 'User Account Updated Successfuly'
            ]);


        }else{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->save();


            return response()->json([
                'success' => true,
                'data'  => 'User Account Created Successfuly'
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
        $user = User::where('id', $id)->first();

        if($user->type == 'REAL STATE AGENT')
        {
            $options = '
            <option  disabled>Select Type</option>
            <option selected value="REAL STATE AGENT">REAL STATE AGENT</option>
            <option value="INVESTOR">INVESTOR</option>
            ';
        }

        if($user->type == 'INVESTOR')
        {
            $options = '
            <option  disabled>Select Type</option>
            <option value="REAL STATE AGENT">REAL STATE AGENT</option>
            <option selected value="INVESTOR">INVESTOR</option>
            ';
        }


        $html = '

        <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="staticBackdropLabel">Edit user</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>
          <div class="modal-body">
            <div>
                <input type="hidden" name="user_id" class="form-control" placeholder="Enter User Type" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" value="'.$user->id.'">
                <div class="mt-4 mb-4">
                    <div class=" input-group-md">
                        <b>Name : </b>
                        <input type="text" name ="name" class="form-control" placeholder="Enter Name" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" value="'.$user->name.'">
                        <span id="name-error-msg" class="text-danger pl-1"><span>
                    </div>
                    <div class=" input-group-md">
                        <b>Email : </b>
                        <input type="email"  name ="email"   class="form-control" placeholder="Enter Email" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg"  value="'.$user->email.'">
                        <span id="email-error-msg" class="text-danger pl-1"><span>
                    </div>

                    <div class="input-group-md">
                        <b>Phone : </b>
                        <input type="text"  name ="phone"   class="form-control" placeholder="Enter Email" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg"  value="'.$user->phone.'">
                    </div>

                    <div class="input-group-md mt-4">
                        <label for="">User Type *</label>
                        <select required name="type" class="form-control">
                            '.$options.'
                        </select>
                    </div>

                    <div class=" input-group-md mt-4">
                        <b>Password : </b>
                        <input type="password"  name ="password"   class="form-control" placeholder="Enter Password" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg"  value="">
                    </div>
                </div>

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
            <button id="user-update-btn" type="button" class="btn btn-primary btn-md">Update</button>
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
        $user = User::where('id', $id)->delete();
        return true;
    }
}
