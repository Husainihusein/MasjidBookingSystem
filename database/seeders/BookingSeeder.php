<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Booking;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        // Possible statuses
        $statuses = ['pending', 'approved', 'rejected', 'cancelled'];

        // Dummy purposes
        $purposes = ['Tahlil', 'Kenduri', 'Majlis Kahwin', 'Jualan Tapak'];

        // Make sure proofs folder exists
        Storage::makeDirectory('public/proofs');
        Storage::makeDirectory('public/refund_proofs');

        foreach ($statuses as $status) {
            for ($i = 1; $i <= 10; $i++) {

                // Pick a random dummy image
                $dummyFiles = [
                    public_path('build/dummy_uploads/dummy_proof.jpg'),
                    public_path('build/dummy_uploads/dummy_proof_2.jpg'),
                ];

                $sourcePath = $dummyFiles[array_rand($dummyFiles)];
                if (!File::exists($sourcePath)) {
                    continue; // Skip if the dummy file does not exist
                }

                // Generate a random filename and copy it to storage
                $proofFileName = Str::random(10) . '_proof.jpg';
                $storagePath = storage_path('app/public/proofs/' . $proofFileName);
                File::copy($sourcePath, $storagePath);

                $refundPath = null;
                if ($status === 'rejected' || $status === 'cancelled') {
                    $refundFileName = Str::random(10) . '_refund.jpg';
                    $refundPath = 'refund_proofs/' . $refundFileName;
                    File::copy($sourcePath, storage_path('app/public/' . $refundPath));
                }

                Booking::create([
                    'name' => fake()->name(),
                    'ic' => fake()->numerify('############'),
                    'email' => fake()->safeEmail(),
                    'phone' => fake()->phoneNumber(),
                    'purpose' => $purposes[array_rand($purposes)],
                    'booking_date' => now()->addDays(rand(1, 30))->format('Y-m-d'),
                    'start_time' => '10:00',
                    'end_time' => '12:00',
                    'account_number' => fake()->bankAccountNumber(),
                    'proof_file' => 'proofs/' . $proofFileName,
                    'refund_proof' => $refundPath,
                    'rejection_reason' => ($status === 'rejected' || $status === 'cancelled') ? 'Not available at selected time.' : null,
                    'status' => $status,
                    'price' => rand(50, 150),
                ]);
            }
        }
    }
}
