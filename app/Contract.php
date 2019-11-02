<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Agent;
use Laravel\Passport\HasApiTokens;

class Contract extends Model
{

    use HasApiTokens;
    protected $fillable = [
        'contract_name', 'contract_start_date', 'contract_end_date' ,'contract_status','contract_description'];
    protected $table = "contract";
    protected $guarded =[];

    public function project()
    {
        return $this ->belongsTo(Project::class, 'project_id');
    }

}
