<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <title>{{ $status === 'approved' ? 'Tempahan Anda Diluluskan' : 'Tempahan Tidak Diluluskan' }}</title>
</head>

<body style="font-family: sans-serif; background-color: #f9f9f9; padding: 20px; color: #333;">
    <div style="max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 8px;">

        <!-- =======================
        Header Section: Logo
        ======================== -->
        <div style="text-align: center;">
            <img src="https://masjidalikhwan.com/storage/logo.jpg" alt="Logo Masjid" style="max-width: 100px; margin-bottom: 20px;">
        </div>

        <p>Assalamualaikum warahmatullahi wabarakatuh,</p>

        <!-- =======================
        If booking is approved
        ======================== -->
        @if ($status === 'approved')
        <p>Terima kasih <strong>{{ $booking->name }}</strong>, permohonan tempahan anda telah <strong>diluluskan oleh pihak pentadbiran masjid</strong>.</p>

        <!-- Booking details list -->
        <p>Berikut adalah butiran tempahan anda:</p>
        <ul style="list-style-type: none; padding-left: 0;">
            <li><strong>Tarikh:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}</li>
            <li><strong>Masa:</strong> {{ $booking->start_time }} - {{ $booking->end_time }}</li>
            <li><strong>Tujuan:</strong> {{ $booking->purpose }}</li>
            <li><strong>No. Tempahan:</strong> #{{ $booking->id }}</li>
        </ul>

        <!-- Contact info -->
        <p>Sila hubungi pihak masjid di nombor berikut untuk perbincangan lanjut atau persiapan:</p>
        <p><strong>📞 Encik Saiful (Admin): +60 12-345 6789</strong></p>

        <p>Semoga urusan anda dipermudahkan.</p>

        <!-- =======================
        If booking is rejected
        ======================== -->
        @else
        <p>Terima kasih <strong>{{ $booking->name }}</strong>, dukacita dimaklumkan bahawa permohonan tempahan anda <strong>tidak dapat diluluskan</strong> buat masa ini.</p>

        <!-- Reason for rejection -->
        @if ($booking->rejection_reason)
        <p><strong>Sebab Penolakan:</strong></p>
        <div style="background-color: #f3f4f6; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            {{ $booking->rejection_reason }}
        </div>
        @endif

        <!-- Refund proof link -->
        @if ($booking->refund_proof)
        <p><strong>Bukti Pemulangan Bayaran:</strong></p>
        <p>
            <a href="{{ asset('storage/' . $booking->refund_proof) }}" target="_blank" style="color: #2563eb;">
                Klik di sini untuk lihat bukti pemulangan
            </a>
        </p>
        @endif

        <!-- Contact info -->
        <p>Jika anda ingin mendapatkan maklumat lanjut, sila hubungi:</p>
        <p><strong>📞 Encik Saiful (Admin): +60 12-345 6789</strong></p>

        <p>Mohon maaf atas segala kesulitan.</p>
        @endif

        <!-- =======================
        Footer Section
        ======================== -->
        <p style="margin-top: 40px;">Wassalam,<br><strong>Encik Saiful</strong><br>Pengurusan Tempahan Masjid</p>
    </div>
</body>

</html>