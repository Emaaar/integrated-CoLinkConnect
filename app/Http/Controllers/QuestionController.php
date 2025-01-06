<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\Question;

class QuestionController extends Controller
{
    public function store(Request $request, $formId)
    {
        $form = Form::findOrFail($formId);

        foreach ($request->questions as $questionData) {
            $form->questions()->create($questionData);
        }

        return response()->json(['message' => 'Questions added successfully!']);
    }
}
