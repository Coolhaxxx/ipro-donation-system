@extends('layouts.app')

@section('title', 'Make a Donation - Jamaica Hurricane Emergency Relief')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-900 to-blue-800" x-data="donationForm()">
    
    <!-- Header Section -->
    <div class="bg-cover bg-center py-12 px-4" style="background-image: url('https://via.placeholder.com/1200x300/1e3a8a/ffffff?text=Jamaica+Hurricane+Emergency+Relief');">
        <div class="max-w-6xl mx-auto text-center">
            <div class="flex items-center justify-center mb-4">
                <div class="bg-white rounded-full p-4">
                    <svg class="w-12 h-12 text-blue-900" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16zM9 9a1 1 0 112 0v4a1 1 0 11-2 0V9zm1-5a1 1 0 100 2 1 1 0 000-2z"/>
                    </svg>
                </div>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-2">JAMAICA HURRICANE</h1>
            <h2 class="text-3xl md:text-4xl font-bold text-red-500">EMERGENCY RELIEF</h2>
            <p class="text-white mt-4 text-lg">Helping Hand for Relief and Development</p>
        </div>
    </div>

    <!-- Main Form Container -->
    <div class="max-w-6xl mx-auto px-4 py-8">
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('donation.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">
                
                <!-- LEFT COLUMN -->
                <div class="space-y-6">
                    
                    <!-- Personal Information Section -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
                            <span class="text-blue-900">PERSONAL</span> <span class="text-blue-400">INFORMATION</span>
                        </h3>
                        
                        <div class="space-y-4">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">NAME *</label>
                                <input type="text" name="name" x-model="donor.name" required
                                    class="w-full px-4 py-2 border-2 border-blue-900 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Full Name">
                            </div>

                            <!-- Email with Auto-Populate -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">EMAIL *</label>
                                <input type="email" name="email" x-model="donor.email" 
                                    @blur="checkExistingDonor()" required
                                    class="w-full px-4 py-2 border-2 border-blue-900 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="email@example.com">
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">PHONE *</label>
                                <input type="tel" name="phone" x-model="donor.phone" 
                                    @blur="checkExistingDonor()" required
                                    class="w-full px-4 py-2 border-2 border-blue-900 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="(123) 456-7890">
                            </div>

                            <!-- Address -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">STREET ADDRESS *</label>
                                <input type="text" name="street_address" x-model="donor.street_address" required
                                    class="w-full px-4 py-2 border-2 border-blue-900 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Street Address">
                            </div>

                            <!-- City, State, ZIP -->
                            <div class="grid grid-cols-3 gap-3">
                                <div class="col-span-1">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">CITY *</label>
                                    <input type="text" name="city" x-model="donor.city" required
                                        class="w-full px-4 py-2 border-2 border-blue-900 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">STATE *</label>
                                    <input type="text" name="state" x-model="donor.state" required
                                        class="w-full px-4 py-2 border-2 border-blue-900 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">ZIP *</label>
                                    <input type="text" name="zip" x-model="donor.zip" required
                                        class="w-full px-4 py-2 border-2 border-blue-900 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>

                            <!-- Returning Donor Indicator -->
                            <div x-show="isReturningDonor" x-cloak class="bg-green-50 border border-green-200 rounded p-3">
                                <p class="text-green-700 text-sm font-semibold">✓ Welcome back! Your information has been auto-filled.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information Section -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
                            <span class="text-blue-900">PAYMENT</span> <span class="text-blue-400">INFORMATION</span>
                        </h3>
                        
                        <div class="space-y-4">
                            <!-- Payment Method Selection -->
                            <div class="flex gap-4">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="payment_method" value="cash" x-model="paymentMethod" required
                                        class="w-5 h-5 text-blue-600">
                                    <span class="ml-2 font-semibold">Cash</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="payment_method" value="check" x-model="paymentMethod" required
                                        class="w-5 h-5 text-blue-600">
                                    <span class="ml-2 font-semibold">Check</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="payment_method" value="online" x-model="paymentMethod" required
                                        class="w-5 h-5 text-blue-600">
                                    <span class="ml-2 font-semibold">Online</span>
                                </label>
                            </div>

                            <!-- Card Brand Icons (for online payment) -->
                            <div x-show="paymentMethod === 'online'" x-cloak class="flex gap-2">
                                <span class="text-xs text-gray-600">We accept:</span>
                                <span class="text-xs font-semibold">VISA • MasterCard • Amex • Discover</span>
                            </div>

                            <!-- Check Payment Fields -->
                            <div x-show="paymentMethod === 'check'" x-cloak class="space-y-4 border-t pt-4">
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">CC/CHECK # *</label>
                                        <input type="text" name="check_number"
                                            class="w-full px-4 py-2 border-2 border-blue-900 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">CVC</label>
                                        <input type="text" name="cvc"
                                            class="w-full px-4 py-2 border-2 border-blue-900 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>

                                <!-- Check Photo Upload -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">UPLOAD CHECK PHOTO *</label>
                                    <div class="flex gap-2">
                                        <input type="file" name="check_photo" accept="image/*"
                                            class="w-full px-4 py-2 border-2 border-blue-900 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <button type="button" @click="openCamera()" 
                                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center whitespace-nowrap">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Scan Check
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Take a photo of your check (max 5MB)</p>
                                </div>

                                <!-- Camera Modal -->
                                <div x-show="showCameraModal" x-cloak 
                                    class="fixed inset-0 z-50 overflow-y-auto" 
                                    aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        
                                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                                            @click="closeCamera()" aria-hidden="true"></div>

                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="mt-3 text-center sm:mt-0 sm:text-left">
                                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                        Scan Check
                                                    </h3>
                                                    <div class="mt-4 relative bg-black rounded-lg overflow-hidden aspect-video">
                                                        <video x-ref="videoFeed" autoplay playsinline class="w-full h-full object-cover"></video>
                                                        
                                                        <!-- Guide Overlay -->
                                                        <div class="absolute inset-0 border-2 border-white opacity-50 m-8 rounded pointer-events-none"></div>
                                                        <div class="absolute bottom-4 left-0 right-0 text-center text-white text-sm font-semibold drop-shadow-md" x-text="scanStatus"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                <button type="button" @click="captureAndScan()" 
                                                    :disabled="isScanning"
                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                                                    <span x-show="!isScanning">Capture & Scan</span>
                                                    <span x-show="isScanning">Processing...</span>
                                                </button>
                                                <button type="button" @click="closeCamera()" 
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bank Information -->
                                <div class="bg-gray-50 p-4 rounded">
                                    <h4 class="font-bold text-gray-800 mb-3">BANK INFORMATION</h4>
                                    <div class="space-y-3">
                                        <input type="text" name="bank_name" placeholder="Bank Name"
                                            class="w-full px-4 py-2 border-2 border-blue-900 rounded">
                                        <input type="text" name="account_number" placeholder="Account #"
                                            class="w-full px-4 py-2 border-2 border-blue-900 rounded">
                                        <input type="text" name="routing_number" placeholder="Routing #"
                                            class="w-full px-4 py-2 border-2 border-blue-900 rounded">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN -->
                <div class="space-y-6">
                    
                    <!-- Pledge Amounts Section -->
                    <div class="bg-red-600 rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold text-white mb-4">PLEDGE AMOUNTS</h3>
                        
                        <div class="space-y-3">
                            <!-- $10,000 -->
                            <label class="flex items-center justify-between bg-white hover:bg-gray-50 p-3 rounded cursor-pointer transition">
                                <div class="flex items-center">
                                    <input type="radio" name="amount_option" value="10000" x-model="selectedAmount"
                                        class="w-5 h-5 text-red-600">
                                    <span class="ml-3 font-bold text-xl">$10,000</span>
                                </div>
                                <span class="text-sm text-gray-600">Support 1,000 Persons</span>
                            </label>

                            <!-- $5,000 -->
                            <label class="flex items-center justify-between bg-white hover:bg-gray-50 p-3 rounded cursor-pointer transition">
                                <div class="flex items-center">
                                    <input type="radio" name="amount_option" value="5000" x-model="selectedAmount"
                                        class="w-5 h-5 text-red-600">
                                    <span class="ml-3 font-bold text-xl">$5,000</span>
                                </div>
                                <span class="text-sm text-gray-600">Support 500 Persons</span>
                            </label>

                            <!-- $2,500 -->
                            <label class="flex items-center justify-between bg-white hover:bg-gray-50 p-3 rounded cursor-pointer transition">
                                <div class="flex items-center">
                                    <input type="radio" name="amount_option" value="2500" x-model="selectedAmount"
                                        class="w-5 h-5 text-red-600">
                                    <span class="ml-3 font-bold text-xl">$2,500</span>
                                </div>
                                <span class="text-sm text-gray-600">Support 250 Persons</span>
                            </label>

                            <!-- $1,000 -->
                            <label class="flex items-center justify-between bg-white hover:bg-gray-50 p-3 rounded cursor-pointer transition">
                                <div class="flex items-center">
                                    <input type="radio" name="amount_option" value="1000" x-model="selectedAmount"
                                        class="w-5 h-5 text-red-600">
                                    <span class="ml-3 font-bold text-xl">$1,000</span>
                                </div>
                                <span class="text-sm text-gray-600">Support 100 Persons</span>
                            </label>

                            <!-- $500 -->
                            <label class="flex items-center justify-between bg-white hover:bg-gray-50 p-3 rounded cursor-pointer transition">
                                <div class="flex items-center">
                                    <input type="radio" name="amount_option" value="500" x-model="selectedAmount"
                                        class="w-5 h-5 text-red-600">
                                    <span class="ml-3 font-bold text-xl">$500</span>
                                </div>
                                <span class="text-sm text-gray-600">Support 50 Persons</span>
                            </label>

                            <!-- Other Amount -->
                            <div class="bg-white p-3 rounded">
                                <label class="flex items-center mb-2">
                                    <input type="radio" name="amount_option" value="custom" x-model="selectedAmount"
                                        class="w-5 h-5 text-red-600">
                                    <span class="ml-3 font-bold">OTHER AMOUNT</span>
                                </label>
                                <input type="number" x-model="customAmount" @input="selectedAmount = 'custom'"
                                    class="w-full px-4 py-2 border-2 border-gray-300 rounded focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                    placeholder="Enter custom amount" min="1" step="0.01">
                            </div>
                        </div>

                        <input type="hidden" name="amount" :value="finalAmount">

                        <p class="text-white text-xs mt-4">Relief provisions include food, medical aid, clean water and shelter supplies</p>
                    </div>

                    <!-- The Intent Section -->
                    <div class="bg-blue-900 rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold text-white mb-4">THE INTENT</h3>
                        
                        <div class="space-y-3">
                            <label class="flex items-center text-white cursor-pointer">
                                <input type="radio" name="donation_type" value="zakat" required
                                    class="w-5 h-5 text-blue-600">
                                <span class="ml-3 font-semibold">ZAKAT</span>
                            </label>
                            <label class="flex items-center text-white cursor-pointer">
                                <input type="radio" name="donation_type" value="sadaqah" required
                                    class="w-5 h-5 text-blue-600">
                                <span class="ml-3 font-semibold">SADAQAH</span>
                            </label>
                            <label class="flex items-center text-white cursor-pointer">
                                <input type="radio" name="donation_type" value="general" required
                                    class="w-5 h-5 text-blue-600">
                                <span class="ml-3 font-semibold">DONATION</span>
                            </label>
                        </div>

                        <div class="mt-4 flex items-center text-white text-sm">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a8 8 0 100 16 8 8 0 000-16zM9 9a1 1 0 112 0v4a1 1 0 11-2 0V9zm1-5a1 1 0 100 2 1 1 0 000-2z"/>
                            </svg>
                            <span>Zakat/Sadaqah Eligible</span>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" 
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-12 rounded-lg text-xl shadow-lg transition transform hover:scale-105">
                    DONATE NOW
                </button>
            </div>

        </form>

        <!-- Footer -->
        <div class="text-center text-white mt-8 text-sm">
            <p>1-888-808-4357 (HELP) | HHRD.org</p>
            <p class="mt-2">Helping Hand USA is a 501(c)(3) global humanitarian relief and development organization</p>
            <p>Tax ID: 31-1628040</p>
        </div>

    </div>
</div>

@push('scripts')
<script src='https://unpkg.com/tesseract.js@v2.1.0/dist/tesseract.min.js'></script>
<script>
function donationForm() {
    return {
        donor: {
            name: '',
            email: '',
            phone: '',
            street_address: '',
            city: '',
            state: '',
            zip: ''
        },
        isReturningDonor: false,
        paymentMethod: 'cash',
        selectedAmount: '500',
        customAmount: '',
        
        // Camera & OCR State
        showCameraModal: false,
        cameraStream: null,
        isScanning: false,
        scanStatus: 'Ready to scan',
        
        get finalAmount() {
            if (this.selectedAmount === 'custom') {
                return this.customAmount || 0;
            }
            return this.selectedAmount;
        },
        
        async checkExistingDonor() {
            if (!this.donor.email && !this.donor.phone) return;
            
            try {
                const response = await fetch('{{ route("donation.check") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        email: this.donor.email,
                        phone: this.donor.phone
                    })
                });
                
                const data = await response.json();
                
                if (data.exists) {
                    this.donor = data.donor;
                    this.isReturningDonor = true;
                }
            } catch (error) {
                console.error('Error checking donor:', error);
            }
        },

        // --- Camera & OCR Functions ---

        async openCamera() {
            this.showCameraModal = true;
            this.scanStatus = 'Starting camera...';
            try {
                this.cameraStream = await navigator.mediaDevices.getUserMedia({ 
                    video: { facingMode: 'environment' } // Prefer back camera on mobile
                });
                this.$refs.videoFeed.srcObject = this.cameraStream;
                this.scanStatus = 'Align check within the frame';
            } catch (err) {
                console.error("Camera Error:", err);
                this.scanStatus = 'Error: Could not access camera. Please allow permissions.';
            }
        },

        closeCamera() {
            this.showCameraModal = false;
            if (this.cameraStream) {
                this.cameraStream.getTracks().forEach(track => track.stop());
                this.cameraStream = null;
            }
        },

        async captureAndScan() {
            this.isScanning = true;
            this.scanStatus = 'Capturing image...';

            const video = this.$refs.videoFeed;
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Convert to file for upload
            canvas.toBlob((blob) => {
                const file = new File([blob], "scanned_check.jpg", { type: "image/jpeg" });
                
                // Set file input manually
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                document.querySelector('input[name="check_photo"]').files = dataTransfer.files;
            }, 'image/jpeg');

            this.scanStatus = 'Reading text (this may take a moment)...';

            try {
                const result = await Tesseract.recognize(
                    canvas,
                    'eng',
                    { logger: m => console.log(m) }
                );

                this.processScannedText(result.data.text);
                this.scanStatus = 'Scan complete!';
                setTimeout(() => this.closeCamera(), 1500);

            } catch (err) {
                console.error("OCR Error:", err);
                this.scanStatus = 'Error reading text. Please try again.';
            } finally {
                this.isScanning = false;
            }
        },

        processScannedText(text) {
            console.log("Scanned Text:", text);
            // Basic cleanup
            const cleanText = text.replace(/[^a-zA-Z0-9\s\:\<\>]/g, '');

            // Try to find MICR line data (Routing, Account, Check #)
            // This is a basic heuristic and might need adjustment based on check format
            
            // Routing Number: Usually 9 digits bracketed by |: symbols (often read as T, :, or A by OCR)
            const routingRegex = /[0-9]{9}/g;
            const potentialNumbers = cleanText.match(routingRegex);

            if (potentialNumbers) {
                // Heuristic: Routing numbers often start with 0, 1, 2, 3
                const routing = potentialNumbers.find(num => ['0','1','2','3'].includes(num[0]));
                if (routing) document.querySelector('input[name="routing_number"]').value = routing;
            }

            // Attempt to find Account Number (variable length, usually follows routing)
            // This is tricky with regex alone, but we can try to find long number strings
            const accountRegex = /[0-9]{8,12}/g;
            const potentialAccounts = cleanText.match(accountRegex);
            
            if (potentialAccounts) {
                // Pick the longest one that isn't the routing number
                const currentRouting = document.querySelector('input[name="routing_number"]').value;
                const account = potentialAccounts.find(num => num !== currentRouting);
                if (account) document.querySelector('input[name="account_number"]').value = account;
            }

            // Attempt to find Check Number (usually 3-6 digits, often at end or beginning)
            const checkNumRegex = /\b[0-9]{3,6}\b/g;
            const potentialCheckNums = cleanText.match(checkNumRegex);
            if (potentialCheckNums) {
                // Just pick the first one found for now
                document.querySelector('input[name="check_number"]').value = potentialCheckNums[0];
            }

            alert("Scan complete! Please verify the auto-filled details.");
        }
    }
}
</script>
@endpush

@endsection
