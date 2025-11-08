<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    /**
     * Display the donation form
     */
    public function index()
    {
        return view('donation.form');
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:50',
            'zip' => 'required|string|max:20',
            'amount' => 'required|numeric|min:1',
            'donation_type' => 'required|in:zakat,sadaqah,general',
            'payment_method' => 'required|in:cash,check,online',
            'check_number' => 'required_if:payment_method,check|nullable|string|max:100',
            'check_photo' => 'nullable|required_if:payment_method,check|image|mimes:jpeg,png,jpg|max:5120',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'routing_number' => 'nullable|string|max:50',
        ]);

        try {
            DB::beginTransaction();

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

            $donationData = [
                'donor_id' => $donor->id,
                'amount' => $request->amount,
                'donation_type' => $request->donation_type,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
            ];

            if ($request->payment_method === 'check') {
                $donationData['check_number'] = $request->check_number;
                $donationData['bank_name'] = $request->bank_name;
                $donationData['account_number'] = $request->account_number;
                $donationData['routing_number'] = $request->routing_number;

                if ($request->hasFile('check_photo')) {
                    $path = $request->file('check_photo')->store('checks', 'public');
                    $donationData['check_photo'] = $path;
                }
            }

            $donation = Donation::create($donationData);

            DB::commit();

            switch ($request->payment_method) {
                case 'cash':
                    return redirect()->route('donation.confirmation', $donation->id);
                case 'check':
                    return redirect()->route('donation.confirmation', $donation->id);
                case 'online':
                    return redirect()->route('donation.payment', $donation->id);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Donation Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An error occurred'])->withInput();
        }
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
     * Show payment page
     */
    public function payment($id)
    {
        $donation = Donation::with('donor')->findOrFail($id);
        
        if ($donation->payment_method !== 'online') {
            return redirect()->route('donation.confirmation', $donation->id);
        }
        
        return view('donation.payment', compact('donation'));
    }

    /**
     * Process Stripe payment
     */
    public function processPayment(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);

        $request->validate([
            'payment_method_id' => 'required|string',
        ]);

        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $donation->amount * 100, // Convert to cents
                'currency' => 'usd',
                'payment_method' => $request->payment_method_id,
                'confirm' => true,
                'description' => 'Donation - ' . $donation->donation_type_name,
                'metadata' => [
                    'donation_id' => $donation->id,
                    'donor_email' => $donation->donor->email,
                ],
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never'
                ],
            ]);

            if ($paymentIntent->status === 'succeeded') {
                $donation->update([
                    'payment_status' => 'completed',
                    'transaction_id' => $paymentIntent->id,
                ]);

                return redirect()->route('donation.confirmation', $donation->id)
                    ->with('success', 'Payment successful! Thank you for your donation.');
            } else {
                return back()->withErrors(['error' => 'Payment failed. Please try again.']);
            }

        } catch (\Stripe\Exception\CardException $e) {
            return back()->withErrors(['error' => $e->getError()->message]);
        } catch (\Exception $e) {
            \Log::error('Stripe Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Payment processing error']);
        }
    }
}
