# Campaign Management System - Setup Guide

## 🎉 Campaign System Created!

You now have a complete campaign management system with:
- ✅ Create campaigns with logo and cover image
- ✅ Editable campaign content (titles, descriptions, goals)
- ✅ Set goal amounts and track progress
- ✅ Mark campaigns as active/inactive
- ✅ Set default campaign for donation form
- ✅ Campaign statistics (total raised, donor count)

---

## 🚀 Setup Instructions:

### Step 1: Run Migrations

```bash
php artisan migrate
```

This will create the `campaigns` table and update the `donations` table.

### Step 2: Create Your First Campaign

1. Go to: **http://localhost:8000/admin/campaigns**
2. Click "Create New Campaign"
3. Fill in the details:
   - **Campaign Name**: e.g., "Jamaica Hurricane Relief"
   - **Display Title**: e.g., "JAMAICA HURRICANE"
   - **Subtitle**: e.g., "EMERGENCY RELIEF"
   - **Upload Logo** (optional)
   - **Upload Cover Image** (optional - 1200x300px recommended)
   - **Goal/Impact Description**: Describe the campaign
   - **Impact Statement**: e.g., "Relief provisions include food, medical aid..."
   - **Goal Amount**: e.g., 100000
   - **Check "Active"** and **"Set as Default"**
4. Click "Create Campaign"

---

## 📋 Features:

### Campaign List Page
- **Grid view** of all campaigns with cover images
- **Badges** showing DEFAULT and ACTIVE/INACTIVE status
- **Statistics** showing:
  - Total donations received
  - Goal amount and progress bar
  - Number of donors
- **Quick Actions**:
  - Edit campaign
  - Activate/Deactivate
  - Set as Default (⭐)
  - Delete (only if no donations)

### Create/Edit Campaign Form

#### Basic Information:
- Campaign Name (internal)
- Display Title (shown on form)
- Subtitle (shown below title)
- Description

#### Images:
- **Logo**: Max 2MB (PNG, JPG, GIF, SVG)
- **Cover Image**: Max 5MB (PNG, JPG, GIF) - 1200x300px recommended

#### Campaign Content:
- **Goal/Impact Description**: Main campaign description
- **Impact Statement**: Shown below donation amounts

#### Settings:
- **Goal Amount**: Optional fundraising target
- **Start/End Dates**: Optional campaign duration
- **Active**: Show campaign to donors
- **Default**: Use this campaign on donation form

---

## 📊 How It Works:

### Default Campaign
- The campaign marked as "Default" will be used on the donation form
- Only ONE campaign can be default at a time
- Setting a new default automatically unsets the previous one

### Active/Inactive
- **Active**: Visible to donors, can receive donations
- **Inactive**: Hidden from donors (useful for ended campaigns)

### Progress Tracking
- Automatically calculates total donations
- Shows progress bar if goal amount is set
- Displays percentage towards goal

---

## 🎨 Image Guidelines:

### Logo:
- Format: PNG with transparent background recommended
- Size: 150x150px to 300x300px
- Used in campaign cards and headers

### Cover Image:
- Format: JPG or PNG
- Size: 1200x300px (widescreen banner)
- Used as background in donation form header
- Make sure text is readable over the image

---

## 💡 Usage Examples:

### Example 1: Emergency Relief Campaign
```
Name: Jamaica Hurricane Relief 2024
Title: JAMAICA HURRICANE
Subtitle: EMERGENCY RELIEF
Goal: $100,000
Impact: Relief provisions include food, medical aid, clean water and shelter
Active: ✓
Default: ✓
```

### Example 2: Seasonal Campaign
```
Name: Ramadan Food Drive
Title: RAMADAN 2024
Subtitle: FEEDING FAMILIES
Goal: $50,000
Start Date: March 1, 2024
End Date: April 30, 2024
Active: ✓
Default: (leave unchecked)
```

### Example 3: Ongoing Program
```
Name: Education Fund
Title: BUILD SCHOOLS
Subtitle: INVEST IN EDUCATION
Goal: (leave empty for ongoing)
Active: ✓
Default: (leave unchecked)
```

---

## 🔄 Managing Multiple Campaigns:

1. **Create** multiple campaigns for different causes
2. **Activate** the ones currently accepting donations
3. **Set ONE as Default** - this shows on the main donation form
4. **Deactivate** ended campaigns (keeps data but hides from donors)
5. **View Statistics** for each campaign individually

---

## 🗄️ Database Structure:

### campaigns table:
- id, name, slug
- logo, cover_image (file paths)
- title, subtitle, description
- goal_text, impact_text
- goal_amount (optional target)
- is_active, is_default (status flags)
- start_date, end_date (optional)
- timestamps

### Updated donations table:
- Now has `campaign_id` instead of text `campaign` field
- Links to campaigns table
- Allows tracking donations per campaign

---

## 🎯 Next Steps:

1. **Run the migration**
2. **Create your first campaign**
3. **Upload campaign images**
4. **Set it as default**
5. **Test the donation form** - it will show your campaign!

---

## 🔍 Testing:

1. Create a campaign and set as default
2. Go to donation form (http://localhost:8000)
3. You should see:
   - Campaign title and subtitle in header
   - Campaign logo (if uploaded)
   - Campaign cover image as background (if uploaded)
   - Impact text below donation amounts
4. Make a test donation
5. Check admin → Campaign statistics updated!

---

## 📝 Notes:

- **Default Campaign**: Always required! Create at least one active default campaign
- **File Storage**: Images stored in `storage/app/public/campaigns/`
- **Deletion**: Can only delete campaigns with zero donations
- **Progress**: Automatically calculated from completed donations only

---

**Status**: 🟢 Ready to Use!
**Created**: November 8, 2025
