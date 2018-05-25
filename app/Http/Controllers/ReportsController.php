<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\Client\ClientRepositoryContract;
use App\Repositories\Task\TaskRepositoryContract;
use App\Field;
use App\Field_attribute;

class ReportsController extends Controller
{

    protected $tasks;

    
    public function __construct(
        TaskRepositoryContract $tasks
    )
    {
        $this->tasks = $tasks;
    }


    public function index()
    {
        return view('reports.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $field_types = Field_attribute::select('id','name')->get();
        $caseFields = $this->tasks->find($id)->caseFields;
        $orderedCaseFields = array();
        foreach ($caseFields as $caseField) {
            $orderedCaseFields[$caseField->type]['data'][] = $caseField;
            $orderedCaseFields[$caseField->type]['type'] = Field::find($caseField->id)->fieldAttribute->first()->name;
            
        }

        // dd($field_types->pluck('name','id'));
        dd($orderedCaseFields);
        return view('reports.show')
        ->withTasks($this->tasks->find($id))
        ->withCase_fields($orderedCaseFields)
        ->withFeld_types($field_types);
    }

  
}
