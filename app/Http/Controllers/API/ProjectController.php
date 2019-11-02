<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\ProjectPublished;
use App\Events\ProjectUpdated;
use App\Events\ProjectRemoved;
use App\Project;
use App\Contract;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }


        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->authorize('isAdmin');
        if (\Gate::allows('isAdmin') || \Gate::allows('isUser')) {
            return Project::with('contracts')->with('agents:agent_id,agent_name')->with('users:user_id,user_name')->latest()->paginate(5);
        }
    }


    public function getAllProjects()
    {
        // $this->authorize('isAdmin');
        if (\Gate::allows('isAdmin') || \Gate::allows('isUser')) {
            return Project::get();
       }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->contract);
        // $this->validate($request, ['projectName' => 'required', 'projectBusiness' => 'required', 'status' => 'required']);

        $project = new Project();
        $project->project_name = $request->project_name;
        $project->project_priority = $request->project_priority;
        $project->project_final_deadline = $request->project_final_deadline;
        $project->project_start_date = $request->project_start_date;
        $project->project_current_milestone = $request->project_current_milestone;
        $project->project_cmp_level = $request->project_cmp_level;
        $project->project_status = $request->project_status;
        $project->project_description = $request->project_description;
        $contractId = $request->project_contract;

        //sreturn ['messageee' => $request->project_contract];
        // $data = [
        //     'image' => '',
        // ];
        try { //bb2 el 5al2 syda zenab modryt amn kahra share3 7asan b2alt els3ydy bared shr3 7san b2alt el s3ydy 3omra door 3 dr safwat
            //mdam aml 3yza tsl 3alek amal mohamed 7elmy
            //  s3at 3arys w23t mn el 3rbya mostafa vabo 3lm embaba
            //dd($request->contractId);
            // dd($contractId);
            $project->save();

            $contract = Contract::find($contractId);
            //  dd($contract);
            //dd($contract);
            // $tier = Tier::find($tierId);
            // $class = Classes::find($classId);
            // $status = Status::find($statusId);
            $project->contracts()->save($contract);

            //dd($contract);


        }
        // catch(Exception $e) catch any exception
        catch (ModelNotFoundException $e) { }


        $project->save();
        //dd($project);

        event(new ProjectPublished($project));
        //dd($agent);

        return ['message' => 'success'];
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // $this->validate($request, ['projectName' => 'required', 'projectBusiness' => 'required', 'status' => 'required']);

        $project = project::findOrFail($request->id);
        $project->project_name = $request->project_name;
        $project->project_priority = $request->project_priority;
        $project->project_final_deadline = $request->project_final_deadline;
        $project->project_start_date = $request->project_start_date;
        $project->project_current_milestone = $request->project_current_milestone;
        $project->project_cmp_level = $request->project_cmp_level;
        $project->project_sprint_number = $request->project_sprint_numbers;
        $project->project_status = $request->project_status;
        $project->project_description = $request->project_description;
        $contractId = $request->project_contract;


        // $data = [
        //     'image' => '',
        // ];
        try {
            //dd($request->contract);
            // dd($contractId);
            $project->save();
            // $currContractId = $project->contracts->id;
            $project->contracts->project_id = 0;
            $contract = Contract::find($contractId);
            $contract->project_id = $project->id;
            //dd($contract);
            // $tier = Tier::find($tierId);
            // $class = Classes::find($classId);
            // $status = Status::find($statusId);
            $project->contracts()->save($contract);
            $contract->save();
            //dd($contract);


        }
        // catch(Exception $e) catch any exception
        catch (ModelNotFoundException $e) { }

        // $statuss = Status::select('status_name')->where('id', $request->project_status)->get();

        // foreach ($statuss as $status) {
        //     $statusName = $status->status_name;
        // }


        // $project->status = $statusName;



        $project->save();
        //dd($project);
        event(new ProjectUpdated($project));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('isAdmin');

        $project = Project::findOrFail($id);
        // delete the contract
        event(new ProjectRemoved($project));

        $project->delete();

        return ['message' => 'Project Deleted'];
    }

    public function search()
    {

        if ($search = \Request::get('q')) {
            $projects = Project::where(function ($query) use ($search) {
                $query->where('agent_name', 'LIKE', "%$search%");
            })->paginate(20);
        } else {
            $projects = Project::latest()->paginate(5);
        }

        return $projects;
    }
}
