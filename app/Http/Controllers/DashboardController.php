<?php

namespace App\Http\Controllers;

use App\Models\Partners;
use App\Models\Donation;
use App\Models\User;



class DashboardController extends Controller
{
    public function showDashboard()
    {
        // Fetch total partners, total donations, and total interventions from the database
        $totalPartners = Partners::count();
        $totalDonations = Donation::sum('amount');
        // $totalInterventions = Partners::count(); // Interventions based on the number of contracts

        // Fetch users or clients as needed
        $users = User::all();

        // Return the view with the required data
        return view('dashboard', compact('totalPartners', 'totalDonations',  'users'));
    }

    public function updatePartners()
    {
        // Fetch updated total partners and interventions
        $totalPartners = Partners::count();
        $totalDonations = Donation::sum('amount');
        // $totalInterventions = Partners::count(); // Interventions based on contracts

        // Return the dashboard view with updated partners count
        return view('dashboard', compact('totalPartners', 'totalDonations', ));
    }

    public function updateDonations()
    {
        // Fetch updated total donations and interventions
        $totalDonations = Donation::sum('amount');
        $totalPartners = Partners::count();
        // $totalInterventions = Partners::count(); // Interventions based on contracts

        // Return the dashboard view with updated donations count
        return view('dashboard', compact('totalDonations', 'totalPartners', ));
    }
    public function dashboard()
    {
        $users = User::all(); // Retrieve all users from the database
        return view('dashboard', ['users' => $users]); // Pass $users to the view
    }

    // public function updateInterventions()
    // {
    //     // Fetch updated total interventions (contracts made in the Partners table)
    //     $totalInterventions = Partners::count();

    //     // Fetch other data (optional, you can include partners or donations if needed)
    //     $totalPartners = Partners::count();
    //     $totalDonations = Donation::sum('amount');

    //     // Return the dashboard view with updated interventions count
    //     return view('dashboard', compact('totalPartners', 'totalDonations', 'totalInterventions'));
    // }
    public function blog()
{
    return view('showblog'); // Make sure this matches your Blade file name
}

}

