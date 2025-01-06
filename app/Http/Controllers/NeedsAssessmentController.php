<?php

namespace App\Http\Controllers;

use App\Models\NeedsAssessment;
use App\Models\Question;
use App\Models\Option;
use App\Models\Response;
use Illuminate\Http\Request;

class NeedsAssessmentController extends Controller
{
    public function create()
    {
        return view('needs-assessment.create');
    }

    public function store(Request $request)
    {
        $needsAssessment = NeedsAssessment::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        foreach ($request->questions as $questionData) {
            $question = $needsAssessment->questions()->create([
                'question' => $questionData['question'],
                'type' => $questionData['type'],
            ]);

            foreach ($questionData['options'] as $option) {
                $question->options()->create(['option_text' => $option]);
            }
        }

        return redirect()->route('needs-assessment.show', $needsAssessment->id);
    }

    public function show($id)
    {
        $needsAssessment = NeedsAssessment::with('questions.options')->findOrFail($id);
        return view('needs-assessment.show', compact('needsAssessment'));
    }

    public function storeResponse(Request $request, $questionId)
    {
        Response::create([
            'question_id' => $questionId,
            'response' => $request->response,
        ]);

        return back();
    }
    public function showForm()
{
    // Logic to show the needs assessment form
    return view('form.needs-assessment'); // Or the name of your actual view
}
}
