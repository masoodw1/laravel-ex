<?php
namespace App\Http\Controllers;

use Session;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Field;
use App\Field_attribute;
use App\Models\role;
class FormattributeController extends Controller
{

    public function formlayout(Request $request){
        
        
        $field_name = Field_attribute::find($request->field_id)->name;
        // print_r($field_name);
        
        $fieldAttribute = Field_attribute::find($request->field_id);

        $fieldAttribute->form_struc = $request->form_data;
        
        print_r($fieldAttribute->save());
        
    }

    public function listfields(){
        $roles = role::select('id', 'name')->get();
        return view('builder.caseform')
        ->withField_types(Field_attribute::all())
        ->withRoles($roles);
    }
}