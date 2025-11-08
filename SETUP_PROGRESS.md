# iPro - Setup Progress

## ✅ Completed Steps

### 1. Database Configuration
- Database name: `ipro`
- User: `root`
- Password: (empty)
- `.env` file configured

### 2. Migrations Created (3 custom tables)
✅ `2025_11_08_000003_create_donors_table.php`
✅ `2025_11_08_000004_create_donations_table.php`
✅ `2025_11_08_000005_create_payment_transactions_table.php`

### 3. Models Created
✅ `app/Models/Donor.php` - With relationships and helper methods
✅ `app/Models/Donation.php` - With scopes and formatted attributes
✅ `app/Models/PaymentTransaction.php` - With Stripe integration methods

---

## 📋 Next Steps (Run These Commands)

### Step 1: Create Database
Open phpMyAdmin: http://localhost/phpmyadmin
- Create new database: `ipro`
- Collation: `utf8mb4_unicode_ci`

### Step 2: Run Migrations
```bash
cd D:\laravel\ipro
php artisan migrate
```

This will create 6 tables:
- users
- cache  
- jobs
- **donors** (custom)
- **donations** (custom)
- **payment_transactions** (custom)

### Step 3: Verify Tables
```bash
php artisan migrate:status
```

You should see all migrations marked as "Ran".

---

## 📊 Database Schema Overview

### Donors Table
- id
- name
- email (unique)
- phone (indexed)
- street_address
- city
- state
- zip
- timestamps

### Donations Table
- id
- donor_id (foreign key)
- amount (decimal)
- donation_type (zakat/sadaqah/general)
- payment_method (cash/check/online)
- payment_status (pending/completed/failed)
- check_number (nullable)
- check_photo (nullable)
- bank_name (nullable)
- account_number (nullable)
- routing_number (nullable)
- transaction_id (nullable)
- campaign
- notes (nullable)
- timestamps

### Payment Transactions Table
- id
- donation_id (foreign key)
- stripe_payment_intent_id (nullable)
- stripe_charge_id (nullable)
- amount (decimal)
- status
- payment_method_details (JSON)
- receipt_url (nullable)
- error_message (nullable)
- timestamps

---

## 🎯 What's Next After Migration?

1. **Create Controllers** - Handle form submissions and payment processing
2. **Create Routes** - Define URL endpoints
3. **Create Views** - Build the donation form UI
4. **Install Stripe** - Add payment gateway integration
5. **Test Features** - Test each payment method

---

## 🔑 Model Relationships

```
Donor
  └─ hasMany → Donations
                  └─ hasOne → PaymentTransaction
```

## 🎨 Useful Model Methods

### Donor Model
```php
// Find donor by email or phone
Donor::findByEmailOrPhone('email@example.com', '123-456-7890');

// Get total donations
$donor->total_donations;

// Get donation count
$donor->donation_count;
```

### Donation Model
```php
// Query completed donations
Donation::completed()->get();

// Query by type
Donation::ofType('zakat')->get();

// Query by payment method
Donation::byPaymentMethod('online')->get();

// Get formatted amount
$donation->formatted_amount; // Returns: $1,000.00

// Get readable type
$donation->donation_type_name; // Returns: "Zakat"
```

### PaymentTransaction Model
```php
// Query successful transactions
PaymentTransaction::successful()->get();

// Check if successful
$transaction->isSuccessful(); // Returns: true/false
```

---

**Status**: Ready for migration
**Date**: November 8, 2025
