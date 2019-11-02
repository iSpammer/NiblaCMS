<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;
use Laravel\Passport\HasApiTokens;
class Agent extends Model
{
    use  HasApiTokens;

    protected $table = "agent";
    protected $fillable = [
        'agent_name', 'agent_website', 'agent_main_contact_name' ,'agent_moto','agent_business', 'tier', 'class', 'status', 'agent_contact_info', 'agent_image_path','contract'
    ];

    // protected static function boot()
    // {
    //     parent::boot();
    //     //fired whenever a new user is created
    //     static::created(
    //         function ($agent){
    //             $agent->contracts()->create([
    //                 'contract_name' => 'No Contract',
    //             ]
    //         );
    //         //Mail::to($agent->email)->send(new NewUserWelcomeMail());
    //         }
    //     );
    // }
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_agent');
    }

}
