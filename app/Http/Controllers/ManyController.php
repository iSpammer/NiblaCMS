<?php

namespace App\Http\Controllers;

use App\Project;
use App\Agent;
use Illuminate\Http\Request;

class ManyController extends Controller
{
    public function manyRoles()
    {

        $agent = Agent::findOrFail(1);
        $project = Project::findOrFail(1);

        return view('index',compact('agent','project'));

    }
}
