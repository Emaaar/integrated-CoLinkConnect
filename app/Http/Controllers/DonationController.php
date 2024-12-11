<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Import Log facade

class DonationController extends Controller
{
    // Display the donation form
    public function donation()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('donation');
    }

    public function donationQR1()
    {
        // if (!Auth::check()) {
        //     return redirect()->route('cclogin');
        // }

        return view('donation-qr1');
    }

    public function donationQR2()
    {
        // if (!Auth::check()) {
        //     return redirect()->route('cclogin');
        // }

        return view('donation-qr2');
    }

    public function donationPost(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'donor_name' => 'required|string|max:255',
            'prefer' => 'required|string',
            'amount' => 'required|integer|min:1',
        ]);

        // Retrieve the user email from the session
        $userEmail = session('user_email');

        // Check if the user_email exists in the session
        if (!$userEmail) {
            return redirect()->route('donation')->with('error', 'You must be logged in to make a donation.');
        }

        // Fetch the user from the users table using the email from the session
        $user = User::where('user_email', $userEmail)->first();

        if (!$user) {
            return redirect()->route('donation')->with('error', 'User not found in our records.');
        }

        // Prepare data for creation
        $data = [
            'donor_name' => $request->donor_name,
            'user_email' => $userEmail, // Use the email from the session
            'prefer' => $request->prefer,
            'amount' => $request->amount,
            'client_id' => $user->client_id, // Get client_id from the retrieved user
        ];

        // Attempt to create the donation
        try {
            $donation = Donation::create($data);
        } catch (\Exception $e) {
            // Log error or display message
            Log::error('Donation creation failed: ' . $e->getMessage());
            return redirect()->route('donation')->with('error', 'Donation failed, please try again.');
        }

        // Redirect with a success message
        if($request->prefer == "gcash"){
            return redirect()->route('donation-gcash')->with('success', 'Scan the QR code.');
        }
        else{
            return redirect()->route('donation-paymaya')->with('success', 'Scan the QR code.');
        }
        // return redirect()->back()->with('success', 'Thank you for your donation!');
    }
}
