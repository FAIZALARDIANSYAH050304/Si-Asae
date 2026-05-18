# TODO - Add Status Dropdown to Absensi Scan

## Task: Add dropdown select for status in absensi scan page

### Steps:
- [x] 1. Add status dropdown in resources/views/absensi/scan.blade.php
- [x] 2. Update AbsensiController::processScan() to handle status parameter

### Implementation Details:
1. Add Bootstrap form-select dropdown with options:
   - Semua Status (value: semua, default selected)
   - Hadir (value: hadir)
   - Izin (value: izin)
   - Alpha (value: alpha)

2. Update controller:
   - Map `semua` → 'Hadir' (default)
   - Pass status to Absensi::create()
