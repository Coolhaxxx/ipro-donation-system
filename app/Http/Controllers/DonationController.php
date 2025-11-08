<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\Donation;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class DonationController extends Controller
{
    /**
     * Display the donation form
     */
    public function index($campaignSlug = null)
    {
        // Load campaign by slug or get default
        if ($campaignSlug) {
            $campaign = Campaign::where('slug', $campaignSlug)
                ->where('is_active', true)
                ->firstOrFail();
        } else {
            $campaign = Campaign::getDefault();
            
            if (!$campaign) {
                abort(404, 'No active campaign found. Please contact the administrator.');
            }
        }
        
        return view('donation.form', compact('campaign'));
    }

    /**
     * Check if donor exists by email or phone
     */
    public function checkDonor(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ]);

        $donor = Donor::findByEmailOrPhone(
            $request->email,
            $request->phone
        );

        if ($donor) {
            return response()->json([
                'exists' => true,
                'donor' => $donor
            ]);
        }

        return response()->json([
            'exists' => false
        ]);
    }

    /**
     * Store a new donation
     */
    public function store(Request $request, $campaignSlug = null)
    {
        // Load campaign by slug or get default
        if ($campaignSlug) {
            $campaign = Campaign::where('slug', $campaignSlug)
                ->where('is_active', true)
                ->firstOrFail();
        } else {
            $campaign = Campaign::getDefault();
            
            if (!$campaign) {
                return back()->withErrors(['error' => 'No active campaign found.'])->withInput();
            }
        }
        // Debug: Log incoming data
        \Log::info('Donation submission data:', $request->all());
        
        $request->validate([
            // Personal Information
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:50',
            'zip' => 'required|string|max:20',
            
            // Donation Details
            'amount' => 'required|numeric|min:1',
            'donation_type' => 'required|in:zakat,sadaqah,general',
            'payment_method' => 'required|in:cash,check,online',
            
            // Check Payment Fields (conditional)
            'check_number' => 'required_if:payment_method,check|nullable|string|max:100',
            'check_photo' => 'nullable|required_if:payment_method,check|image|mimes:jpeg,png,jpg|max:5120',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'routing_number' => 'nullable|string|max:50',
        ]);

        try {
            DB::beginTransaction();

            // Find or create donor
            $donor = Donor::firstOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'street_address' => $request->street_address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip' => $request->zip,
                ]
            );

            // Update donor info if exists
            if (!$donor->wasRecentlyCreated) {
                $donor->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'street_address' => $request->street_address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip' => $request->zip,
                ]);
            }

            // Prepare donation data
            $donationData = [
                'donor_id' => $donor->id,
                'campaign_id' => $campaign->id,
                'amount' => $request->amount,
                'donation_type' => $request->donation_type,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'online' ? 'pending' : 'pending',
            ];

            // Handle check payment
            if ($request->payment_method === 'check') {
                $donationData['check_number'] = $request->check_number;
                $donationData['bank_name'] = $request->bank_name;
                $donationData['account_number'] = $request->account_number;
                $donationData['routing_number'] = $request->routing_number;

                // Store check photo
                if ($request->hasFile('check_photo')) {
                    $path = $request->file('check_photo')->store('checks', 'public');
                    $donationData['check_photo'] = $path;
                }
            }

            // Create donation
            $donation = Donation::create($donationData);

            DB::commit();

            // Handle different payment methods
            switch ($request->payment_method) {
                case 'cash':
                    return $this->handleCashPayment($donation);
                    
                case 'check':
                    return $this->handleCheckPayment($donation);
                    
                case 'online':
                    return $this->handleOnlinePayment($donation, $request);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log the actual error for debugging
            \Log::error('Donation Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->withErrors([
                'error' => 'An error occurred while processing your donation. Error: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Handle cash payment
     */
    protected function handleCashPayment($donation)
    {
        return redirect()->route('donation.confirmation', $donation->id)
            ->with('success', 'Thank you! Your cash donation has been recorded. Please complete your payment at our office.');
    }

    /**
     * Handle check payment
     */
    protected function handleCheckPayment($donation)
    {
        return redirect()->route('donation.confirmation', $donation->id)
            ->with('success', 'Thank you! Your check donation has been recorded. We will process it shortly.');
    }

    /**
     * Handle online payment (Stripe)
     */
    protected function handleOnlinePayment($donation, $request)
    {
        // For now, redirect to payment page
        // We'll implement Stripe integration in next step
        return redirect()->route('donation.payment', $donation->id);
    }

    /**
     * Show confirmation page
     */
    public function confirmation($id)
    {
        $donation = Donation::with('donor')->findOrFail($id);
        
        return view('donation.confirmation', compact('donation'));
    }

    /**
     * Show payment page for online donations
     */
    public function payment($id)
    {
        $donation = Donation::with('donor')->findOrFail($id);
        
        if ($donation->payment_method !== 'online') {
            return redirect()->route('donation.confirmation', $donation->id);
        }
        
        return view('donation.payment', compact('donation'));
    }
}
