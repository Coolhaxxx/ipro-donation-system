<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_donations' => Donation::sum('amount'),
            'total_donation_count' => Donation::count(),
            'total_donors' => Donor::count(),
            'pending_donations' => Donation::where('payment_status', 'pending')->count(),
            'completed_donations' => Donation::where('payment_status', 'completed')->count(),
            
            // By payment method
            'cash_donations' => Donation::where('payment_method', 'cash')->sum('amount'),
            'check_donations' => Donation::where('payment_method', 'check')->sum('amount'),
            'online_donations' => Donation::where('payment_method', 'online')->sum('amount'),
            
            // By donation type
            'zakat_donations' => Donation::where('donation_type', 'zakat')->sum('amount'),
            'sadaqah_donations' => Donation::where('donation_type', 'sadaqah')->sum('amount'),
            'general_donations' => Donation::where('donation_type', 'general')->sum('amount'),
        ];

        // Recent donations (last 10)
        $recent_donations = Donation::with('donor')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Monthly donations for chart
        $monthly_donations = Donation::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_donations', 'monthly_donations'));
    }

    /**
     * Show all donations
     */
    public function donations(Request $request)
    {
        $query = Donation::with('donor')->orderBy('created_at', 'desc');

        // Filter by payment status
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        // Filter by payment method
        if ($request->filled('method')) {
            $query->where('payment_method', $request->method);
        }

        // Filter by donation type
        if ($request->filled('type')) {
            $query->where('donation_type', $request->type);
        }

        // Search by donor name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('donor', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $donations = $query->paginate(20);

        return view('admin.donations', compact('donations'));
    }

    /**
     * Show donation details
     */
    public function showDonation($id)
    {
        $donation = Donation::with('donor', 'paymentTransaction')->findOrFail($id);
        
        return view('admin.donation-details', compact('donation'));
    }

    /**
     * Show all donors
     */
    public function donors(Request $request)
    {
        $query = Donor::withCount('donations')
            ->orderBy('created_at', 'desc');

        // Search by name, email, or phone
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $donors = $query->paginate(20);

        return view('admin.donors', compact('donors'));
    }

    /**
     * Show donor details
     */
    public function showDonor($id)
    {
        $donor = Donor::with('donations')->findOrFail($id);
        
        return view('admin.donor-details', compact('donor'));
    }

    /**
     * Update donation status
     */
    public function updateDonationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,failed'
        ]);

        $donation = Donation::findOrFail($id);
        $donation->update(['payment_status' => $request->status]);

        return back()->with('success', 'Donation status updated successfully!');
    }

    /**
     * Show admin profile
     */
    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    /**
     * Update admin profile
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        // Update name and email
        $user->name = $request->name;
        $user->email = $request->email;

        // Update password if provided
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $user->password = bcrypt($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}
