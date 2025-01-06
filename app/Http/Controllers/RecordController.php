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
use App\Models\StatusChange;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use League\CommonMark\Node\Block\Document;

use Carbon\Carbon;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class RecordController extends Controller
{
    public function records()
    {
        if (Auth::check()) {
            $records = Partners_Information::with([
                'participants',
                'intervention',
                'proposed_intervention',
                'people_involve',
                'progress',
            ])->get();

            return view('records', compact('records'));
        }

        return redirect(route('login'));
    }

    // MARK: DELETE
    public function destroy($contractNum)
    {
        try {
            DB::beginTransaction();

            $record = Partners_Information::where('contract_num', $contractNum)->first();

            if (!$record) {
                throw new \Exception("Record not found for contract number: $contractNum");
            }

            // Delete related records
            Participants::where('contract_num', $contractNum)->delete();
            Intervention_Assessment::where('contract_num', $contractNum)->delete();
            Proposed_Intervention::where('contract_num', $contractNum)->delete();
            People_Involve::where('contract_num', $contractNum)->delete();

            // Delete records from accountability tables
            $this->deleteAccountabilityRecords($contractNum);

            // Delete the main record
            $record->delete();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Record deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Record deletion failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete record: ' . $e->getMessage()], 500);
        }
    }

    private function deleteAccountabilityRecords($contractNum)
    {
        $accountabilityModels = [
            'Need_Assessment_Analysis',
            'Training_Design_Implementation',
            'Number_Facilitators',
            'Conduct_Orientation',
            'Coordination_Materials',
            'Secretariat',
            'Id',
            'Parents_Consent',
            'Designing_Poster',
            'Tshirt_Printing',
            'Banner_Printing',
            'Coordination_Venue',
            'Coordination_Participants',
            'Coordination_Food',
            'Coordination_Speakers',
            'Supporting_Docs',
            'Insurance',
            'Venue_Recce',
            'Documentation',
            'Video_Teaser',
        ];

        foreach ($accountabilityModels as $modelName) {
            $fullModelName = "App\\Models\\$modelName";
            if (class_exists($fullModelName)) {
                $fullModelName::where('contract_num', $contractNum)->delete();
            }
        }
    }

    // MARK: VIEW or SHOW
    public function show($id)
    {

        if (Auth::check()) {
            $record = Partners_Information::findOrFail($id);
            $participants = Participants::where('contract_num', $record->contract_num)->first();
            $interventionAssessment = Intervention_Assessment::where('contract_num', $record->contract_num)->first();
            $proposedIntervention = Proposed_Intervention::where('contract_num', $record->contract_num)->first();


            // Accountabilities (part 1)
            $needAssessment = Need_Assessment_Analysis::where('contract_num', $record->contract_num)->first();
            $trainingDesign = Training_Design_Implementation::where('contract_num', $record->contract_num)->first();
            $numberFacilitator = Number_Facilitators::where('contract_num', $record->contract_num)->first();
            $conductOrientation = Conduct_Orientation::where('contract_num', $record->contract_num)->first();
            $coordinationMaterials = Coordination_Materials::where('contract_num', $record->contract_num)->first();

            // Accountabilities (part 2)
            $secretariat = Secretariat::where('contract_num', $record->contract_num)->first();
            $ID = Id::where('contract_num', $record->contract_num)->first();
            $parentsConsent = Parents_Consent::where('contract_num', $record->contract_num)->first();
            $designingPoster = Designing_Poster::where('contract_num', $record->contract_num)->first();
            $tshirtprinting = Tshirt_Printing::where('contract_num', $record->contract_num)->first();

            // Accountabilities (part 3)
            $bannerPrinting = Banner_Printing::where('contract_num', $record->contract_num)->first();
            $coordinationVenue = Coordination_Venue::where('contract_num', $record->contract_num)->first();
            $coordinationParticipants = Coordination_Participants::where('contract_num', $record->contract_num)->first();
            $coordinationFood = Coordination_Food::where('contract_num', $record->contract_num)->first();
            $coordinationSpeakers = Coordination_Speakers::where('contract_num', $record->contract_num)->first();

            // Accountabilities (part 4)
            $supportingDocs = Supporting_Docs::where('contract_num', $record->contract_num)->first();
            $insurance = Insurance::where('contract_num', $record->contract_num)->first();
            $venueReece = Venue_Recce::where('contract_num', $record->contract_num)->first();
            $documentation = Documentation::where('contract_num', $record->contract_num)->first();
            $videoTeaser = Video_Teaser::where('contract_num', $record->contract_num)->first();


            $peopleInvolved = People_Involve::where('contract_num', $record->contract_num)->first();

            return view('show', compact('record',
            // return view('show2', compact('record',
            // // return view('show3', compact('record',
            'participants',
            'interventionAssessment',
            'proposedIntervention',

            // Accountabilities nga part
            'needAssessment',
            'trainingDesign',
            'numberFacilitator',
            'conductOrientation',
            'coordinationMaterials',

            'secretariat',
            'ID',
            'parentsConsent',
            'designingPoster',
            'tshirtprinting',

            'bannerPrinting',
            'coordinationVenue',
            'coordinationParticipants',
            'coordinationFood',
            'coordinationSpeakers',

            'supportingDocs',
            'insurance',
            'venueReece',
            'documentation',
            'videoTeaser',


            'peopleInvolved'));
        }

        return redirect(route('login'));
    }

    // MARK: UPDATE
    public function update(Request $request, $contract_num)
    {
        try {
            DB::beginTransaction();

            $record = Partners_Information::where('contract_num', $contract_num)->firstOrFail();

            // Update Partners_Information
            $record->update($request->only([
                'org_name',
                'category',
                'orghd_name',
                'orghead_designation',
                'orghead_contact',
                'coor_name',
                'coor_desig',
                'coor_contact'
            ]));

            // Update Participants
            Participants::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'age',
                    'gender',
                    'education_status',
                    'leadership_exp',
                    'address'])
            );

            // Update Intervention_Assessment
            Intervention_Assessment::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'pic_success',
                    'kgap',
                    'sgap',
                    'tdgap',
                    'issues_concerns'])
            );

            // Update Proposed_Intervention
            Proposed_Intervention::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'type_intervention',
                    'venue',
                    'startdate',
                    'enddate',
                    'days',
                    'duration',
                    'objectives',
                    'output'
                ])
            );

            // Update People_Involve
            People_Involve::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'lead_faci',
                    'second_faci',
                    'third_faci',
                    'sponsor',
                    'vip',
                    'working_com',
                    'observers'])
            );

            // Update accountability tables
            // MARK:part1
            Need_Assessment_Analysis::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'need_assessment_costing',
                    'need_assessment_partner',
                    'need_assessment_colinkIC',
                    'need_assessment_timeline'
                ])
            );

            Training_Design_Implementation::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'trainig_design_and_implementation_costing',
                    'trainig_design_and_implementation_partner',
                    'trainig_design_and_implementation_colinkIC',
                    'trainig_design_and_implementation_timeline'])
            );

            Number_Facilitators::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'number_of_facilitators_costing',
                    'number_of_facilitators_partner',
                    'number_of_facilitators_colinkIC',
                    'number_of_facilitators_timeline'])
            );

            Conduct_Orientation::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'conduct_of_orientation_costing',
                    'conduct_of_orientation_partner',
                    'conduct_of_orientation_colinkIC',
                    'conduct_of_orientation_timeline'
                    ])
            );

            Coordination_Materials::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'coordination_of_materials_costing',
                    'coordination_of_materials_partner',
                    'coordination_of_materials_colinkIC',
                    'coordination_of_materials_timeline'
                ])
            );

            // MARK:part2
            Secretariat::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'secretariat_costing',
                    'secretariat_partner',
                    'secretariat_colinkIC',
                    'secretariat_timeline'])
            );

            Id::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'id_costing',
                    'id_partner',
                    'id_colinkIC',
                    'id_timeline'])
            );

            Parents_Consent::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'parents_consent_costing',
                    'parents_consent_partner',
                    'parents_consent_colinkIC',
                    'parents_consent_timeline'])
            );

            Designing_Poster::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'designing_of_poster_costing',
                    'designing_of_poster_partner',
                    'designing_of_poster_colinkIC',
                    'designing_of_poster_timeline'])
            );

            Tshirt_Printing::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'tshirt_printing_costing',
                    'tshirt_printing_partner',
                    'tshirt_printing_colinkIC',
                    'tshirt_printing_timeline'])
            );

            // MARK:part3
            Banner_Printing::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'banner_printing_costing',
                    'banner_printing_partner',
                    'banner_printing_colinkIC',
                    'banner_printing_timeline'])
            );

            Coordination_Venue::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'coordination_for_venue_costing',
                    'coordination_for_venue_partner',
                    'coordination_for_venue_colinkIC',
                    'coordination_for_venue_timeline'])
            );

            Coordination_Participants::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'coordination_with_participants_costing',
                    'coordination_with_participants_partner',
                    'coordination_with_participants_colinkIC',
                    'coordination_with_participants_timeline'])
            );

            Coordination_Food::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'coordination_with_food_costing',
                    'coordination_with_food_partner',
                    'coordination_with_food_colinkIC',
                    'coordination_with_food_timeline'])
            );

            Coordination_Speakers::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'coordination_with_speakers_costing',
                     'coordination_with_speakers_partner',
                     'coordination_with_speakers_colinkIC',
                     'coordination_with_speakers_timeline'])
            );

            // MARK:part4
            Supporting_Docs::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'supporting_docs_coordination_costing',
                    'supporting_docs_coordination_partner',
                    'supporting_docs_coordination_colinkIC',
                    'supporting_docs_coordination_timeline'])
            );

            Insurance::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'insurance_costing',
                    'insurance_partner',
                    'insurance_colinkIC',
                    'insurance_timeline'])
            );

            Venue_Recce::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'venue_recce_costing',
                    'venue_recce_partner',
                    'venue_recce_colinkIC',
                    'venue_recce_timeline'])
            );

            Documentation::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'documentation_costing',
                    'documentation_partner',
                    'documentation_colinkIC',
                    'documentation_timeline'])
            );

            Video_Teaser::updateOrCreate(
                ['contract_num' => $contract_num],
                $request->only([
                    'video_teaser_costing',
                     'video_teaser_partner',
                     'video_teaser_colinkIC',
                     'video_teaser_timeline'])
            );

            // Check for 1 week before the day
            $checkStartDate = $this->checkStartDate(
                $request->startdate
            );

            if ($checkStartDate) {
                return redirect()->back()
                ->withInput()
                ->withErrors(['conflict2' => $checkStartDate])
                ->with('scrollTo', 'startdate');
            }

            // Check for conflicts
            $conflictMessage = $this->checkConflicts(
                $request->startdate,
                $request->enddate,
                $request->lead_faci,
                $request->second_faci,
                $request->third_faci
            );

            if ($conflictMessage) {
                return redirect()->back()
                ->withInput()
                ->withErrors(['conflict1' => $conflictMessage])
                ->with('scrollTo', 'startdate');
            }
            DB::commit();

            return redirect()->route('records.show', $contract_num)->with('success', 'Record updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Record update failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to update record: ' . $e->getMessage());
        }
    }

    public function showProgress($contractNum)
    {
        if (Auth::check()) {
            $contract = Partners_Information::with('progress')->where('contract_num', $contractNum)->firstOrFail();
            return view('progress', compact('contract'));
        }
        return redirect(route('login'));
    }

    public function updateProgress(Request $request, $contractNum)
    {
        $progress = Contract_Progress::where('contract_num', $contractNum)->firstOrFail();
        $contract = Partners_Information::where('contract_num', $contractNum)->firstOrFail();

        switch ($request->status) {
            case 'processing':
                $progress->is_processing = true;
                $progress->is_pending = false;
                $progress->is_done = false;
                break;
            case 'pending':
                $progress->is_processing = true; // Keep processing true
                $progress->is_pending = true;
                $progress->is_done = false;
                break;
            case 'done':
                $progress->is_processing = false;
                $progress->is_pending = false;
                $progress->is_done = true;
                break;
        }

        // Create status change record
        $contract->statusChanges()->create([
            'status' => $request->status,
            'updated_by' => Auth::user()->name ?? 'System'
        ]);

        $progress->save();

        return redirect()->route('progress', $contractNum)->with('success', 'Progress updated successfully');
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

    public function generatePdf($contract_num): JsonResponse
    {
        try {
            $record = Partners_Information::with([
                'participants',
                'intervention',
                'proposed_intervention',
                'people_involve',
                'need_assessment_and_analysis',
                'training_design',
                'number_of_facilitators',
                'conduct_of_orientation',
                'coor_materials',
                'secretariat',
                'id',
                'parents_consent',
                'designing_of_poster',
                'tshirt_printing',
                'banner_printing',
                'coordination_for_venue',
                'coordination_with_participants',
                'coordination_with_food',
                'coordination_with_speakers',
                'supporting_docs_coordination',
                'insurance',
                'venue_recce',
                'documentation',
                'video_teaser'
            ])->where('contract_num', $contract_num)->firstOrFail();

        $pdfData = [
            'org_name' => $record->org_name ?? 'N/A',
            'category' => $record->category ?? 'N/A',
            'orghd_name' => $record->orghd_name ?? 'N/A',
            'orghead_designation' => $record->orghead_designation ?? 'N/A',
            'orghead_contact' => $record->orghead_contact ?? 'N/A',
            'coor_name' => $record->coor_name ?? 'N/A',
            'coor_desig' => $record->coor_desig ?? 'N/A',
            'coor_contact' => $record->coor_contact ?? 'N/A',
            'participants' => $this->getParticipantsData($record->participants),
            'intervention' => $this->getInterventionData($record->intervention),
            'proposed_intervention' => $this->getProposedInterventionData($record->proposed_intervention),
            'accountabilities' => $this->getAccountabilitiesData($record),
            'people_involve' => $this->getPeopleInvolveData($record->people_involve),
        ];

            return response()->json($pdfData);
        } catch (\Exception $e) {
            Log::error('PDF generation error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'An error occurred while generating the PDF data: ' . $e->getMessage()], 500);
        }
    }

    private function getParticipantsData($participants)
    {
        if (!$participants) {
            return null;
        }

        return [
            'age' => $participants->age ?? 'N/A',
            'gender' => $participants->gender ?? 'N/A',
            'education_status' => $participants->education_status ?? 'N/A',
            'leadership_exp' => $participants->leadership_exp ?? 'N/A',
            'address' => $participants->address ?? 'N/A',
        ];
    }

    private function getInterventionData($intervention)
    {
        if (!$intervention) {
            return null;
        }

        return [
            'pic_success' => $intervention->pic_success ?? 'N/A',
            'kgap' => $intervention->kgap ?? 'N/A',
            'sgap' => $intervention->sgap ?? 'N/A',
            'tdgap' => $intervention->tdgap ?? 'N/A',
            'issues_concerns' => $intervention->issues_concerns ?? 'N/A',
        ];
    }

    private function getProposedInterventionData($proposedIntervention)
    {
        if (!$proposedIntervention) {
            return null;
        }

        return [
            'type_intervention' => $proposedIntervention->type_intervention ?? 'N/A',
            'venue' => $proposedIntervention->venue ?? 'N/A',
            'objectives' => $proposedIntervention->objectives ?? 'N/A',
            'output' => $proposedIntervention->output ?? 'N/A',
        ];
    }

    private function getAccountabilitiesData($record)
    {
        $accountabilityFields = [
            'need_assessment_and_analysis', 'training_design', 'number_of_facilitators',
            'conduct_of_orientation', 'coor_materials', 'secretariat', 'id', 'parents_consent',
            'designing_of_poster', 'tshirt_printing', 'banner_printing', 'coordination_for_venue',
            'coordination_with_participants', 'coordination_with_food', 'coordination_with_speakers',
            'supporting_docs_coordination', 'insurance', 'venue_recce', 'documentation', 'video_teaser'
        ];

        $accountabilities = [];
        foreach ($accountabilityFields as $field) {
            $accountabilities[$field] = $this->getAccountabilityData($record->$field);
        }

        return $accountabilities;
    }

    private function getAccountabilityData($data)
    {
        if (!$data) {
            return [
                'costing' => 'N/A',
                'partner' => 'N/A',
                'colinkIC' => 'N/A',
                'timeline' => 'N/A',
            ];
        }

        return [
            'costing' => $data->costing ?? 'N/A',
            'partner' => $data->partner ?? 'N/A',
            'colinkIC' => $data->colinkIC ?? 'N/A',
            'timeline' => $data->timeline ? $data->timeline->format('Y-m-d') : 'N/A',
        ];
    }

    private function getPeopleInvolveData($peopleInvolve)
    {
        if (!$peopleInvolve) {
            return null;
        }

        return [
            'leadfaci' => $peopleInvolve->leadfaci ?? 'N/A',
            'secondfaci' => $peopleInvolve->secondfaci ?? 'N/A',
            'thirdfaci' => $peopleInvolve->thirdfaci ?? 'N/A',
            'sponsor' => $peopleInvolve->sponsor ?? 'N/A',
            'vip' => $peopleInvolve->vip ?? 'N/A',
            'working_com' => $peopleInvolve->working_com ?? 'N/A',
            'observers' => $peopleInvolve->observers ?? 'N/A',
        ];
    }

}
