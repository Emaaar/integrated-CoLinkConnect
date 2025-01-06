<?php

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


use App\Models\Contract_Progress;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

// Set the default timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

class ContractingController extends Controller
{
    public function contracting()
    {
        // Ensure only authenticated users can access the page
        if (Auth::check()) {
            // return view('contracting2'); // Authenticated users should see the contracting page
            // return view('contracting3'); // Authenticated users should see the contracting page
            return view('contracting'); // Authenticated users should see the contracting page
        }
        return redirect(route('login'));
    }

    public function searchClient(Request $request)
    {
        $clientSearch = $request->input('clientSearch');
        $client = User::where('user_email', $clientSearch)->first();

        if ($client) {
            return response()->json(['exists' => true, 'message' => 'You can now continue']);
        } else {
            return response()->json(['exists' => false, 'message' => 'Client does not exist']);
        }
    }

    // public function updateProgress(Request $request, $contractNum)
    // {
    //     $progress = Contract_Progress::where('contract_num', $contractNum)->firstOrFail();

    //     $progress->update([
    //         'is_processing' => $request->input('is_processing', false),
    //         'is_pending' => $request->input('is_pending', false),
    //         'is_done' => $request->input('is_done', false),
    //     ]);

    //     return response()->json(['message' => 'Progress updated successfully']);
    // }




