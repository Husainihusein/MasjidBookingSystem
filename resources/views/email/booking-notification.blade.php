<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New Booking Notification</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <div style="max-width: 600px; margin: auto; background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">

        <!-- Logo -->
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="https://masjidalikhwan.com/storage/logo.jpg" alt="Mosque Logo" style="max-height: 80px;">
        </div>

        <!-- Heading -->
        <h2 style="color: #333333; text-align: center;">📩 New Booking Submitted</h2>

        <p style="color: #555555;">A new booking has been submitted. Below are the details:</p>

        <!-- Booking Details Table -->
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr>
                <td style="padding: 8px; font-weight: bold; color: #333;">Name:</td>
                <td style="padding: 8px; color: #333;">{{ $booking->name }}</td>
            </tr>
            <tr style="background-color: #f9f9f9;">
                <td style="padding: 8px; font-weight: bold; color: #333;">Booking Date:</td>
                <td style="padding: 8px; color: #333;">{{ $booking->booking_date }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; color: #333;">Time:</td>
                <td style="padding: 8px; color: #333;">{{ $booking->start_time }} - {{ $booking->end_time }}</td>
            </tr>
            <tr style="background-color: #f9f9f9;">
                <td style="padding: 8px; font-weight: bold; color: #333;">Phone:</td>
                <td style="padding: 8px; color: #333;">{{ $booking->phone ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; color: #333;">Purpose:</td>
                <td style="padding: 8px; color: #333;">{{ $booking->purpose ?? 'N/A' }}</td>
            </tr>
        </table>

        <!-- Button to Dashboard -->
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('admin.bookings') }}"
                style="text-decoration: none; background-color: #007bff; color: white; padding: 12px 20px; border-radius: 5px;">
                🔍 View Booking in Dashboard
            </a>
        </div>

        <!-- Footer -->
        <p style="margin-top: 40px; font-size: 12px; color: #888888; text-align: center;">
            This is an automated email from the Mosque Booking System. Please do not reply.
        </p>
    </div>

</body>

</html>