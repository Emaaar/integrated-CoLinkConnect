<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrackerController extends Controller
{
    protected $phases = ['Contracting', 'Needs Assessment', 'Activity Design', 'Intervention', 'Evaluation'];

    public function index()
    {
        $currentPhase = session('currentPhase', 0);
        return view('tracker', [
            'phases' => $this->phases,
            'currentPhase' => $currentPhase
        ]);
    }
    public function showContractTracker()
{
    // Set the current phase, for example:php
    $currentPhase = 0; // or logic to determine the phase

    return view('tracker', compact('currentPhase'));
}


    public function nextPhase(Request $request)
    {
        $currentPhase = session('currentPhase', 0);
        if ($currentPhase < count($this->phases) - 1) {
            session(['currentPhase' => $currentPhase + 1]);
        }
        return redirect()->route('tracker');
    }

    public function previousPhase(Request $request)
    {
        $currentPhase = session('currentPhase', 0);
        if ($currentPhase > 0) {
            session(['currentPhase' => $currentPhase - 1]);
        }
        return redirect()->route('tracker');
    }

    public function submit(Request $request)
    {
        $currentPhase = session('currentPhase', 0);
        
        // Validate the request data
        $validatedData = $request->validate([
            'contracting' => 'required_if:currentPhase,0|file|mimes:pdf,doc,docx|max:2048',
            'userGmail' => 'required_if:currentPhase,1|email',
            'clientGmail' => 'required_if:currentPhase,1|email',
            'needsAssessment' => 'required_if:currentPhase,1|string|max:1000',
            // Add validation rules for other phases as needed
        ]);

        // Process the submitted data based on the current phase
        switch ($currentPhase) {
            case 0:
                if ($request->hasFile('contracting')) {
                    $file = $request->file('contracting');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('contracting', $filename, 'public');
                    // Save $filePath to database or process as needed
                }
                break;
            case 1:
                // Process Needs Assessment data
                // You can save this data to the database or process it as needed
                $needsAssessmentData = [
                    'userGmail' => $validatedData['userGmail'],
                    'clientGmail' => $validatedData['clientGmail'],
                    'needsAssessment' => $validatedData['needsAssessment'],
                ];
                // Save $needsAssessmentData to database or process as needed
                break;
            // Add cases for other phases as needed
        }

        // Move to the next phase if not in the last phase
        if ($currentPhase < count($this->phases) - 1) {
            session(['currentPhase' => $currentPhase + 1]);
            return redirect()->route('tracker')->with('success', 'Data submitted successfully. Moving to next phase.');
        } else {
            // If in the last phase, complete the process
            session(['currentPhase' => 0]); // Reset to first phase
            return redirect()->route('tracker')->with('success', 'Contract process completed successfully!');
        }
    }
}

