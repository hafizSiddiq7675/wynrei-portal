<?php

namespace App\Http\Controllers;

use App\Models\Market;
use App\Models\Role;
use App\Models\User;
use App\Models\UserMarket;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Libraries\Helper;
use App\Models\UserRole;
use App\Http\Middleware\Acl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserMail;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(Acl::class);
    }


    public function index()
    {

        $roles = Role::all();
        return view('Admin.user.index', compact('roles'));
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

                // $data = User::all();
                $data = User::where('id', '!=' , auth::user()->id)->get();

                $totalData = $data->count();

                $totalFiltered = $totalData;

                $limit = $request->input('length');
                $start = $request->input('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');

                if(empty($request->input('search.value')))
                {

                        $users = User::where('id', '!=' , auth::user()->id)
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();

                }
                else {
                    $search = $request->input('search.value');



                        $users =  User::where('id', '!=' , auth::user()->id)
                                    ->where('id','LIKE',"%{$search}%")
                                    ->orWhere('name', 'LIKE',"%{$search}%")
                                    ->orWhere('email', 'LIKE',"%{$search}%")
                                    ->orWhere('type', 'LIKE',"%{$search}%")
                                    ->orWhere('phone', 'LIKE',"%{$search}%")
                                    ->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get();

                        $totalFiltered = User::where('id', '!=' , auth::user()->id)
                                    ->where('id','LIKE',"%{$search}%")
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

        // echo '<pre>'; print_r($request->all()); exit;
        $data = $request->all();
        if($request->user_id != '')
        {
            $validator = Validator::make($data, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $request->user_id. ',id',
                'role_id' => 'required',
            ]);

        }else{

            $validator = Validator::make($data, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'role_id' => 'required',
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
           $user->phone = $request->phone;
           if(isset($request->password))
           {
            $user->password = Hash::make($request->password);
           }
           $user->save();


           ////User Role
           $user_role = UserRole::where('user_id', $user->id)->first();
           $user_role->user_id = $user->id;
           $user_role->role_id = $request->role_id;
           $user_role->save();



           ////Markets
           if(isset($request->market_id))
           {
                $role = Role::where('id', $request->role_id)->first();
                if($role->role == 'Buyer')
                {
                    $markets = Market::all();

                    $old_markets = UserMarket::where('user_id', $user->id)->exists();
                    if($old_markets)
                    {
                        UserMarket::where('user_id', $user->id)->delete();
                    }

                    foreach($request->market_id as $market)
                    {
                        $user_market = new UserMarket();
                        $user_market->user_id = $user->id;
                        $user_market->market_id = $market;

                        $user_market->save();

                    }
                }
           }




           return response()->json([
                'success' => true,
                'data'  => 'User Account Updated Successfuly'
            ]);


        }else{

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);

            $user->save();


            ////User Role
            $user_role = new UserRole();
            $user_role->user_id = $user->id;
            $user_role->role_id = $request->role_id;
            $user_role->save();


            ////Markets
            $role = Role::where('id', $request->role_id)->first();
            if($role->role == 'Buyer')
            {
                $markets = Market::all();

                foreach($markets as $market)
                {
                    $user_market = new UserMarket();
                    $user_market->user_id = $user->id;
                    $user_market->market_id = $market->id;

                    $user_market->save();

                }
            }





            $reset = DB::table('password_resets')->where('email', $request->email)->first();

            if (!$reset) {
                $token =  md5(uniqid(rand(), true));
                DB::table('password_resets')->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => gmdate('Y-m-d G:i:s')
                ]);
                $result['token'] = $token;
            } else {
                $token = md5(uniqid(rand(), true));
                DB::table('password_resets')->where('email', $request->email)
                    ->update([
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => gmdate('Y-m-d G:i:s')
                    ]);
                $result['token'] = $token;
            }

            $data = [
                'title' => 'Welcome',
                'email' => $request->email,
                'token' => $token
            ];
            Mail::to($request->email)->send(new NewUserMail($data));


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
        $markets = Market::all();
        $roles = Role::all();




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
                        <label for="">User Role *</label>
                        <select required name="role_id" class="form-control form-select">
                        <option  disabled>Select User Role</option>';

                        $user_role = Helper::checkRole($user);
                        foreach($roles as $role)
                        {
                            $selected = '';

                            if($user_role->id == $role->id)
                            {
                                $selected = 'selected';
                            }
                            $html .= '<option '.$selected.' value="'.$role->id.'">'.$role->role.'</option>';
                        }

                        $html .= '</select>
                        <span id="role-error-msg-update" class="text-danger pl-1"><span>
                    </div>';

                    if($user_role->role == 'Buyer')
                    {
                        $html .= '<div class="row" id="market-section">';
                        foreach($markets as $market)
                        {
                            $checked = '';
                            $user_market = UserMarket::where('user_id', $user->id)->where('market_id', $market->id)->first();
                            if($user_market){
                                $checked = 'checked';
                            }
                            $html .=
                            '<div class="col-md-4">
                                <div class="form-check">
                                    <input '.$checked.' name="market_id[]" class="form-check-input" type="checkbox" value="'.$market->id.'" id="flexCheckDefault" />
                                    <label class="form-check-label" for="flexCheckDefault">'.$market->name.'</label>
                                </div>
                            </div>
                            ';
                        }
                        $html .= '</div>';

                    }



                    $html .='<div class=" input-group-md mt-4">
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


    public function createPassword()
    {
        return view('auth.passwords.new-password');
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