    //MARK: TO DO
    // ipa wooooork
    public function contractingPost(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $validator = Validator::make($request->all(), [

            // MARK: I. Partners Information
            'name_of_the_org' => 'required|string',
            'nature_of_the_org' => 'required|string',
            'head_org_name' => 'required|string',
            'head_org_designation' => 'required|string',

            'head_org_contact' => 'required|regex:/^[9]\d{9}$/',  //Validates 10-digit number starting with 9

            'coor_name' => 'required|string',
            'coor_designation' => 'required|string',

            'coor_contact' => 'required|regex:/^[9]\d{9}$/',


            // MARK: II. Participants
            // 'age' => 'required|numeric|min:0',
            'min_age' => 'required|numeric|min:13|max:50',
                function ($attribute, $value, $fail) {
                    if ($value < 13) {
                        $fail('The minimum age must be at least 13 years old.');
                    }
                },
            'max_age'  => 'required|numeric|min:13|max:50',
                function ($attribute, $value, $fail) {
                    if ($value > 50) {
                        $fail('The maximum age cannot exceed 50 years old.');
                    }
                },

            'gender' => 'required|string',
            'education_status' => 'required|string',
            'leadership_exp' => 'required|string',
            'address' => 'required|string',

            // MARK: III. Intervention Assessment
            'pic_success' => 'required|string',
            'knowledge_gap' => 'required|string',
            'skills_gap' => 'required|string',
            'team_dynamic_gap' => 'required|string',
            'issues_and_concern' => 'required|string',

            // MARK: IV. Proposed Intervention
            'type_intervention' => 'required|string',
            'intervention_venue' => 'required|string',
            // 'intervention_start_date' => [
            //     'required',
            //     'date',
            //     'after_or_equal:today',
            //     function ($attribute, $value, $fail) use ($request) {
            //         $conflictingInterventions = Proposed_Intervention::where(function ($query) use ($value, $request) {
            //             $query->where('startdate', '<=', $request->intervention_end_date)
            //                   ->where('enddate', '>=', $value);
            //         })->count();

            //         if ($conflictingInterventions > 0) {
            //             $fail('The selected date range conflicts with existing interventions.');
            //         }
            //     },
            // ],
            // 'intervention_start_date' => [
            //     'required',
            //     'date',
            //     'after_or_equal:today',
            // ],

            // 'intervention_end_date' => 'required|date|after_or_equal:intervention_start_date',
            'intervention_start_date' => 'required|date|after_or_equal:today',
            'intervention_end_date' => 'required|date|after_or_equal:intervention_start_date',

            'intervention_days' => 'required|numeric|min:1',
            'intervention_duration' => 'required|numeric|min:1|max:8',
            'intervention_objectives' => 'required|string',
            'intervention_output' => 'required|string',

            // MARK: V. Accountabilities (parts 1-4)
            'needs_assessment_cost' => 'nullable|numeric',
            'needs_assessment_partner' => 'nullable|string',
            'needs_assessment_colink' => 'nullable|string',
            'needs_assessment_timeline' => 'nullable|date',

            'training_design_cost' => 'nullable|numeric',
            'training_design_partner' => 'nullable|string',
            'training_design_colink' => 'nullable|string',
            'training_design_timeline' => 'nullable|date',

            'facilitators_cost' => 'nullable|numeric',
            'facilitators_partner' => 'nullable|string',
            'facilitators_colink' => 'nullable|string',
            'facilitators_timeline' => 'nullable|date',

            'conduct_cost' => 'nullable|numeric',
            'conduct_partner' => 'nullable|string',
            'conduct_colink' => 'nullable|string',
            'conduct_timeline' => 'nullable|date',

            'coordination_of_materials_cost' => 'nullable|numeric',
            'coordination_of_materials_partner' => 'nullable|string',
            'coordination_of_materials_colink' => 'nullable|string',
            'coordination_of_materials_timeline' => 'nullable|date',

            //MARK: V part 2
            'secretariat_cost' => 'nullable|numeric',
            'secretariat_partner' => 'nullable|string',
            'secretariat_colink' => 'nullable|string',
            'secretariat_timeline' => 'nullable|date',

            'id_cost' => 'nullable|numeric',
            'id_partner' => 'nullable|string',
            'id_colink' => 'nullable|string',
            'id_timeline' => 'nullable|date',

            'parent_consent_cost' => 'nullable|numeric',
            'parent_consent_partner' => 'nullable|string',
            'parent_consent_colink' => 'nullable|string',
            'parent_consent_timeline' => 'nullable|date',

            'designing_poster_cost' => 'nullable|numeric',
            'designing_poster_partner' => 'nullable|string',
            'designing_poster_colink' => 'nullable|string',
            'designing_poster_timeline' => 'nullable|date',

            'tshirt_printing_cost' => 'nullable|numeric',
            'tshirt_printing_partner' => 'nullable|string',
            'tshirt_printing_colink' => 'nullable|string',
            'tshirt_printing_timeline' => 'nullable|date',

            //MARK: V part 3
            'banner_printing_cost' => 'nullable|numeric',
            'banner_printing_partner' => 'nullable|string',
            'banner_printing_colink' => 'nullable|string',
            'banner_printing_timeline' => 'nullable|date',

            'coordination_for_venue_cost' => 'nullable|numeric',
            'coordination_for_venue_partner' => 'nullable|string',
            'coordination_for_venue_colink' => 'nullable|string',
            'coordination_for_venue_timeline' => 'nullable|date',

            'coordination_for_participants_cost' => 'nullable|numeric',
            'coordination_for_participants_partner' => 'nullable|string',
            'coordination_for_participants_colink' => 'nullable|string',
            'coordination_for_participants_timeline' => 'nullable|date',

            'coordination_food_concession_cost' => 'nullable|numeric',
            'coordination_food_concession_partner' => 'nullable|string',
            'coordination_food_concession_colink' => 'nullable|string',
            'coordination_food_concession_timeline' => 'nullable|date',

            'coordination_with_speakers_cost' => 'nullable|numeric',
            'coordination_with_speakers_partner' => 'nullable|string',
            'coordination_with_speakers_colink' => 'nullable|string',
            'coordination_with_speakers_timeline' => 'nullable|date',

            //MARK: V part 4
            'supporting_coordination_cost' => 'nullable|numeric',
            'supporting_coordination_partner' => 'nullable|string',
            'supporting_coordination_colink' => 'nullable|string',
            'supporting_coordination_timeline' => 'nullable|date',

            'insurance_cost' => 'nullable|numeric',
            'insurance_partner' => 'nullable|string',
            'insurance_colink' => 'nullable|string',
            'insurance_timeline' => 'nullable|date',

            'venue_recce_cost' => 'nullable|numeric',
            'venue_recce_partner' => 'nullable|string',
            'venue_recce_colink' => 'nullable|string',
            'venue_recce_timeline' => 'nullable|date',

            'documentation_cost' => 'nullable|numeric',
            'documentation_partner' => 'nullable|string',
            'documentation_colink' => 'nullable|string',
            'documentation_timeline' => 'nullable|date',

            'video_teaser_cost' => 'nullable|numeric',
            'video_teaser_partner' => 'nullable|string',
            'video_teaser_colink' => 'nullable|string',
            'video_teaser_timeline' => 'nullable|date',

            // MARK: VI. People Involved
            // 'leadfaci' => [
            //     'required',
            //     function ($attribute, $value, $fail) use ($request) {
            //         $this->checkFacilitatorConflict($value, $request->intervention_start_date, $request->intervention_end_date, $fail, 'Lead facilitator');
            //     },
            // ],
            // 'secondfaci' => [
            //     'required',
            //     function ($attribute, $value, $fail) use ($request) {
            //         $this->checkFacilitatorConflict($value, $request->intervention_start_date, $request->intervention_end_date, $fail, 'Second facilitator');
            //     },
            // ],
            // 'thirdfaci' => [
            //     'nullable',
            //     function ($attribute, $value, $fail) use ($request) {
            //         if ($value) {
            //             $this->checkFacilitatorConflict($value, $request->intervention_start_date, $request->intervention_end_date, $fail, 'Third facilitator');
            //         }
            //     },
            // ],

            'lead_faci' => 'required|string',
            'second_faci' => 'required|string',
            'third_faci' => 'nullable|string',

            'sponsor' => 'required|string',
            'vip' => 'required|string',
            'working_com' => 'required|string',
            'observers' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        // Check for 1 week before the day
        $checkStartDate = $this->checkStartDate(
            $request->intervention_start_date
        );

        if ($checkStartDate) {
            return redirect()->back()
            ->withInput()
            ->withErrors(['conflict2' => $checkStartDate])
            ->with('scrollTo', 'intervention_start_date');
        }

        // Check for conflicts
        $conflictMessage = $this->checkConflicts(
            $request->intervention_start_date,
            $request->intervention_end_date,
            $request->lead_faci,
            $request->second_faci,
            $request->third_faci
        );

        if ($conflictMessage) {
            return redirect()->back()
            ->withInput()
            ->withErrors(['conflict1' => $conflictMessage])
            ->with('scrollTo', 'intervention_start_date');
        }

        $daterecorded = Carbon::now();
        DB::beginTransaction();

        try{

            // Get the authenticated user's client_id
            $client_id = Auth::user()->client_id;

            // Prepare and create data for each model
            $partner_information = Partners_Information::create([
                'date_recorded' => $daterecorded,

                'org_name' => $request->name_of_the_org,
                'category' => $request->nature_of_the_org,
                'orghd_name' => $request->head_org_name,
                'orghead_designation' => $request->head_org_designation,

                'orghead_contact' => '+63' . $request->head_org_contact,

                'coor_name' => $request->coor_name,
                'coor_desig' => $request->coor_designation,

                'coor_contact' => '+63' . $request->coor_contact,

                'client_id' => $client_id,
            ]);
            if (!$partner_information) {
                return redirect()->back()->with('error', 'Failed to create partner information.')->withInput();
            }

            $participants = Participants::create([

                'age' => $request->min_age . ' - ' . $request->max_age,


                'gender' => $request->gender,
                'education_status' => $request->education_status,
                'leadership_exp' => $request->leadership_exp,
                'address' => $request->address,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$participants) {
                return redirect()->back()->with('error', 'Failed to create participants.')->withInput();
            }

            $intervention_assessment = Intervention_Assessment::create([
                'pic_success' => $request->pic_success,
                'kgap' => $request->knowledge_gap,
                'sgap' => $request->skills_gap,
                'tdgap' => $request->team_dynamic_gap,
                'issues_concerns' => $request->issues_and_concern,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$intervention_assessment) {
                return redirect()->back()->with('error', 'Failed to create intervention assessment.')->withInput();
            }

            $proposed_intervention = Proposed_Intervention::create([
                'type_intervention' => $request->type_intervention,
                'venue' => $request->intervention_venue,
                'startdate' => $request->intervention_start_date,
                'enddate' => $request->intervention_end_date,
                'days' => $request->intervention_days,
                'duration' => $request->intervention_duration,
                'objectives' => $request->intervention_objectives,
                'output' => $request->intervention_output,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$proposed_intervention) {
                return redirect()->back()->with('error', 'Failed to create proposed intervention.')->withInput();
            }

            // Create records for all accountability tables
            //MARK: V part 1
            $need_assessment_and_analysis = Need_Assessment_Analysis::create([
                'need_assessment_costing' => $request->needs_assessment_cost,
                'need_assessment_partner' => $request->needs_assessment_partner,
                'need_assessment_colinkIC' => $request->needs_assessment_colink,
                'need_assessment_timeline' => $request->needs_assessment_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$need_assessment_and_analysis) {
                return redirect()->back()->with('error', 'Failed to create acountabilities need assessment.')->withInput();
            }

            $trainig_design_and_implementation = Training_Design_Implementation::create([
                'trainig_design_and_implementation_costing' => $request->training_design_cost,
                'trainig_design_and_implementation_partner'=> $request->training_design_partner,
                'trainig_design_and_implementation_colinkIC' => $request->training_design_colink,
                'trainig_design_and_implementation_timeline' => $request->training_design_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$trainig_design_and_implementation) {
                return redirect()->back()->with('error', 'Failed to create acountabilities trainig design and implementation.')->withInput();
            }

            $number_of_facilitators = Number_Facilitators::create([
                'number_of_facilitators_costing'=> $request->facilitators_cost,
                'number_of_facilitators_partner'=> $request->facilitators_partner,
                'number_of_facilitators_colinkIC'=> $request->facilitators_colink,
                'number_of_facilitators_timeline'=> $request->facilitators_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$number_of_facilitators) {
                return redirect()->back()->with('error', 'Failed to create acountabilities number_of_facilitators.')->withInput();
            }

            $conduct_of_orientation = Conduct_Orientation::create([
                'conduct_of_orientation_costing'=> $request->conduct_cost,
                'conduct_of_orientation_partner'=> $request->conduct_partner,
                'conduct_of_orientation_colinkIC'=> $request->conduct_colink,
                'conduct_of_orientation_timeline'=> $request->conduct_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$conduct_of_orientation) {
                return redirect()->back()->with('error', 'Failed to create acountabilities conduct_of_orientation.')->withInput();
            }

            $coordination_of_materials = Coordination_Materials::create([
                'coordination_of_materials_costing'=> $request->coordination_of_materials_cost,
                'coordination_of_materials_partner'=> $request->coordination_of_materials_partner,
                'coordination_of_materials_colinkIC'=> $request->coordination_of_materials_colink,
                'coordination_of_materials_timeline'=> $request->coordination_of_materials_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$coordination_of_materials) {
                return redirect()->back()->with('error', 'Failed to create acountabilities conduct_of_orientation.')->withInput();
            }

            //MARK: V part 2
            $secretariat = Secretariat::create([
                'secretariat_costing'=> $request->secretariat_cost,
                'secretariat_partner'=> $request->secretariat_partner,
                'secretariat_colinkIC'=> $request->secretariat_colink,
                'secretariat_timeline'=> $request->secretariat_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$secretariat) {
                return redirect()->back()->with('error', 'Failed to create acountabilities secretariat.')->withInput();
            }

            $id = Id::create([
                'id_costing'=> $request->id_cost,
                'id_partner'=> $request->id_partner,
                'id_colinkIC'=> $request->id_colink,
                'id_timeline'=> $request->id_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$id) {
                return redirect()->back()->with('error', 'Failed to create acountabilities id.')->withInput();
            }

            $parents_consent = Parents_Consent::create([
                'parents_consent_costing'=> $request->parent_consent_cost,
                'parents_consent_partner'=> $request->parent_consent_partner,
                'parents_consent_colinkIC'=> $request->parent_consent_colink,
                'parents_consent_timeline'=> $request->parent_consent_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$parents_consent) {
                return redirect()->back()->with('error', 'Failed to create acountabilities parents_consent.')->withInput();
            }

            $designing_of_poster = Designing_Poster::create([
                'designing_of_poster_costing'=> $request->designing_poster_cost,
                'designing_of_poster_partner'=> $request->designing_poster_partner,
                'designing_of_poster_colinkIC'=> $request->designing_poster_colink,
                'designing_of_poster_timeline'=> $request->designing_poster_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$designing_of_poster) {
                return redirect()->back()->with('error', 'Failed to create acountabilities designing_of_poster.')->withInput();
            }

            $tshirt_printing = Tshirt_Printing::create([
                'tshirt_printing_costing'=> $request->tshirt_printing_cost,
                'tshirt_printing_partner'=> $request->tshirt_printing_partner,
                'tshirt_printing_colinkIC'=> $request->tshirt_printing_colink,
                'tshirt_printing_timeline'=> $request->tshirt_printing_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$tshirt_printing) {
                return redirect()->back()->with('error', 'Failed to create acountabilities tshirt_printing.')->withInput();
            }

            //MARK: V part 3
            $banner_printing = Banner_Printing::create([
                'banner_printing_costing'=> $request->banner_printing_cost,
                'banner_printing_partner'=> $request->banner_printing_partner,
                'banner_printing_colinkIC'=> $request->banner_printing_colink,
                'banner_printing_timeline'=> $request->banner_printing_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$banner_printing) {
                return redirect()->back()->with('error', 'Failed to create acountabilities banner_printing.')->withInput();
            }

            $coordination_for_venue = Coordination_Venue::create([
                'coordination_for_venue_costing'=> $request->coordination_for_venue_cost,
                'coordination_for_venue_partner'=> $request->coordination_for_venue_partner,
                'coordination_for_venue_colinkIC'=> $request->coordination_for_venue_colink,
                'coordination_for_venue_timeline'=> $request->coordination_for_venue_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$coordination_for_venue) {
                return redirect()->back()->with('error', 'Failed to create acountabilities coordination_for_venue.')->withInput();
            }

            $coordination_with_participants = Coordination_Participants::create([
                'coordination_with_participants_costing'=> $request->coordination_for_participants_cost,
                'coordination_with_participants_partner'=> $request->coordination_for_participants_partner,
                'coordination_with_participants_colinkIC'=> $request->coordination_for_participants_colink,
                'coordination_with_participants_timeline'=> $request->coordination_for_participants_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$coordination_with_participants) {
                return redirect()->back()->with('error', 'Failed to create acountabilities coordination_with_participants.')->withInput();
            }

            $coordination_with_food = Coordination_Food::create([
                'coordination_with_food_costing'=> $request->coordination_food_concession_cost,
                'coordination_with_food_partner'=> $request->coordination_food_concession_partner,
                'coordination_with_food_colinkIC'=> $request->coordination_food_concession_colink,
                'coordination_with_food_timeline'=> $request->coordination_food_concession_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$coordination_with_food) {
                return redirect()->back()->with('error', 'Failed to create acountabilities coordination_with_food.')->withInput();
            }

            $coordination_with_speakers = Coordination_Speakers::create([
                'coordination_with_speakers_costing'=> $request->coordination_with_speakers_cost,
                'coordination_with_speakers_partner'=> $request->coordination_with_speakers_partner,
                'coordination_with_speakers_colinkIC'=> $request->coordination_with_speakers_colink,
                'coordination_with_speakers_timeline'=> $request->coordination_with_speakers_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$coordination_with_speakers) {
                return redirect()->back()->with('error', 'Failed to create acountabilities coordination_with_speakers.')->withInput();
            }


            //MARK: V part 4
            $supporting_docs_coordination = Supporting_Docs::create([
                'supporting_docs_coordination_costing'=> $request->supporting_coordination_cost,
                'supporting_docs_coordination_partner'=> $request->supporting_coordination_partner,
                'supporting_docs_coordination_colinkIC'=> $request->supporting_coordination_colink,
                'supporting_docs_coordination_timeline'=> $request->supporting_coordination_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$supporting_docs_coordination) {
                return redirect()->back()->with('error', 'Failed to create acountabilities supporting_docs_coordination.')->withInput();
            }

            $insurance = Insurance::create([
                'insurance_costing'=> $request->insurance_cost,
                'insurance_partner'=> $request->insurance_partner,
                'insurance_colinkIC'=> $request->insurance_colink,
                'insurance_timeline'=> $request->insurance_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$insurance) {
                return redirect()->back()->with('error', 'Failed to create acountabilities insurance.')->withInput();
            }

            $venue_recce = Venue_Recce::create([
                'venue_recce_costing'=> $request->venue_recce_cost,
                'venue_recce_partner'=> $request->venue_recce_partner,
                'venue_recce_colinkIC'=> $request->venue_recce_colink,
                'venue_recce_timeline'=> $request->venue_recce_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$venue_recce) {
                return redirect()->back()->with('error', 'Failed to create acountabilities venue_recce.')->withInput();
            }

            $documentation = Documentation::create([
                'documentation_costing'=> $request->documentation_cost,
                'documentation_partner'=> $request->documentation_partner,
                'documentation_colinkIC'=> $request->documentation_colink,
                'documentation_timeline'=> $request->documentation_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$documentation) {
                return redirect()->back()->with('error', 'Failed to create acountabilities documentation.')->withInput();
            }

            $video_teaser = Video_Teaser::create([
                'video_teaser_costing'=> $request->video_teaser_cost,
                'video_teaser_partner'=> $request->video_teaser_partner,
                'video_teaser_colinkIC'=> $request->video_teaser_colink,
                'video_teaser_timeline'=> $request->video_teaser_timeline,
                'contract_num' => $partner_information->contract_num,
            ]);
            if (!$video_teaser) {
                return redirect()->back()->with('error', 'Failed to create acountabilities video_teaser.')->withInput();
            }

            // MARK: VI. People Involved
            $people_involve = People_Involve::create([
                'leadfaci' => $request->lead_faci,
                'secondfaci' => $request->second_faci,
                'thirdfaci' => $request->third_faci,
                'sponsor' => $request->sponsor,
                'vip' => $request->vip,
                'working_com' => $request->working_com,
                'observers' => $request->observers,
                'contract_num' => $partner_information->contract_num,
            ]);

            if (!$people_involve) {
                return redirect()->back()->with('error', 'Failed to create people involve.')->withInput();
            }

            // Create a new Contract_Progress record
            $contract_progress = Contract_Progress::create([
                'contract_num' => $partner_information->contract_num,
                'is_processing' => true,
                'is_pending' => false,
                'is_done' => false,
            ]);

            if (!$contract_progress) {
                throw new \Exception('Failed to create contract progress.');
            }

            DB::commit();
            return redirect()->route('contracting')->with('success', 'Contract successfully created for ' . $request->name_of_the_org);

            // return response()->json(['success' => true, 'message' => 'Contract successfully created.']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Contract creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while saving the data. Please try again. Error: ' . $e->getMessage())
                ->withInput();
        }

    }

    private function checkConflicts($startDate, $endDate, $leadFaci, $secondFaci, $thirdFaci)
    {
        // Get all interventions in the date range
        $interventionsInRange = Proposed_Intervention::where(function ($query) use ($startDate, $endDate) {
            $query->where('startdate', '<=', $endDate)
                  ->where('enddate', '>=', $startDate);
        })->with('peopleInvolve')->get();

        // Check each intervention for facilitator conflicts
        foreach ($interventionsInRange as $intervention) {
            if (!$intervention->peopleInvolve) {
                continue;
            }

            $existingFacilitators = [
                $intervention->peopleInvolve->leadfaci,
                $intervention->peopleInvolve->secondfaci,
                $intervention->peopleInvolve->thirdfaci
            ];

            $newFacilitators = [$leadFaci, $secondFaci, $thirdFaci];

            // Check if there's any overlap between the facilitators
            $hasConflict = array_intersect($existingFacilitators, $newFacilitators);

            if (!empty($hasConflict)) {
                return "One or more selected facilitators are already assigned on the chosen dates. Please change the date range or select different facilitators.";
            }
        }

        return null; // No conflicts found
    }

    private function checkStartDate($startDate)
    {
        // Set the timezone to Asia/Manila
        $timezone = new \DateTimeZone('Asia/Manila');

        // Get today's date in Manila timezone
        $today = Carbon::now($timezone)->startOfDay();

        // Parse the start date and set it to Manila timezone
        $startDate = Carbon::parse($startDate, $timezone)->startOfDay();

        // Calculate the difference in days
        $daysDifference = $today->diffInDays($startDate, false);

        // Check if the start date is at least 7 days in the future
        if ($daysDifference < 7) {
            return "We need at least 7 days to prepare. Please change the start date in the Proposed Intervention.";
        }

        return null;
    }

    // public function records()
    // {
    //     // Ensure only authenticated users can access the page
    //     if (Auth::check()) {
    //         return view('records'); // Authenticated users should see the contracting page
    //     }

    //     // Optional: Redirect unauthenticated users to login or another page
    //     return redirect(route('login'));
    // }
    // public function messages()
    // {
    //     // Ensure only authenticated users can access the page
    //     if (Auth::check()) {
    //         return view('records'); // Authenticated users should see the contracting page
    //     }

    //     // Optional: Redirect unauthenticated users to login or another page
    //     return redirect(route('login'));
    // }

    public function blog()
    {
        // Ensure only authenticated users can access the page
        if (Auth::check()) {
            return view('blog'); // Authenticated users should see the contracting page
        }

        // Optional: Redirect unauthenticated users to login or another page
        return redirect(route('login'));
    }
}