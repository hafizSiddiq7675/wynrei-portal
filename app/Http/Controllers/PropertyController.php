<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Market;
use App\Models\Photo;
use App\Models\Property;
use Illuminate\Http\Request;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index()
    {
        $markets = Market::all();
        return view('Admin.Properties.index', compact('markets'));
    }


    public function data(Request $request)
    {


        $columns = array(
            0 =>'id',
            1 =>'address',
            2 =>'city',
            3 =>'state',
            4 =>'zip_code',
            3=>'action'

        );

                $data = Property::all();

                $totalData = $data->count();

                $totalFiltered = $totalData;

                $limit = $request->input('length');
                $start = $request->input('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');

                if(empty($request->input('search.value')))
                {

                        $properties = Property::offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();

                }
                else {
                    $search = $request->input('search.value');



                        $properties =  Property::where('id','LIKE',"%{$search}%")
                                    ->orWhere('property_addres', 'LIKE',"%{$search}%")
                                    ->orWhere('city', 'LIKE',"%{$search}%")
                                    ->orWhere('state', 'LIKE',"%{$search}%")
                                    ->orWhere('zip_code', 'LIKE',"%{$search}%")
                                    ->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get();

                        $totalFiltered = Property::where('id','LIKE',"%{$search}%")
                                    ->orWhere('property_addres', 'LIKE',"%{$search}%")
                                    ->orWhere('city', 'LIKE',"%{$search}%")
                                    ->orWhere('state', 'LIKE',"%{$search}%")
                                    ->orWhere('zip_code', 'LIKE',"%{$search}%")
                                    ->count();

                }

                $data = array();
                if(!empty($properties))
                {
                foreach ($properties as $property)
                {




                $nestedData['id'] = $property->id;
                $nestedData['property_addres'] = $property->property_addres;
                $nestedData['city'] = $property->city;
                $nestedData['state'] = $property->state;
                $nestedData['zip_code'] = $property->zip_code;




                $nestedData['action'] = '

                <td class="button-action">
                    <a href="javascript:0" class="btn btn-sm btn-primary  view-property" data-id='.$property->id.'  data-toggle="modal" data-target="">View</a>
                    <a href="javascript:0" class="btn btn-sm btn-warning  edit-property" data-id='.$property->id.'  data-toggle="modal" data-target="">Edit</a>
                    <a href="javascript:0" class="btn btn-sm btn-danger delete-property" data-id='.$property->id.'   data-bs-toggle="" data-bs-target="#delModal"><i class="fa-solid fa-trash-can"></i> Delete</a>
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
                'property_type' => 'required',
                'market_id' => 'required',
            ]);

            if($validator->fails()){

                return response()->json([
                    'success' => false,
                    'data'  => $validator->messages()->first()
                ]);

            }

        if($request->property_id != '')
        {
            $property = Property::where('id', $request->property_id)->first();
            $property->property_addres = $request->property_addres;
            $property->address_line_2 = $request->address_line_2;
            $property->city = $request->city;
            $property->state = $request->state;
            $property->zip_code = $request->zip_code;
            $property->property_description = $request->property_description;
            $property->closing_date = $request->closing_date;
            $property->asking_price = $request->asking_price;
            $property->arv = $request->arv;
            $property->rehab_estimate = $request->rehab_estimate;
            $property->rental_comps = $request->rental_comps;
            $property->bedrooms = $request->bedrooms;
            $property->bathrooms = $request->bathrooms;
            $property->square_footage = $request->square_footage;
            $property->property_type = $request->property_type;
            $property->year_built = $request->year_built;
            $property->market_id = $request->market_id;

            $property->save();


            if(isset($request->photo))
            {

                Photo::where('property_id', $request->property_id)->delete();
                foreach($request->photo as $photo)
                {



                    $file = $photo;
                    $name = 'dashboard/property-images/'.time() . $file->getClientOriginalName();
                    $file->move(public_path('dashboard/property-images'), $name);

                    $Photo = new Photo();
                    $Photo->property_id = $property->id;
                    $Photo->photo = $name;

                    $Photo->save();

                }

            }


            if(isset($request->document))
            {
                Document::where('property_id', $request->property_id)->delete();
                foreach($request->document as $document)
                {



                    $file = $document;
                    $name = 'dashboard/property-document/'.time() . $file->getClientOriginalName();
                    $file->move(public_path('dashboard/property-document'), $name);

                    $Document = new Document();
                    $Document->property_id = $property->id;
                    $Document->document = $name;

                    $Document->save();
                }

            }

            $response = [
                'success' => true,
                'data' => 'Property Updated Scuccessfull'

            ];


            return $response;


        }else{

            $property = new Property();
            $property->property_addres = $request->property_addres;
            $property->address_line_2 = $request->address_line_2;
            $property->city = $request->city;
            $property->state = $request->state;
            $property->zip_code = $request->zip_code;
            $property->property_description = $request->property_description;
            $property->closing_date = $request->closing_date;
            $property->asking_price = $request->asking_price;
            $property->arv = $request->arv;
            $property->rehab_estimate = $request->rehab_estimate;
            $property->rental_comps = $request->rental_comps;
            $property->bedrooms = $request->bedrooms;
            $property->bathrooms = $request->bathrooms;
            $property->square_footage = $request->square_footage;
            $property->property_type = $request->property_type;
            $property->year_built = $request->year_built;
            $property->market_id = $request->market_id;

            $property->save();

            if(isset($request->photo))
            {
                foreach($request->photo as $photo)
                {



                    $file = $photo;
                    $name = 'dashboard/property-images/'.time() . $file->getClientOriginalName();
                    $file->move(public_path('dashboard/property-images'), $name);

                    $Photo = new Photo();
                    $Photo->property_id = $property->id;
                    $Photo->photo = $name;

                    $Photo->save();

                }

            }


            if(isset($request->document))
            {
                foreach($request->document as $document)
                {



                    $file = $document;
                    $name = 'dashboard/property-document/'.time() . $file->getClientOriginalName();
                    $file->move(public_path('dashboard/property-document'), $name);

                    $Document = new Document();
                    $Document->property_id = $property->id;
                    $Document->document = $name;

                    $Document->save();
                }

            }


            $response = [
                'success' => true,
                'data' => 'Property Added Scuccessfull'

            ];


            return $response;


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
        $property = Property::where('id', $id)->first();
        $date = date('Y-m-d', strtotime($property->closing_date));

        $photoes = Photo::where('property_id', $id)->get();
        $documents = Document::where('property_id', $id)->get();
        $markets = Market::all();

        if($property->property_type == 'Single-family')
        {
            $options = '
            <option  disabled>Select Property</option>
            <option  selected value="Single-family">Single-family</option>
            <option value="Multi-family">Multi-family</option>
            <option value="Commercial">Commercial</option>
            <option value="Industrial">Industrial</option>
            ';
        }

        if($property->property_type == 'Multi-family')
        {
            $options = '
            <option  disabled>Select Property</option>
            <option   value="Single-family">Single-family</option>
            <option  selected value="Multi-family">Multi-family</option>
            <option value="Commercial">Commercial</option>
            <option value="Industrial">Industrial</option>
            ';
        }

        if($property->property_type == 'Commercial')
        {
            $options = '
            <option  disabled>Select Property</option>
            <option   value="Single-family">Single-family</option>
            <option   value="Multi-family">Multi-family</option>
            <option selected value="Commercial">Commercial</option>
            <option value="Industrial">Industrial</option>
            ';
        }

        if($property->property_type == 'Industrial')
        {
            $options = '
            <option  disabled>Select Property</option>
            <option   value="Single-family">Single-family</option>
            <option   value="Multi-family">Multi-family</option>
            <option  value="Commercial">Commercial</option>
            <option  selected value="Industrial">Industrial</option>
            ';
        }


        $html = '

        <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="staticBackdropLabel">View Property</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>
          <div class="modal-body">
            <div>
              <form action="">
                  <div class=" mb-4">

                      <div class="row">
                            <input type="hidden" value="'.$property->id.'" name="property_id" required class="form-control" placeholder="Enter Property Address" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">

                          <div class="col-6 mt-3">
                              <div class=" input-group-md">
                                  <label for="">Property Address *</label>
                                  <input readonly type="text" value="'.$property->property_addres.'" name="property_addres" required class="form-control" placeholder="Enter Property Address" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6 mt-3">
                              <div class=" input-group-md ">
                                  <label for="">Address line 2</label>
                                  <input readonly type="text" name="address_line_2" value="'.$property->address_line_2.'"  class="form-control" placeholder="Enter Address line 2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">City *</label>
                                  <input readonly type="text" name="city" value="'.$property->city.'" required class="form-control" placeholder="Enter City" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>


                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">State *</label>
                                  <input readonly type="text" name="state" value="'.$property->state.'" required class="form-control" placeholder="Enter State" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Zip Code *</label>
                                  <input readonly type="text" name="zip_code" value="'.$property->zip_code.'" required class="form-control" placeholder="Enter Zip Code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Closing Date *</label>
                                  <input readonly type="date" name="closing_date" value="'.$date.'" required class="form-control" placeholder="Enter Zip Code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-12">
                              <div class="input-group-md mt-3" >
                                  <label for="">Property Description *</label><br>
                                  <div>
                                  <textarea readonly style="width: 100%" required name="property_description"  rows="4" cols="80" maxlength="200">'.$property->property_description.'</textarea>
                                  </div>
                              </div>
                          </div>

                          <br>


                      </div>

                      <div class="row mt-1">
                      <label for=""> Photoes</label>
                        <div class="col-12">';

                        foreach($photoes as $data)
                        {
                            $html .= '<img src="'.asset(''.$data->photo.'').'" alt="" height="100" width="100" class="mr-2">';
                        }

                        $html .='</div>
                      </div>




                      <div class="row mt-1">
                      <label for=""> Documnet</label>
                        <div class="col-12">';

                        foreach($documents as $data)
                        {
                            $html .= '<img src="'.asset(''.$data->document.'').'" alt="" height="100" width="100" class="mr-2">';
                        }

                        $html .='</div>
                      </div>




                      <div class="row">
                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Asking Price *</label>
                                  <input readonly type="text" name="asking_price" value="'.$property->asking_price.'" required class="form-control" placeholder="Enter Asking Price" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">ARV *</label>
                                  <input readonly type="text" name="arv" value="'.$property->arv.'" required class="form-control" placeholder="Enter ARV " aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Rehab Estimate *</label>
                                  <input readonly type="text" name="rehab_estimate" value="'.$property->rehab_estimate.'" required class="form-control" placeholder="Enter Rehab Estimate" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Rental Comps *</label>
                                  <input readonly type="text" name="rental_comps" value="'.$property->rental_comps.'" required class="form-control" placeholder="Enter Rental Comps" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Bedrooms *</label>
                                  <input readonly type="number" name="bedrooms" value="'.$property->bedrooms.'" required class="form-control" placeholder="Enter Bedrooms" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Bathrooms *</label>
                                  <input readonly type="number" name="bathrooms" value="'.$property->bathrooms.'" required class="form-control" placeholder="Enter Bathrooms" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Square Footage *</label>
                                  <input readonly type="text" name="square_footage" value="'.$property->square_footage.'" required class="form-control" placeholder="Enter Square Footage" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Year Built *</label>
                                  <input readonly type="number" name="year_built" value="'.$property->year_built.'" required class="form-control" placeholder="Enter Year Built" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Property Type *</label>
                                  <select disabled  required name="property_type" class="form-control ">
                                    '.$options.'
                                  </select>
                                <span id="property-error-msg-update" class="text-danger pl-1"><span>

                              </div>
                          </div>

                          <div class="col-6">
                            <div class="input-group-md mt-3">
                                <label for="">Market *</label>
                                <select disabled  required name="market_id" class="form-control ">
                                    <option selected disabled>Select Market</option>';
                                    foreach ($markets as $market)
                                    {
                                        $selected = '';
                                        if($market->id == $property->market_id )
                                        {
                                            $selected = 'selected';
                                        }
                                        $html .= '<option '.$selected.' value="'. $market->id .'">'. $market->name .'</option>';
                                    }




                                $html .='</select>
                                <span id="market-error-msg-update" class="text-danger pl-1"><span>

                            </div>
                        </div>





                      </div>


                  </div>
                 </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>

          </div>
        </div>
      </div>


        ';

        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $property = Property::where('id', $id)->first();
        $date = date('Y-m-d', strtotime($property->closing_date));

        $photoes = Photo::where('property_id', $id)->get();
        $documents = Document::where('property_id', $id)->get();
        $markets = Market::all();

        if($property->property_type == 'Single-family')
        {
            $options = '
            <option  disabled>Select Property</option>
            <option  selected value="Single-family">Single-family</option>
            <option value="Multi-family">Multi-family</option>
            <option value="Commercial">Commercial</option>
            <option value="Industrial">Industrial</option>
            ';
        }

        if($property->property_type == 'Multi-family')
        {
            $options = '
            <option  disabled>Select Property</option>
            <option   value="Single-family">Single-family</option>
            <option  selected value="Multi-family">Multi-family</option>
            <option value="Commercial">Commercial</option>
            <option value="Industrial">Industrial</option>
            ';
        }

        if($property->property_type == 'Commercial')
        {
            $options = '
            <option  disabled>Select Property</option>
            <option   value="Single-family">Single-family</option>
            <option   value="Multi-family">Multi-family</option>
            <option selected value="Commercial">Commercial</option>
            <option value="Industrial">Industrial</option>
            ';
        }

        if($property->property_type == 'Industrial')
        {
            $options = '
            <option  disabled>Select Property</option>
            <option   value="Single-family">Single-family</option>
            <option   value="Multi-family">Multi-family</option>
            <option  value="Commercial">Commercial</option>
            <option  selected value="Industrial">Industrial</option>
            ';
        }
        $html = '

        <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="staticBackdropLabel">Update Property</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>
          <div class="modal-body">
            <div>
              <form action="">
                  <div class=" mb-4">

                      <div class="row">
                            <input type="hidden" value="'.$property->id.'" name="property_id" required class="form-control" placeholder="Enter Property Address" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">

                          <div class="col-6 mt-3">
                              <div class=" input-group-md">
                                  <label for="">Property Address *</label>
                                  <input type="text" value="'.$property->property_addres.'" name="property_addres" required class="form-control" placeholder="Enter Property Address" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6 mt-3">
                              <div class=" input-group-md ">
                                  <label for="">Address line 2</label>
                                  <input type="text" name="address_line_2" value="'.$property->address_line_2.'"  class="form-control" placeholder="Enter Address line 2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">City *</label>
                                  <input type="text" name="city" value="'.$property->city.'" required class="form-control" placeholder="Enter City" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>


                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">State *</label>
                                  <input type="text" name="state" value="'.$property->state.'" required class="form-control" placeholder="Enter State" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Zip Code *</label>
                                  <input type="text" name="zip_code" value="'.$property->zip_code.'" required class="form-control" placeholder="Enter Zip Code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Closing Date *</label>
                                  <input type="date" name="closing_date" value="'.$date.'" required class="form-control" placeholder="Enter Zip Code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-12">
                              <div class="input-group-md mt-3" >
                                  <label for="">Property Description *</label><br>
                                  <div>
                                  <textarea style="width: 100%" required name="property_description"  rows="4" cols="80" maxlength="200">'.$property->property_description.'</textarea>
                                  </div>
                              </div>
                          </div>

                          <br>


                      </div>

                      <div class="row mt-1">
                      <label for="">Old Photoes</label>
                        <div class="col-12">';

                        foreach($photoes as $data)
                        {
                            $html .= '<img src="'.asset(''.$data->photo.'').'" alt="" height="100" width="100" class="mr-2">';
                        }

                        $html .='</div>
                      </div>

                      <div class="row">
                          <div class="col-12" id="photoes-box" >
                              <span><b>Photoes</b></span>
                              <div class="d-flex justify-content-end">
                                  <button id="add-photo-btn-edit" class="btn btn-success">+</button>
                              </div>

                              <span id="add-more-photoes-edit">
                                  <div class="custom-file mt-2">
                                      <input  name="photo[]" type="file" class="custom-file-input" id="customFile">
                                      <label class="custom-file-label" for="customFile">Choose Photo</label>
                                  </div>
                              </span>
                          </div>
                      </div>


                      <div class="row mt-1">
                      <label for="">Old Documnet</label>
                        <div class="col-12">';

                        foreach($documents as $data)
                        {
                            $html .= '<img src="'.asset(''.$data->document.'').'" alt="" height="100" width="100" class="mr-2">';
                        }

                        $html .='</div>
                      </div>

                      <div class="row">
                          <div class="col-12" id="document-box" >
                              <span><b>Documnet</b></span>
                              <div class="d-flex justify-content-end">
                                  <button id="add-document-btn-edit" class="btn btn-success">+</button>
                              </div>

                              <span id="add-more-document-edit">
                                  <div class="custom-file mt-2">
                                      <input name="document[]" type="file" class="custom-file-input" id="customFile" >
                                      <label class="custom-file-label" for="customFile">Choose Document</label>
                                  </div>
                              </span>
                          </div>
                      </div>


                      <div class="row">
                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Asking Price *</label>
                                  <input type="text" name="asking_price" value="'.$property->asking_price.'" required class="form-control" placeholder="Enter Asking Price" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">ARV *</label>
                                  <input type="text" name="arv" value="'.$property->arv.'" required class="form-control" placeholder="Enter ARV " aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Rehab Estimate *</label>
                                  <input type="text" name="rehab_estimate" value="'.$property->rehab_estimate.'" required class="form-control" placeholder="Enter Rehab Estimate" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Rental Comps *</label>
                                  <input type="text" name="rental_comps" value="'.$property->rental_comps.'" required class="form-control" placeholder="Enter Rental Comps" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Bedrooms *</label>
                                  <input type="number" name="bedrooms" value="'.$property->bedrooms.'" required class="form-control" placeholder="Enter Bedrooms" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Bathrooms *</label>
                                  <input type="number" name="bathrooms" value="'.$property->bathrooms.'" required class="form-control" placeholder="Enter Bathrooms" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Square Footage *</label>
                                  <input type="text" name="square_footage" value="'.$property->square_footage.'" required class="form-control" placeholder="Enter Square Footage" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Year Built *</label>
                                  <input type="number" name="year_built" value="'.$property->year_built.'" required class="form-control" placeholder="Enter Year Built" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                          </div>

                          <div class="col-6">
                              <div class="input-group-md mt-3">
                                  <label for="">Property Type *</label>
                                  <select required name="property_type" class="form-control form-select">
                                    '.$options.'
                                  </select>
                                <span id="property-error-msg-update" class="text-danger pl-1"><span>

                              </div>
                          </div>

                          <div class="col-6">
                            <div class="input-group-md mt-3">
                                <label for="">Market *</label>
                                <select required name="market_id" class="form-control form-select">
                                    <option selected disabled>Select Market</option>';
                                    foreach ($markets as $market)
                                    {
                                        $selected = '';
                                        if($market->id == $property->market_id )
                                        {
                                            $selected = 'selected';
                                        }
                                        $html .= '<option '.$selected.' value="'. $market->id .'">'. $market->name .'</option>';
                                    }




                                $html .='</select>
                                <span id="market-error-msg-update" class="text-danger pl-1"><span>

                            </div>
                        </div>





                      </div>


                  </div>
                 </form>
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
    public function destroy($id)
    {
        $Property = Property::where('id', $id)->delete();
        return true;
    }
}
