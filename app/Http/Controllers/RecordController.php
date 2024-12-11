<?php
// MARK: e add github
namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Partners_Information;
use App\Models\Participants;
use App\Models\Intervention_Assessment;
use App\Models\Proposed_Intervention;

use App\Models\Need_Assessment_Analysis;
use App\Models\Training_Design_Implementation;
use App\Models\Number_Facilitators;
use App\Models\Conduct_Orientation;
use App\Models\Coordination_Materials;
use App\Models\Secretariat;
use App\Models\Id;
use App\Models\Parents_Consent;
use App\Models\Designing_Poster;
use App\Models\Tshirt_Printing;
use App\Models\Banner_Printing;
use App\Models\Coordination_Venue;
use App\Models\Coordination_Participants;
use App\Models\Coordination_Food;
use App\Models\Coordination_Speakers;
use App\Models\Supporting_Docs;
use App\Models\Insurance;
use App\Models\Venue_Recce;
use App\Models\Documentation;
use App\Models\Video_Teaser;

use App\Models\People_Involve;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RecordController extends Controller
{
    public function records()
    {
        if (Auth::check()) {
            $records = Partners_Information::with([
                'participants',
                'intervention',
                'proposed_intervention',
                'people_involve'
            ])->get();

            return view('records', compact('records'));
        }

        return redirect(route('login'));
    }
}
