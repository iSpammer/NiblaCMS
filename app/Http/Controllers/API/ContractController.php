<?php

namespace App\Http\Controllers\API;

use App\Contract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Events\ContractPublished;
use App\Events\ContractRemoved;
use App\Events\ContractUpdated;

class ContractController extends Controller
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
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            return Contract::latest()->paginate(5);
        }

    }
    public function getAllContracts()
    {
        // $this->authorize('isAdmin');
        if (\Gate::allows('isAdmin') || \Gate::allows('isUser')) {
            return Contract::orderBy('created_at', 'desc')->get();
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

        $this->validate($request, ['contract_name' => 'required', 'contract_start_date' => 'required', 'contract_end_date' => 'required', 'contract_status' => 'required']);



        $contract = new contract();
        $contract->contract_name = $request->contract_name;
        $contract->contract_start_date = $request->contract_start_date;
        $contract->contract_end_date = $request->contract_end_date;
        $contract->contract_status = $request->contract_status;
        $contract->contract_description = $request->contract_description;

        //Save Intance
        $contract->save();
        event(new ContractPublished($contract));
        return ['message'=>'success'];

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

        $contract = Contract::findOrFail($id);

        $this->validate($request, ['contract_name' => 'required', 'contract_start_date' => 'required', 'contract_end_date' => 'required', 'contract_status' => 'required']);

        event(new ContractUpdated($contract));

        $contract->update($request->all());
        return ['message' => 'Updated the user info'];
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
if($id == 0){
    return ['message' => 'Contract Cannot be deleted'];

}
        $contract = Contract::findOrFail($id);
        // delete the contract
        event(new ContractRemoved($contract));

        $contract->delete();

        return ['message' => 'Contract Deleted'];
    }

    public function search(){

        if ($search = \Request::get('q')) {
            $contracts = Contract::where(function($query) use ($search){
                $query->where('contract_name','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $contracts = Contract::latest()->paginate(5);
        }

        return $contracts;

    }
}
