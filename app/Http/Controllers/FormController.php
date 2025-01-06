<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;

class FormController extends Controller
{
    public function show($id)
    {
        $form = Form::find($id); // Fetch form based on ID
        if (!$form) {
            abort(404); // Return a 404 if the form is not found
        }

        return view('form.show', compact('form')); // Show the form view
    }

}