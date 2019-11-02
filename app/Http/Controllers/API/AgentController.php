<?php

namespace App\Http\Controllers\API;

use App\Contract;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Events\ContractPublished;
use App\Agent;
use App\Project;
use App\Tier;
use App\Classes;
use App\Status;
use App\Events\AgentPublished;
use App\Events\AgentRemoved;
use App\Events\AgentUpdated;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AgentController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
            return Agent::with('projects:project_id,project_name')->latest()->paginate(5);
        }
    }

    public function getAllAgents()
    {
        // $this->authorize('isAdmin');
        if (\Gate::allows('isAdmin') || \Gate::allows('isUser')) {
            return Agent::with('projects:project_id,project_name')->get();
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

        $agent = new Agent();
        $agent->agent_name = $request->agent_name;
        $agent->agent_website = $request->agent_website;
        $agent->agent_main_contact_name = $request->agent_main_contact_name;
        $agent->agent_moto = $request->agent_moto;
        $agent->agent_business = $request->agent_business;
        $tierId = $request->agent_tier;
        $classId = $request->agent_class;
        $statusId = $request->agent_status;
        $agent->agent_contact_info = $request->agent_contact_info;
        $projectId = $request->agent_project;

        // $data = [
        //     'image' => '',
        // ];
        try {
            //dd($request->project);
            // dd($projectId);
            $agent->save();

            $project = Project::find($projectId);
            //dd($project);
            // $tier = Tier::find($tierId);
            // $class = Classes::find($classId);
            // $status = Status::find($statusId);
            $agent->projects()->save($project);
            $project->save();
            //dd($project);

        }
        // catch(Exception $e) catch any exception
        catch (ModelNotFoundException $e) { }
        $tiers = Tier::select('tier_name')->where('id', $tierId)->get('tier_name');
        foreach ($tiers as $tier) {
            $tierName = $tier->tier_name;
        }
        $classes = Classes::select('class_name')->where('id', $classId)->get();
        foreach ($classes as $class) {
            $className = $class->class_name;
        }
        $statuss = Status::select('status_name')->where('id', $statusId)->get();

        foreach ($statuss as $status) {
            $statusName = $status->status_name;
        }
        $agent->tier = $tierName;
        $agent->class = $className;
        $agent->status = $statusName;



        $agent->save();
        event(new AgentPublished($agent));
        //dd($agent);

        return ['message' => 'success'];
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $agent = Agent::findOrFail($request->id);
        $agent->agent_name = $request->agent_name;
        $agent->agent_website = $request->agent_website;
        $agent->agent_main_contact_name = $request->agent_main_contact_name;
        $agent->agent_moto = $request->agent_moto;
        $agent->agent_business = $request->agent_business;
        $tierId = $request->agent_tier;
        $classId = $request->agent_class;
        $statusId = $request->agent_status;
        $agent->agent_contact_info = $request->agent_contact_info;
        $projectId = $request->agent_project;

        // $data = [
        //     'image' => '',
        // ];
        try {
            //dd($request->project);
            // dd($projectId);
            $agent->save();

            $project = Project::find($projectId);
            //dd($project);
            // $tier = Tier::find($tierId);
            // $class = Classes::find($classId);
            // $status = Status::find($statusId);
            $project->save();

            $agent->projects()->attach($project);
            if (! $agent->projects->contains($project->id)) {
                $agent->projects()->attach($project);
                $project->save();

            }
            //dd($project);


        }
        // catch(Exception $e) catch any exception
        catch (ModelNotFoundException $e) { }
        $tiers = Tier::select('tier_name')->where('id', $tierId)->get('tier_name');
        foreach ($tiers as $tier) {
            $tierName = $tier->tier_name;
        }
        $classes = Classes::select('class_name')->where('id', $classId)->get();
        foreach ($classes as $class) {
            $className = $class->class_name;
        }
        $statuss = Status::select('status_name')->where('id', $statusId)->get();

        foreach ($statuss as $status) {
            $statusName = $status->status_name;
        }

        $agent->tier = $tierName;
        $agent->class = $className;
        $agent->status = $statusName;


        event(new AgentUpdated($agent));

        $agent->save();
        //dd($agent);
    }

    public function addProject(Request $request)
    {
        // return ['messageeee' => $request->id];
        $projectId = $request->agent_project;
        $agentId = $request->id;
        // $data = [
        //     'image'   => '',
        // ];
        try {
            // dd($request->project);
            // dd($projectId);
            $agent = Agent::find($agentId);
            $agent->save();

            $project = Project::find($projectId);
            $project->save();
            // dd($project);
            // $tier = Tier::find($tierId);
            // $class = Classes::find($classId);
            // $status = Status::find($statusId);
            // $agent->projects()->attach($project);
            if (! $agent->projects->contains($project->id)) {
                $agent->projects()->attach($project);
            }
            $project->save();

            //dd($project);


        }
        // catch(Exception $e) catch any exception
        catch (ModelNotFoundException $e) { }


        event(new AgentUpdated($agent));

        $agent->save();
        //dd($agent);

        session()->flash('Success', 'Agent Added Successfully');

        return back();
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

        $agent = Agent::findOrFail($id);
        // delete the contract
        event(new AgentRemoved($agent));

        $agent->delete();

        return ['message' => 'Agent Deleted'];
    }

    public function search()
    {

        if ($search = \Request::get('q')) {
            $agents = Agent::where(function ($query) use ($search) {
                $query->where('agent_name', 'LIKE', "%$search%");
            })->paginate(20);
        } else {
            $agents = Agent::latest()->paginate(5);
        }

        return $agents;
    }
}
