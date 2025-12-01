# 📸 Camera Scan & OCR Feature Documentation

## 📋 Feature Overview
This feature allows donors to scan their physical check using their device's camera. The system automatically:
1.  **Captures** a high-quality image of the check.
2.  **Attaches** the image to the form (replacing manual upload).
3.  **Reads** the text on the check using OCR (Optical Character Recognition).
4.  **Auto-fills** the Routing Number, Account Number, and Check Number fields.

---

## ⚙️ Technical Implementation

### 1. Libraries Used
*   **Tesseract.js (v2.1.0):** A pure JavaScript OCR library that runs in the browser. It does not require sending images to a third-party server for processing, ensuring privacy.
    *   *CDN:* `https://unpkg.com/tesseract.js@v2.1.0/dist/tesseract.min.js`

### 2. Key Components
*   **Camera Access:** Uses the modern `navigator.mediaDevices.getUserMedia` API.
    *   Configured with `facingMode: 'environment'` to prefer the rear camera on mobile devices.
*   **Image Capture:** Draws the video feed frame onto an HTML5 Canvas.
*   **File Conversion:** Converts the Canvas blob into a standard JavaScript `File` object and assigns it to the `input[type="file"]` using the `DataTransfer` API. This ensures the backend receives it exactly like a normal file upload.
*   **Data Extraction Logic:**
    *   **Routing Number:** Looks for 9-digit sequences, prioritizing those starting with 0, 1, 2, or 3 (standard US routing format).
    *   **Account Number:** Looks for 8-12 digit sequences that are *not* the routing number.
    *   **Check Number:** Looks for isolated 3-6 digit numbers.

---

## 🚀 How to Use

1.  Navigate to the **Donation Page**.
2.  Select **"Check"** as the payment method.
3.  Click the blue **"Scan Check"** button next to the file upload field.
4.  **Allow Camera Permissions** if prompted by the browser.
5.  Align the check within the frame on the screen.
6.  Click **"Capture & Scan"**.
7.  Wait a few seconds for "Processing...".
8.  Once complete, the modal closes, the image is attached, and the bank details are filled in automatically.

---

## ⚠️ Requirements & Limitations

### 1. HTTPS Required
*   Browsers **block camera access** on insecure connections (HTTP).
*   **Localhost:** Works fine.
*   **Production:** Your site MUST be served over **HTTPS** (e.g., `https://laravel.freshnmore.com.pk`).

### 2. Image Quality
*   OCR accuracy depends heavily on lighting and focus.
*   Ensure the check is well-lit and text is clear.
*   Handwritten text is difficult for OCR to read; this feature works best for the printed numbers at the bottom of the check (MICR line).

### 3. Browser Support
*   Works on all modern browsers (Chrome, Firefox, Safari, Edge) on Desktop and Mobile (iOS/Android).

---

## 🔧 Troubleshooting

| Issue | Possible Cause | Solution |
|-------|----------------|----------|
| **"Could not access camera"** | Permission denied or HTTP site. | Check browser permissions. Ensure URL starts with `https://`. |
| **"Error reading text"** | Network issue loading Tesseract. | Check internet connection. Tesseract downloads language data on first run. |
| **Wrong numbers filled** | Blurry image or complex background. | Retake photo with better lighting. Verify numbers manually. |
| **Camera is black** | Another app is using the camera. | Close other apps (Zoom, Teams, etc.) and refresh. |

---

## 💻 Code Reference
*   **File:** `resources/views/donation/form.blade.php`
*   **Section:** `@push('scripts')` (Javascript logic) and the `Camera Modal` HTML block.
