<?php

namespace App\Models;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Partners_Information extends Model
{
    use HasFactory;

    protected $table = 'partners_information';
    protected $primaryKey = 'contract_num';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'date_recorded',
        'org_name',
        'category',
        'orghd_name',
        'orghead_designation',
        'orghead_contact',
        'coor_name',
        'coor_desig',
        'coor_contact',
        'client_id',
        'admin_id'
    ];

    // Update the relationship to use 'client_id' on both sides
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'client_id');
    }

    // Other relationships remain the same
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    // Define relationship
    public function participants()
    {
        return $this->hasMany(Participants::class, 'contract_num', 'contract_num');
    }

    public function intervention()
    {
        return $this->hasMany(Intervention_Assessment::class, 'contract_num', 'contract_num');
    }

    public function proposed_intervention()
    {
        return $this->hasMany(Proposed_Intervention::class, 'contract_num', 'contract_num');
    }

    public function people_involve()
    {
        return $this->hasMany(People_Involve::class, 'contract_num', 'contract_num');
    }


    // Define relationship sa Accountabilities
    public function need_assessment_and_analysis()
    {
        return $this->hasMany(Need_Assessment_Analysis::class, 'contract_num', 'contract_num');
    }

    public function training_design()
    {
        return $this->hasMany(Training_Design_Implementation::class, 'contract_num', 'contract_num');
    }

    public function number_of_facilitators()
    {
        return $this->hasMany(Number_Facilitators::class, 'contract_num', 'contract_num');
    }

    public function conduct_of_orientation()
    {
        return $this->hasMany(Conduct_Orientation::class, 'contract_num', 'contract_num');
    }

    public function coor_materials()
    {
        return $this->hasMany(Coordination_Materials::class, 'contract_num', 'contract_num');
    }

    public function secretariat()
    {
        return $this->hasMany(Secretariat::class, 'contract_num', 'contract_num');
    }

    public function id()
    {
        return $this->hasMany(Id::class, 'contract_num', 'contract_num');
    }

    public function parents_consent()
    {
        return $this->hasMany(Parents_Consent::class, 'contract_num', 'contract_num');
    }

    public function designing_of_poster()
    {
        return $this->hasMany(Designing_Poster::class, 'contract_num', 'contract_num');
    }

    public function tshirt_printing()
    {
        return $this->hasMany(Tshirt_Printing::class, 'contract_num', 'contract_num');
    }

    public function banner_printing()
    {
        return $this->hasMany(Banner_Printing::class, 'contract_num', 'contract_num');
    }

    public function coordination_for_venue()
    {
        return $this->hasMany(Coordination_Venue::class, 'contract_num', 'contract_num');
    }

    public function coordination_with_participants()
    {
        return $this->hasMany(Coordination_Participants::class, 'contract_num', 'contract_num');
    }

    public function coordination_with_food()
    {
        return $this->hasMany(Coordination_Food::class, 'contract_num', 'contract_num');
    }

    public function coordination_with_speakers()
    {
        return $this->hasMany(Coordination_Speakers::class, 'contract_num', 'contract_num');
    }

    public function supporting_docs_coordination()
    {
        return $this->hasMany(Supporting_Docs::class, 'contract_num', 'contract_num');
    }

    public function insurance()
    {
        return $this->hasMany(Insurance::class, 'contract_num', 'contract_num');
    }

    public function venue_recce()
    {
        return $this->hasMany(Insurance::class, 'contract_num', 'contract_num');
    }

    public function documentation()
    {
        return $this->hasMany(Documentation::class, 'contract_num', 'contract_num');
    }

    public function video_teaser()
    {
        return $this->hasMany(Video_Teaser::class, 'contract_num', 'contract_num');
    }

}
