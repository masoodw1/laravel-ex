<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\Client\ClientRepositoryContract;
use App\Repositories\Task\TaskRepositoryContract;
use App\Field;
use App\Field_attribute;
use App\Models\Client;
use App\Models\Task;
use PDF;
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

       $report = Task::where('tasks.id', $id)->with('client.fieldAttribute.field')->get();
    
        // dd($report->toArray());
        $data = [
            'address' => 'regus” unit no.2201, world trade center, 22nd floor, brigade gateway complex,
            dr.rajkumar raod, malleshwaram (west), bangalore - 560055,
            email : info@everongroup.in, web:
            ph:+918067935702 , fax : +9167935301'
        ];
        // $this->generate_pdf($data);

        // PDF::loadHTML('<h1>Test</h1>')->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf');

//         $pdf = \App::make('dompdf.wrapper');
// $pdf->loadHTML('<h1>Test</h1>');
// return $pdf->stream();
        $pdf = PDF::loadView('reports.pdf', $data);
        return $pdf->stream();

        exit;
            
        return view('reports.show')
        ->withTasks($this->tasks->find($id))
        ->withCase_fields($report)
        ->withFeld_types($field_types);
    }

    function generate_pdf($data) {
        
        // $pdf = PDF::loadView('reports.pdf', $data);
        // return $pdf->stream('document.pdf');
        $pdf = PDF::loadView('reports.pdf', $data);
        return $pdf->download('invoice.pdf');
    }

    
  
}
