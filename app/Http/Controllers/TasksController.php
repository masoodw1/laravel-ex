<?php
namespace App\Http\Controllers;

use Gate;
use Carbon;
use Datatables;
use App\Models\Task;
use App\Field;
use App\Field_attribute;
use App\Http\Requests;
use App\Models\Integration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Repositories\Task\TaskRepositoryContract;
use App\Repositories\User\UserRepositoryContract;
use App\Repositories\Client\ClientRepositoryContract;
use App\Repositories\Setting\SettingRepositoryContract;
use App\Repositories\Invoice\InvoiceRepositoryContract;
use App\Status_code;
class TasksController extends Controller
{

    protected $request;
    protected $tasks;
    protected $clients;
    protected $settings;
    protected $users;
    protected $invoices;

    public function __construct(
        TaskRepositoryContract $tasks,
        UserRepositoryContract $users,
        ClientRepositoryContract $clients,
        InvoiceRepositoryContract $invoices,
        SettingRepositoryContract $settings
    )
    {
        $this->tasks = $tasks;
        $this->users = $users;
        $this->clients = $clients;
        $this->invoices = $invoices;
        $this->settings = $settings;

        $this->middleware('task.create', ['only' => ['create']]);
        $this->middleware('task.update.status', ['only' => ['updateStatus']]);
        $this->middleware('task.assigned', ['only' => ['updateAssign', 'updateTime']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('tasks.index');
    }

    public function anyData()
    {
        $tasks = Task::select(
            ['id', 'title', 'created_at', 'deadline', 'user_assigned_id']
        )
            ->where('status', 1)->get();
        return Datatables::of($tasks)
            ->addColumn('titlelink', function ($tasks) {
                return '<a href="tasks/' . $tasks->id . '" ">' . $tasks->title . '</a>';
            })
            ->editColumn('created_at', function ($tasks) {
                return $tasks->created_at ? with(new Carbon($tasks->created_at))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('deadline', function ($tasks) {
                return $tasks->created_at ? with(new Carbon($tasks->deadline))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('user_assigned_id', function ($tasks) {
                return $tasks->user->name;
            })->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create()
    {
        return view('tasks.create')
            ->withUsers($this->users->getAllUsersWithDepartments())
            ->withClients($this->clients->listAllClients());
    }

    /**
     * @param StoreTaskRequest $request
     * @return mixed
     */
    public function store(StoreTaskRequest $request) // uses __contrust request
    {
        $getInsertedId = $this->tasks->create($request);
        return redirect()->route("tasks.show", $getInsertedId);
    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function show(Request $request, $id)
    {
        $caseFields = $this->tasks->find($id)->caseFields;
        $orderedCaseFields = array();
        $status_codes = Status_code::find(1);


        foreach ($caseFields as $caseField) {
            // foreach($casefield as $key => $val){
            //     if($key === 'status' ){
                        
            //     }
            //     $cf[$key] = 
            // }
            
            $orderedCaseFields[$caseField->type]['data'][] = $caseField;
            $orderedCaseFields[$caseField->type]['type'] = Field::find($caseField->id)->fieldAttribute->first()->name;
            
        }
        

        
            $thisUserRole = \Auth::user()->roles[0]['id'];

            //--------------------------------------
            //code to be rewritten as eloquent model
            $allowedDepartments = DB::table('role_user')
            ->join('department_user', 'department_user.user_id', '=', 'role_user.user_id')
            ->join('allowed_assign', 'department_user.department_id', '=', 'allowed_assign.allowed_department')
            ->select('role_user.user_id AS user_id', 'department_user.department_id AS department_id', 'role_user.role_id AS role_id', 'allowed_assign.allowed_department AS allowed_department')
            ->where('allowed_assign.role_id', '=', $thisUserRole)
            ->get();
            //code to be rewritten as eloquent model
            $allowedRoles = DB::table('role_user')
            ->join('department_user', 'department_user.user_id', '=', 'role_user.user_id')
            ->join('allowed_assign', 'role_user.role_id', '=', 'allowed_assign.allowed_role')
            ->select('role_user.user_id AS user_id', 'department_user.department_id AS department_id', 'role_user.role_id AS role_id', 'allowed_assign.allowed_role AS allowed_role')
            ->where('allowed_assign.role_id', '=', $thisUserRole)
            ->get();
            //---------------------------------------


            $allUsers = $this->users->getAllUsersWithDepartments();
            if($allowedRoles->count() > 0){
                foreach($allowedRoles as $allowedRole){
                    $allowedRoleUsers[$allowedRole->user_id] = $allUsers[$allowedRole->user_id];    
                    }
                
                $filterRole = $allowedRoleUsers;
            }
            else{
                $filterRole = $allUsers->toArray();
            }
            // print_r($users->toArray()); exit;

            if($allowedDepartments->count() > 0){
                foreach($allowedDepartments as $allowedDepartment){
                    // if($allowedDepartment->user_id === $allowedRole->user_id){
                
                    // }
                    $allowedDepartmentUsers[$allowedDepartment->user_id] = $allUsers[$allowedDepartment->user_id];
                        $filter = array_intersect_key($filterRole,$allowedDepartmentUsers);
                        
                }
            
            }
            else{
                $filter = $filterRole;
            }

            // dd($filter);
            
            // print_r($allUsers); echo '<hr><br>';
            // print_r(json_decode(json_encode($allowedRoles->toArray())), true); echo '<hr><br>';exit;
            // print_r($allowedDepartments->toArray()); echo '<hr><br>';
            // $intersect = array_diff_key(array_column((array)$allowedRoles->toArray(), 'user_id'), array_column((array)$allowedDepartments->toArray(), 'user_id'));
            // dd($intersect);
            // exit;
            
            
            
        return view('tasks.show')
            ->withTasks($this->tasks->find($id))
            ->withUsers($filter)
            ->withInvoiceLines($this->tasks->getInvoiceLines($id))
            ->withCompanyname($this->settings->getCompanyName())
            ->withCase_fields($orderedCaseFields)
            ->withField_types(Field_attribute::all());
    }


    /**
     * Sees if the Settings from backend allows all to complete taks
     * or only assigned user. if only assigned user:
     * @param $id
     * @param Request $request
     * @return
     * @internal param $ [Auth]  $id Checks Logged in users id
     * @internal param $ [Model] $task->user_assigned_id Checks the id of the user assigned to the task
     * If Auth and user_id allow complete else redirect back if all allowed excute
     * else stmt
     */
    public function updateStatus($id, Request $request)
    {
        $this->tasks->updateStatus($id, $request);
        Session()->flash('flash_message', 'Task is completed');
        return redirect()->back();
    }

    public function updateFieldStatus(Request $request, $id){
        $field = Field::find($request->field_id);
        $field->status = $id;
        $save = $field->save();
        if($save){
            echo '200';
        }
        else{
            echo '500';
        }
        // echo 'sucess fs349';
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function updateAssign($id, Request $request)
    {
        $clientId = $this->tasks->getAssignedClient($id)->id;


        $this->tasks->updateAssign($id, $request);
        Session()->flash('flash_message', 'New user is assigned');
        return redirect()->back();
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function updateTime($id, Request $request)
    {
        $this->tasks->updateTime($id, $request);
        Session()->flash('flash_message', 'Time has been updated');
        return redirect()->back();
    }

    public function addUpdateCase($id, Request $request)
    {
        //++valiate token requests ++//

        // dd($request->all());
        //$list = $request->get();
        // dd($list); exit;
        // echo count($request); exit;
        $inputFields = $request->all();
        // print_r($inputFields); exit;
        foreach($inputFields as $key => $val){
            $dbfieldValue = $key.' : '.$val;
            
        }
        // foreach($request->name as $key => $val){
        //     $dbfieldName = $val;
        // }
        
            // print_r($dbfieldValue);exit;
        $field = new Field;
        $field->type = $request->type;
		// $field->name = $dbfieldName;
        $field->value = $dbfieldValue;
        $field->task_id = $request->task_id;
		$field->save();
        Session()->flash('flash_message', 'New Field has been added');
        return redirect()->back();
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function invoice($id, Request $request)
    {
        $task = Task::findOrFail($id);
        $clientId = $task->client()->first()->id;
        $timeTaskId = $task->time()->get();
        $integrationCheck = Integration::first();

        if ($integrationCheck) {
            $this->tasks->invoice($id, $request);
        }
        $this->invoices->create($clientId, $timeTaskId, $request->all());
        Session()->flash('flash_message', 'Invoice created');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * @return mixed
     * @internal param int $id
     */
    public function marked()
    {
        Notifynder::readAll(\Auth::id());
        return redirect()->back();
    }
}
