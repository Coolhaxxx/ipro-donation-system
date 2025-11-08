<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    /**
     * Display a listing of campaigns
     */
    public function index()
    {
        $campaigns = Campaign::orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new campaign
     */
    public function create()
    {
        return view('admin.campaigns.create');
    }

    /**
     * Store a newly created campaign
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'goal_text' => 'nullable|string',
            'impact_text' => 'nullable|string',
            'goal_amount' => 'nullable|numeric|min:0',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
        ]);

        $data = $request->except(['logo', 'cover_image']);
        $data['slug'] = Str::slug($request->name);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('campaigns/logos', 'public');
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('campaigns/covers', 'public');
        }

        // If set as default, unset all other defaults
        if ($request->is_default) {
            Campaign::where('is_default', true)->update(['is_default' => false]);
        }

        Campaign::create($data);

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Campaign created successfully!');
    }

    /**
     * Show the form for editing the specified campaign
     */
    public function edit(Campaign $campaign)
    {
        return view('admin.campaigns.edit', compact('campaign'));
    }

    /**
     * Update the specified campaign
     */
    public function update(Request $request, Campaign $campaign)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'goal_text' => 'nullable|string',
            'impact_text' => 'nullable|string',
            'goal_amount' => 'nullable|numeric|min:0',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
        ]);

        $data = $request->except(['logo', 'cover_image']);
        $data['slug'] = Str::slug($request->name);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($campaign->logo) {
                Storage::disk('public')->delete($campaign->logo);
            }
            $data['logo'] = $request->file('logo')->store('campaigns/logos', 'public');
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover image
            if ($campaign->cover_image) {
                Storage::disk('public')->delete($campaign->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('campaigns/covers', 'public');
        }

        // If set as default, unset all other defaults
        if ($request->is_default && !$campaign->is_default) {
            Campaign::where('is_default', true)->update(['is_default' => false]);
        }

        $campaign->update($data);

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Campaign updated successfully!');
    }

    /**
     * Remove the specified campaign
     */
    public function destroy(Campaign $campaign)
    {
        // Don't allow deleting campaign with donations
        if ($campaign->donations()->count() > 0) {
            return back()->with('error', 'Cannot delete campaign with existing donations.');
        }

        // Delete images
        if ($campaign->logo) {
            Storage::disk('public')->delete($campaign->logo);
        }
        if ($campaign->cover_image) {
            Storage::disk('public')->delete($campaign->cover_image);
        }

        $campaign->delete();

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Campaign deleted successfully!');
    }

    /**
     * Toggle campaign active status
     */
    public function toggleActive(Campaign $campaign)
    {
        $campaign->update(['is_active' => !$campaign->is_active]);

        $status = $campaign->is_active ? 'activated' : 'deactivated';
        
        return back()->with('success', "Campaign {$status} successfully!");
    }

    /**
     * Set campaign as default
     */
    public function setDefault(Campaign $campaign)
    {
        Campaign::where('is_default', true)->update(['is_default' => false]);
        $campaign->update(['is_default' => true, 'is_active' => true]);

        return back()->with('success', 'Campaign set as default successfully!');
    }
}
