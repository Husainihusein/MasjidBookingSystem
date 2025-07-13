<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sewa Tapak Booking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* --- Color Definitions for new theme --- */
        /* Primary Green: #0f7571 */
        /* Darker Green: #0a5d5a */
        /* Light Green Background (hover): #e0f7f6 */
        /* Lighter Green Background (today): #c5e8e7 */

        .calendar-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 500;
            border: 1px solid transparent;
            min-height: 40px;
        }

        .calendar-day:hover:not(.disabled) {
            background: #e0f7f6;
            /* Adjusted to new light green */
            border-color: #0f7571;
            /* Adjusted to new primary green */
        }

        .calendar-day.selected {
            background: #0f7571;
            /* Adjusted to new primary green */
            color: white;
            border-color: #0a5d5a;
            /* Adjusted to new darker green */
        }

        .calendar-day.disabled {
            opacity: 0.3;
            cursor: not-allowed;
            color: #9ca3af;
        }

        .calendar-day.other-month {
            opacity: 0.3;
            color: #9ca3af;
        }

        .calendar-day.today {
            background: #c5e8e7;
            /* Adjusted to new lighter green */
            color: #0a5d5a;
            /* Adjusted to new darker green */
            font-weight: 600;
        }

        .calendar-day.booked {
            background-color: #ffcccc;
            /* light red */
            border: 1px solid #ff5e5e;
            /* dark red border */
            color: #a00;
            /* red text */
            cursor: not-allowed;
        }

        .calendar-day.disabled {
            pointer-events: none;
            opacity: 0.5;
        }

        .time-slot {
            background: white;
            border: 2px solid #e5e7eb;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
        }

        .time-slot:hover {
            border-color: #0f7571;
            /* Adjusted to new primary green */
            background: #e0f7f6;
            /* Adjusted to new light green */
        }

        .time-slot.selected {
            border-color: #0f7571;
            /* Adjusted to new primary green */
            background: #0f7571;
            /* Adjusted to new primary green */
            color: white;
        }

        .form-input {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px;
            transition: all 0.2s ease;
            width: 100%;
        }

        .form-input:focus {
            outline: none;
            border-color: #0f7571;
            /* Adjusted to new primary green */
            box-shadow: 0 0 0 3px rgba(15, 117, 113, 0.1);
            /* Adjusted to new primary green rgba */
        }

        .submit-btn {
            background: #0f7571;
            /* Adjusted to new primary green */
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        .submit-btn:hover {
            background: #0a5d5a;
            /* Adjusted to new darker green */
        }

        .submit-btn:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }

        .purpose-card {
            background: white;
            border: 2px solid #e5e7eb;
            padding: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .purpose-card:hover {
            border-color: #0f7571;
            /* Adjusted to new primary green */
            background: #e0f7f6;
            /* Adjusted to new light green */
        }

        .purpose-card.selected {
            border-color: #0f7571;
            /* Adjusted to new primary green */
            background: #0f7571;
            /* Adjusted to new primary green */
            color: white;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid #0f7571;
            /* Adjusted to new primary green */
        }

        .step-indicator {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .step {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e5e7eb;
            color: #6b7280;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 8px;
        }

        .step.active {
            background: #0f7571;
            /* Adjusted to new primary green */
            color: white;
        }

        .step.completed {
            background: #0a5d5a;
            /* Adjusted to new darker green */
            color: white;
        }

        .step-line {
            flex: 1;
            height: 2px;
            background: #e5e7eb;
            margin-right: 8px;
        }

        .step-line.completed {
            background: #0f7571;
            /* Adjusted to new primary green */
        }

        .qr-container {
            background: #e0f7f6;
            /* Adjusted to new light green */
            border: 1px solid #0f7571;
            /* Adjusted to new primary green */
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }

        .qr-image {
            background: white;
            padding: 12px;
            border-radius: 8px;
            display: inline-block;
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
        }

        .qr-image:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* NEW STYLES ADDED BELOW THIS LINE */
        .hero-section {
            background-image: url('https://assets.bharian.com.my/images/articles/IMG_20210409_174437_1618027957.jpg');
            /* Placeholder, replace with actual mosque image if available */
            background-size: cover;
            background-position: center;
            position: relative;
            height: 500px;
            /* As requested */
            display: flex;
            flex-direction: column;
            /* Added for vertical alignment of text and button */
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-bottom: 3rem;
            border-radius: 12px;
            overflow: hidden;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.4);
            /* Transparent black overlay */
            display: flex;
            flex-direction: column;
            /* Added for vertical alignment of text and button */
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .info-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
            /* Added margin for spacing */
        }

        .price-display-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .price-display-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .price-display-card .amount {
            font-size: 2.25rem;
            /* text-4xl */
            font-weight: 700;
            /* font-bold */
            color: #0f7571;
            /* Adjusted to new primary green */
            margin-bottom: 8px;
        }

        .price-display-card .description {
            color: #6b7280;
            font-size: 0.9rem;
        }

        /* SweetAlert2 image responsive class */
        .swal2-image-responsive {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- NEW: Header Section -->
    <header class="bg-white shadow-sm py-4 mb-8 rounded-b-lg">
        <div class="max-w-7xl mx-auto px-6 flex items-center">
            <img src="https://masjidalikhwan.com/storage/logo.jpg" alt="Logo Masjid Al Ikhwan Hulu Bernam" class="h-12 w-12 mr-4 rounded-full shadow-md">
            <h2 class="text-3xl font-extrabold text-gray-800">Masjid Al Ikhwan Hulu Bernam</h2>
        </div>
    </header>

    <!-- NEW: Hero Section -->
    <div class="hero-section">
        <div class="hero-overlay">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 drop-shadow-lg">Sila tempah kemudahan kami untuk majlis istimewa anda.</h1>
            <p class="text-lg md:text-xl font-medium">Pengurusan tempahan yang mudah dan cepat untuk semua keperluan anda.</p>
            <!-- NEW: Start Booking Button -->
            <button id="startBookingBtn" class="mt-8 px-8 py-3 bg-white text-[#0f7571] font-bold rounded-full shadow-lg hover:bg-gray-100 transition transform hover:scale-105">Mula Tempahan</button>
        </div>
    </div>

    <div class="max-w-7xl mx-auto p-6">
        <!-- Laravel Success Message -->
        @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berjaya!',
                    text: "{{ session('success') }}",
                });
            });
        </script>
        @endif

        <!-- NEW: Services/Pricing Section -->
        <div class="info-card">
            <div class="section-title">Harga Sewaan Kemudahan Kami</div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="price-display-card">
                    <div class="font-semibold text-lg text-gray-800 mb-2">Tahlil</div>
                    <div class="amount">RM 50</div>
                    <div class="description">Untuk majlis tahlil dan doa arwah.</div>
                </div>
                <div class="price-display-card">
                    <div class="font-semibold text-lg text-gray-800 mb-2">Kenduri</div>
                    <div class="amount">RM 100</div>
                    <div class="description">Untuk kenduri dan jamuan.</div>
                </div>
                <div class="price-display-card">
                    <div class="font-semibold text-lg text-gray-800 mb-2">Majlis Kahwin</div>
                    <div class="amount">RM 150</div>
                    <div class="description">Untuk majlis perkahwinan.</div>
                </div>
                <div class="price-display-card">
                    <div class="font-semibold text-lg text-gray-800 mb-2">Jualan Tapak</div>
                    <div class="amount">RM 80</div>
                    <div class="description">Untuk sewaan tapak jualan.</div>
                </div>
            </div>
        </div>

        <!-- NEW: Rules and Refund Policy Section -->
        <div class="info-card">
            <div class="section-title">Peraturan Masjid & Polisi Bayaran Balik</div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-gray-700">
                <div>
                    <h3 class="font-semibold text-lg text-gray-800 mb-3">Peraturan dan Garis Panduan Masjid:</h3>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Semua tempahan tertakluk kepada ketersediaan dan kelulusan pihak pengurusan masjid.</li>
                        <li>Sila pastikan kemudahan ditinggalkan dalam keadaan bersih dan kemas selepas digunakan.</li>
                        <li>Dilarang merokok atau menggunakan vape di dalam kawasan masjid.</li>
                        <li>Pakaian yang sopan diperlukan untuk semua pengunjung.</li>
                        <li>Makanan dan minuman hanya dibenarkan di kawasan yang ditetapkan.</li>
                        <li>Sebarang kerosakan harta benda masjid akan dicaj kepada penempah.</li>
                        <li>Sila patuhi slot masa yang diperuntukkan untuk memastikan kelancaran operasi.</li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-lg text-gray-800 mb-3">Polisi Bayaran Balik:</h3>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Deposit sebanyak RM 20 diperlukan untuk mengesahkan tempahan anda. Deposit ini **tidak akan dikembalikan** jika pembatalan dibuat kurang dari 48 jam sebelum waktu yang dijadualkan.</li>
                        <li>Untuk pembatalan yang dibuat lebih dari 48 jam lebih awal, deposit penuh akan dikembalikan.</li>
                        <li>Sekiranya berlaku keadaan yang tidak dijangka atau penutupan masjid, bayaran balik penuh atau pilihan penjadualan semula akan diberikan.</li>
                        <li>Bayaran balik akan diproses dalam tempoh **1-3 hari bekerja**.</li>
                        <li>Sila hubungi pihak pengurusan masjid untuk sebarang pertanyaan berkaitan bayaran balik.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Progress Steps -->
        <div class="step-indicator mb-8">
            <div class="step active" id="step1">1</div>
            <div class="step-line" id="line1"></div>
            <div class="step" id="step2">2</div>
            <div class="step-line" id="line2"></div>
            <div class="step" id="step3">3</div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8" id="bookingSection">
            <!-- Left Side - Calendar & Time -->
            <div class="space-y-6">
                <!-- Calendar -->
                <div class="calendar-container p-6">
                    <div class="section-title">Pilih Tarikh</div>
                    <div class="flex justify-between items-center mb-4">
                        <button id="prevMonth" class="text-gray-600 hover:text-[#0f7571] p-2 rounded-lg transition">
                            ← Sebelumnya
                        </button>
                        <h3 id="currentMonth" class="text-lg font-semibold text-gray-800"></h3>
                        <button id="nextMonth" class="text-gray-600 hover:text-[#0f7571] p-2 rounded-lg transition">
                            Seterusnya →
                        </button>
                    </div>
                    <div class="calendar-grid mb-4">
                        <div class="text-center text-sm font-medium text-gray-600 py-2">Ahad</div>
                        <div class="text-center text-sm font-medium text-gray-600 py-2">Isnin</div>
                        <div class="text-center text-sm font-medium text-gray-600 py-2">Selasa</div>
                        <div class="text-center text-sm font-medium text-gray-600 py-2">Rabu</div>
                        <div class="text-center text-sm font-medium text-gray-600 py-2">Khamis</div>
                        <div class="text-center text-sm font-medium text-gray-600 py-2">Jumaat</div>
                        <div class="text-center text-sm font-medium text-gray-600 py-2">Sabtu</div>
                    </div>
                    <div id="calendarDays" class="calendar-grid"></div>
                </div>

                <!-- Time Slots -->
                <div class="calendar-container p-6" id="timeSlotSection" style="display: none;">
                    <div class="section-title">Pilih Masa</div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="time-slot" data-slot="8:00 AM - 10:00 AM">
                            <div class="font-medium">8:00 PG</div>
                            <div class="text-sm text-gray-600">hingga 10:00 PG</div>
                        </div>
                        <div class="time-slot" data-slot="10:30 AM - 12:30 PM">
                            <div class="font-medium">10:30 PG</div>
                            <div class="text-sm text-gray-600">hingga 12:30 PTG</div>
                        </div>
                        <div class="time-slot" data-slot="2:00 PM - 4:00 PM">
                            <div class="font-medium">2:00 PTG</div>
                            <div class="text-sm text-gray-600">hingga 4:00 PTG</div>
                        </div>
                        <div class="time-slot" data-slot="custom">
                            <div class="font-medium">Masa Tersuai</div>
                            <div class="text-sm text-gray-600">Tetapkan masa anda</div>
                        </div>
                    </div>

                    <div id="customTimeSection" class="grid grid-cols-2 gap-4 mt-4 hidden">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Masa Mula</label>
                            <input type="time" name="start_time" id="start_time" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Masa Tamat</label>
                            <input type="time" name="end_time" id="end_time" class="form-input">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="calendar-container p-6" id="bookingForm" style="display: none;">
                <div class="section-title">Butiran Tempahan</div>

                <!-- Laravel Form with CSRF -->
                <form method="POST" action="{{ route('booking.store') }}" enctype="multipart/form-data" id="mainForm">
                    @csrf

                    <!-- Personal Information -->
                    <div class="space-y-4 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Penuh</label>
                                <input type="text" name="name" class="form-input" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombor IC</label>
                                <input type="text" name="ic" class="form-input" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Emel</label>
                                <input type="email" name="email" class="form-input" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombor Telefon</label>
                                <input type="text" name="phone" class="form-input" required>
                            </div>
                        </div>
                    </div>

                    <!-- Purpose Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Tujuan</label>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="purpose-card" data-purpose="Tahlil">
                                <div class="font-medium">Tahlil</div>
                                <div class="text-sm text-gray-600">RM 50</div>
                            </div>
                            <div class="purpose-card" data-purpose="Kenduri">
                                <div class="font-medium">Kenduri</div>
                                <div class="text-sm text-gray-600">RM 100</div>
                            </div>
                            <div class="purpose-card" data-purpose="Majlis Kahwin">
                                <div class="font-medium">Majlis Kahwin</div>
                                <div class="text-sm text-gray-600">RM 150</div>
                            </div>
                            <div class="purpose-card" data-purpose="Jualan Tapak">
                                <div class="font-medium">Jualan Tapak</div>
                                <div class="text-sm text-gray-600">RM 80</div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden fields for form submission -->
                    <input type="hidden" name="booking_date" id="booking_date">
                    <input type="hidden" name="time_slot" id="time_slot">
                    <input type="hidden" name="purpose" id="purpose">

                    <!-- Bank Details -->
                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombor Akaun Bank Anda</label>
                            <input type="text" name="account_number" class="form-input" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Akaun Bank Masjid</label>
                            <input type="text" value="1234567890 (Maybank)" readonly class="form-input bg-gray-50">
                        </div>
                    </div>

                    <!-- Payment Section -->
                    <div class="qr-container mb-6">
                        <p class="text-sm text-gray-700 mb-3">Pindahkan deposit RM 20 untuk mengesahkan tempahan</p>
                        <button type="button" onclick="showQR()" class="qr-image">
                            <img src="{{ asset('storage/qr-code.png') }}" alt="Kod QR" class="w-24 h-24">
                        </button>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Muat Naik Bukti Pembayaran</label>
                        <input type="file" name="proof_file" accept="image/*,.pdf" class="form-input" required>
                    </div>

                    <div class="mb-6 flex items-center">
                        <input type="checkbox" name="agree" required class="mr-3 w-4 h-4 text-[#0f7571]"> <!-- Adjusted to new primary green -->
                        <label class="text-sm text-gray-700">Saya mengesahkan telah memindahkan deposit RM 20</label>
                    </div>

                    <button type="submit" class="submit-btn">
                        Hantar Tempahan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- NEW: Footer Section -->
    <footer class="bg-white shadow-inner py-6 mt-12 rounded-t-lg">
        <div class="max-w-7xl mx-auto px-6 text-center text-gray-600 text-sm">
            &copy; {{ date('Y') }} Masjid Al Ikhwan Hulu Bernam. Hak Cipta Terpelihara.
        </div>
    </footer>

    <script>
        const approvedDates = @json($approvedDates);

        let selectedDate = null;
        let selectedTimeSlot = null;
        let selectedPurpose = null;
        let currentDate = new Date();

        const monthNames = [
            'Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun',
            'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember'
        ];

        function formatLocalDate(dateObj) {
            return dateObj.getFullYear() + '-' +
                String(dateObj.getMonth() + 1).padStart(2, '0') + '-' +
                String(dateObj.getDate()).padStart(2, '0');
        }

        function generateCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            document.getElementById('currentMonth').textContent = `${monthNames[month]} ${year}`;

            const firstDay = new Date(year, month, 1);
            const startDate = new Date(firstDay);
            startDate.setDate(firstDay.getDate() - firstDay.getDay());

            const calendarDays = document.getElementById('calendarDays');
            calendarDays.innerHTML = '';

            for (let i = 0; i < 42; i++) {
                const currentCalendarDate = new Date(startDate);
                currentCalendarDate.setDate(startDate.getDate() + i);

                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day';
                dayElement.textContent = currentCalendarDate.getDate();

                const dateForComparison = new Date(currentCalendarDate);
                dateForComparison.setHours(0, 0, 0, 0);
                const formattedDate = formatLocalDate(currentCalendarDate);

                if (currentCalendarDate.getMonth() !== month) {
                    dayElement.classList.add('other-month');
                } else if (dateForComparison < today) {
                    dayElement.classList.add('disabled');
                } else if (approvedDates.includes(formattedDate)) {
                    dayElement.classList.add('booked');
                    dayElement.classList.add('disabled');
                } else if (dateForComparison.getTime() === today.getTime()) {
                    dayElement.classList.add('today');
                }

                if (currentCalendarDate.getMonth() === month && dateForComparison >= today && !approvedDates.includes(formattedDate)) {
                    dayElement.addEventListener('click', function() {
                        document.querySelectorAll('.calendar-day.selected').forEach(el =>
                            el.classList.remove('selected')
                        );

                        this.classList.add('selected');
                        selectedDate = new Date(currentCalendarDate);

                        const selectedFormatted = formatLocalDate(selectedDate);
                        document.getElementById('booking_date').value = selectedFormatted;

                        document.getElementById('step1').classList.add('completed');
                        document.getElementById('step1').classList.remove('active');
                        document.getElementById('line1').classList.add('completed');
                        document.getElementById('step2').classList.add('active');

                        document.getElementById('timeSlotSection').style.display = 'block';
                        document.getElementById('timeSlotSection').scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    });
                }

                calendarDays.appendChild(dayElement);
            }
        }

        function handleCustomTime() {
            const startTime = document.getElementById('start_time').value;
            const endTime = document.getElementById('end_time').value;

            if (startTime && endTime) {
                const customSlot = `${formatTime(startTime)} - ${formatTime(endTime)}`;
                document.getElementById('time_slot').value = customSlot;
                return true;
            }
            return false;
        }

        function formatTime(time24) {
            const [hours, minutes] = time24.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const hour12 = hour % 12 || 12;
            return `${hour12}:${minutes} ${ampm}`;
        }

        document.querySelectorAll('.time-slot').forEach(slot => {
            slot.addEventListener('click', function() {
                document.querySelectorAll('.time-slot.selected').forEach(el =>
                    el.classList.remove('selected')
                );
                this.classList.add('selected');
                selectedTimeSlot = this.dataset.slot;

                if (selectedTimeSlot === 'custom') {
                    document.getElementById('customTimeSection').classList.remove('hidden');
                    document.getElementById('start_time').required = true;
                    document.getElementById('end_time').required = true;

                    document.getElementById('start_time').addEventListener('change', handleCustomTime);
                    document.getElementById('end_time').addEventListener('change', handleCustomTime);
                } else {
                    document.getElementById('customTimeSection').classList.add('hidden');
                    document.getElementById('start_time').required = false;
                    document.getElementById('end_time').required = false;
                    document.getElementById('time_slot').value = selectedTimeSlot;
                }

                document.getElementById('step2').classList.add('completed');
                document.getElementById('step2').classList.remove('active');
                document.getElementById('line2').classList.add('completed');
                document.getElementById('step3').classList.add('active');

                document.getElementById('bookingForm').style.display = 'block';
                document.getElementById('bookingForm').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });

        document.querySelectorAll('.purpose-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.purpose-card.selected').forEach(el =>
                    el.classList.remove('selected')
                );
                this.classList.add('selected');
                selectedPurpose = this.dataset.purpose;
                document.getElementById('purpose').value = selectedPurpose;
            });
        });

        document.getElementById('prevMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            generateCalendar();
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            generateCalendar();
        });

        function showQR() {
            Swal.fire({
                title: 'Imbas untuk Membayar',
                imageUrl: "{{ asset('storage/qr-code.png') }}",
                imageAlt: 'Kod QR',
                imageClass: 'swal2-image-responsive',
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#0f7571'
            });
        }

        document.getElementById('mainForm').addEventListener('submit', function(e) {
            if (!selectedDate || !selectedTimeSlot || !selectedPurpose) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Tempahan Tidak Lengkap',
                    text: 'Sila pilih tarikh, masa, dan tujuan sebelum menghantar.',
                    confirmButtonColor: '#0f7571'
                });
                return;
            }

            if (selectedTimeSlot === 'custom') {
                if (!handleCustomTime()) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Masa Tidak Sah',
                        text: 'Sila tetapkan masa mula dan masa tamat.',
                        confirmButtonColor: '#0f7571'
                    });
                    return;
                }
            }
        });

        document.getElementById('startBookingBtn').addEventListener('click', function() {
            document.getElementById('bookingSection').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            generateCalendar();
        });
    </script>



</body>

</html>