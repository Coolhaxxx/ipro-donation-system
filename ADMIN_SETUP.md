# Admin Dashboard Setup Guide

## ✅ What's Been Created:

### Backend
- ✅ AdminMiddleware for authentication
- ✅ Admin AuthController (login/logout)
- ✅ Admin DashboardController (all admin functions)
- ✅ Migration to add is_admin column to users

### Frontend Views
- ✅ Admin Login Page
- ✅ Admin Dashboard (with statistics)
- ✅ Donations List (with filters)
- ✅ Donation Details
- ✅ Donors List
- ✅ Donor Details (with donation history)

### Routes
- ✅ `/admin/login` - Admin login
- ✅ `/admin/dashboard` - Main dashboard
- ✅ `/admin/donations` - All donations
- ✅ `/admin/donations/{id}` - Donation details
- ✅ `/admin/donors` - All donors
- ✅ `/admin/donors/{id}` - Donor details

---

## 🚀 Setup Instructions:

### Step 1: Run the Migration
```bash
php artisan migrate
```

This will add the `is_admin` column to the users table.

### Step 2: Create an Admin User

Open your terminal and run:

```bash
php artisan tinker
```

Then run these commands in tinker:

```php
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@ipro.com';
$user->password = bcrypt('admin123');
$user->is_admin = true;
$user->save();
exit
```

**Your Admin Credentials:**
- Email: `admin@ipro.com`
- Password: `admin123`

⚠️ **IMPORTANT:** Change this password after first login!

### Step 3: Access Admin Dashboard

1. Go to: **http://localhost:8000/admin/login**
2. Login with the credentials above
3. You'll be redirected to the dashboard!

---

## 📊 Admin Dashboard Features:

### Dashboard (Home)
- Total donations amount
- Total donors count
- Pending donations count
- Completed donations count
- Donations by payment method (Cash, Check, Online)
- Donations by type (Zakat, Sadaqah, General)
- Recent donations table

### Donations Page
**Features:**
- View all donations in a table
- Filter by:
  - Search (donor name/email)
  - Status (pending/completed/failed)
  - Payment method (cash/check/online)
  - Donation type (zakat/sadaqah/general)
- Update donation status (dropdown)
- View donation details
- Pagination (20 per page)

### Donation Details Page
- Full donation information
- Donor information
- Update status form
- Check photo (if check payment)
- Bank details (if check payment)
- Transaction ID (if online payment)
- Link to donor profile

### Donors Page
**Features:**
- View all donors in a table
- Search by name, email, or phone
- See total donations per donor
- See donation count per donor
- View donor details
- Pagination (20 per page)

### Donor Details Page
- Full donor profile
- Contact information
- Address
- Member since date
- Statistics (total donated, number of donations)
- Complete donation history
- Links to each donation detail

---

## 🎨 Navigation Features:

- Top navigation bar with links to:
  - Dashboard
  - Donations
  - Donors
- Quick link to view donation form (opens in new tab)
- User email display
- Logout button

---

## 🔐 Security:

- Admin middleware protects all admin routes
- Only users with `is_admin = true` can access
- Session-based authentication
- CSRF protection on all forms
- Secure logout functionality

---

## 📝 Quick Actions:

### Update Donation Status:
1. Go to Donations page
2. Use dropdown in the Status column
3. Status updates automatically on change

### View Check Photos:
1. Go to Donation Details
2. If check payment, photo is displayed
3. Click "View Full Size" for larger view

### Search Donors:
1. Go to Donors page
2. Enter name, email, or phone in search box
3. Click Search button

### Filter Donations:
1. Go to Donations page
2. Use filter dropdowns
3. Click "Apply Filters"
4. Click "Clear" to reset

---

## 🎯 Test It Now!

1. **Login:**
   ```
   http://localhost:8000/admin/login
   Email: admin@ipro.com
   Password: admin123
   ```

2. **View Dashboard:**
   - See all statistics
   - View recent donations

3. **Manage Donations:**
   - Go to Donations page
   - Update statuses
   - View details

4. **View Donors:**
   - See all donors
   - Check donation history

---

## 🔧 Customization Tips:

### Change Admin Email/Password:
1. Login to admin
2. Run in tinker:
```php
$user = App\Models\User::where('email', 'admin@ipro.com')->first();
$user->email = 'newemail@example.com';
$user->password = bcrypt('newpassword');
$user->save();
```

### Add More Admin Users:
```php
$user = new App\Models\User();
$user->name = 'Second Admin';
$user->email = 'admin2@ipro.com';
$user->password = bcrypt('password');
$user->is_admin = true;
$user->save();
```

---

## 📱 Responsive Design:

- ✅ Works on desktop
- ✅ Works on tablets
- ✅ Works on mobile devices
- ✅ Collapsible navigation on small screens

---

## ✨ Next Enhancements (Optional):

1. Export donations to CSV/Excel
2. Email notifications for new donations
3. Advanced analytics and charts
4. Print receipts
5. Bulk status updates
6. Date range filters
7. User roles (super admin, regular admin)

---

**Status**: 🟢 Ready to Use!
**Date**: November 8, 2025
