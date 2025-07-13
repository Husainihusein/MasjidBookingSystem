<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin - Bookings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .status-nav.active {
            background-color: #f3f4f6;
            font-weight: 600;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="flex">
        <button id="mobile-menu-btn" class="lg:hidden fixed top-4 left-4 z-50 p-2 bg-white rounded-md shadow-md">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <div id="sidebar" class="fixed lg:static inset-y-0 left-0 z-40 w-64 bg-white shadow-lg min-h-screen transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="p-6 border-b flex items-center justify-center">
                <img src="https://masjidalikhwan.com/storage/logo.jpg" alt="Logo Masjid" class="h-10 w-auto">
                <h1 class="text-xl font-bold text-gray-800 ml-3">Admin Dashboard</h1>
            </div>
            <nav class="mt-6">
                <button onclick="showSection('pending')" class="w-full text-left px-6 py-3 text-gray-700 hover:bg-gray-100 border-l-4 border-transparent hover:border-yellow-500 transition-colors status-nav active" data-status="pending">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></span>
                        <span class="hidden sm:inline">Pending Bookings</span>
                        <span class="sm:hidden">Pending</span>
                    </div>
                </button>
                <button onclick="showSection('approved')" class="w-full text-left px-6 py-3 text-gray-700 hover:bg-gray-100 border-l-4 border-transparent hover:border-green-500 transition-colors status-nav" data-status="approved">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-3"></span>
                        <span class="hidden sm:inline">Approved Bookings</span>
                        <span class="sm:hidden">Approved</span>
                    </div>
                </button>
                <button onclick="showSection('rejected')" class="w-full text-left px-6 py-3 text-gray-700 hover:bg-gray-100 border-l-4 border-transparent hover:border-red-500 transition-colors status-nav" data-status="rejected">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-red-500 rounded-full mr-3"></span>
                        <span class="hidden sm:inline">Rejected Bookings</span>
                        <span class="sm:hidden">Rejected</span>
                    </div>
                </button>
                <button onclick="showSection('cancelled')" class="w-full text-left px-6 py-3 text-gray-700 hover:bg-gray-100 border-l-4 border-transparent hover:border-orange-500 transition-colors status-nav" data-status="cancelled">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-orange-500 rounded-full mr-3"></span>
                        <span class="hidden sm:inline">Cancelled Bookings</span>
                        <span class="sm:hidden">Cancelled</span>
                    </div>
                </button>
            </nav>
            <form method="POST" action="{{ route('logout') }}" class="mt-6 border-t">
                @csrf
                <button type="submit" class="w-full text-left px-6 py-3 text-red-600 hover:bg-red-50 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-9V4m0 1V4m0 5v1" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>

        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>

        <div class="flex-1 lg:ml-0 ml-0 p-4 lg:p-6">
            <div class="h-16 lg:h-0"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6 lg:mb-8">
                <div class="bg-white rounded-lg shadow p-4 lg:p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 lg:ml-4">
                            <h3 class="text-sm lg:text-lg font-semibold text-gray-700">Total Bookings</h3>
                            <p class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $totalBookings }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4 lg:p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 lg:ml-4">
                            <h3 class="text-sm lg:text-lg font-semibold text-gray-700">Approved</h3>
                            <p class="text-2xl lg:text-3xl font-bold text-green-600">{{$approvedCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4 lg:p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 rounded-full">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 lg:ml-4">
                            <h3 class="text-sm lg:text-lg font-semibold text-gray-700">Rejected</h3>
                            <p class="text-2xl lg:text-3xl font-bold text-red-600">{{$rejectedCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4 lg:p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-orange-100 rounded-full">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.96-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 lg:ml-4">
                            <h3 class="text-sm lg:text-lg font-semibold text-gray-700">Cancelled</h3>
                            <p class="text-2xl lg:text-3xl font-bold text-orange-600">{{$cancelledCount }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @php
            $statuses = ['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'cancelled' => 'Cancelled'];
            @endphp

            @foreach ($statuses as $key => $label)
            <div class="booking-section {{ $key !== 'pending' ? 'hidden' : '' }}" id="section-{{ $key }}">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-4 lg:px-6 py-4 border-b">
                        <h2 class="text-lg lg:text-xl font-semibold text-gray-800">{{ $label }} Bookings</h2>
                        <p class="text-xs lg:text-sm text-gray-600 mt-1">{{ ${$key . 'Bookings'}->total() }} total bookings</p>
                    </div>

                    <div class="p-4 lg:p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <form method="GET" class="w-full sm:w-auto flex-grow relative">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search by name, phone, or email"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1011.65 5.65a7.5 7.5 0 005.5 10.5z" />
                                </svg>
                            </div>
                        </form>

                        <div class="relative inline-block text-left w-full sm:w-auto">
                            <button type="button" onclick="toggleExportDropdown()" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Export Bookings
                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div id="exportDropdown" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 hidden">
                                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                    <a href="{{ route('admin.export') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Export All to Excel</a>
                                    <a href="{{ route('admin.export', ['status' => 'approved']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Export Approved</a>
                                    <a href="{{ route('admin.export', ['status' => 'rejected']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Export Rejected</a>
                                    <a href="{{ route('admin.export', ['status' => 'pending']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Export Pending</a>
                                    <a href="{{ route('admin.export', ['status' => 'cancelled']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Export Cancelled</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full table-fixed">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="w-32 px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="w-48 px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="w-32 px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                    <th class="w-24 px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="w-32 px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                    <th class="w-40 px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                                    <th class="w-24 px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Account No</th>
                                    <th class="w-20 px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proof</th>
                                    <th class="w-20 px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="w-32 px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach(${$key . 'Bookings'} as $booking)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-3 lg:px-6 py-4">
                                        <div class="font-medium text-gray-900 text-sm lg:text-base leading-tight">
                                            @php
                                            $nameParts = explode(' ', $booking->name);
                                            $firstLine = implode(' ', array_slice($nameParts, 0, 2));
                                            $secondLine = implode(' ', array_slice($nameParts, 2));
                                            @endphp
                                            {{ $firstLine }}
                                            @if($secondLine)
                                            <br>{{ $secondLine }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-3 lg:px-6 py-4 text-xs lg:text-sm text-gray-900">
                                        <a href="mailto:{{ $booking->email }}" class="text-blue-600 hover:text-blue-800 break-all">{{ $booking->email }}</a>
                                    </td>
                                    <td class="px-3 lg:px-6 py-4 text-xs lg:text-sm text-gray-900">
                                        <a href="tel:{{ $booking->phone }}" class="text-blue-600 hover:text-blue-800">{{ $booking->phone }}</a>
                                    </td>
                                    <td class="px-3 lg:px-6 py-4 text-xs lg:text-sm text-gray-900">
                                        {{ $booking->booking_date }}
                                    </td>
                                    <td class="px-3 lg:px-6 py-4 text-xs lg:text-sm text-gray-900">
                                        {{ $booking->start_time }} - {{ $booking->end_time }}
                                    </td>
                                    <td class="px-3 lg:px-6 py-4 text-xs lg:text-sm text-gray-900">
                                        <div class="truncate" title="{{ $booking->purpose }}">{{ $booking->purpose }}</div>
                                    </td>
                                    <td class="px-3 lg:px-6 py-4 text-xs lg:text-sm text-gray-900">
                                        {{ $booking->account_number }}
                                    </td>
                                    <td class="px-3 lg:px-6 py-4 text-xs lg:text-sm">
                                        @if($booking->proof_file)
                                        <a href="{{ asset('storage/' . $booking->proof_file) }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">View</a>
                                        @else
                                        <span class="text-gray-400">No proof</span>
                                        @endif
                                    </td>
                                    <td class="px-3 lg:px-6 py-4">
                                        <span class="px-2 lg:px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $booking->status === 'approved' ? 'bg-green-100 text-green-800' : ($booking->status === 'rejected' ? 'bg-red-100 text-red-800' : ($booking->status === 'cancelled' ? 'bg-orange-100 text-orange-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="px-3 lg:px-6 py-4 text-xs lg:text-sm font-medium">
                                        @if($booking->status === 'pending')
                                        <div class="relative">
                                            <button onclick="toggleDropdown('{{ $booking->id }}')" class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Actions
                                                <svg class="ml-1 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                            <div id="dropdown-{{ $booking->id }}" class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                                <div class="py-1">
                                                    <form method="POST" action="{{ route('admin.bookings.approve', $booking->id) }}" class="approval-form">
                                                        @csrf
                                                        <button type="button" onclick="confirmAction(this, 'approve')" class="w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-50">
                                                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                            Approve
                                                        </button>
                                                    </form>
                                                    <button onclick="openRejectModal(this)" data-booking-id="{{ $booking->id }}" data-booking-name="{{ $booking->name }}" class="w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50">
                                                        <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                        Reject
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @elseif($booking->status === 'approved')
                                        <div class="relative">
                                            <button onclick="openCancelModal(this)" data-booking-id="{{ $booking->id }}" data-booking-name="{{ $booking->name }}" class="inline-flex items-center px-3 py-1 border border-orange-300 rounded-md shadow-sm text-xs font-medium text-orange-700 bg-orange-50 hover:bg-orange-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.96-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                </svg>
                                                Cancel
                                            </button>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                                @if(${$key . 'Bookings'}->isEmpty())
                                <tr>
                                    <td colspan="10" class="px-3 lg:px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="text-lg font-medium">No {{ strtolower($label) }} bookings</p>
                                            <p class="text-sm">All bookings in this category will appear here</p>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="p-4">
                            {{ ${$key . 'Bookings'}->appends(request()->except($key.'_page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div id="rejectModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg">
            <h2 class="text-lg font-semibold mb-4">Reject Booking</h2>

            <form id="rejectForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="booking_id" id="rejectBookingId">

                <p class="mb-2 text-sm text-gray-700">Rejecting booking for <strong id="rejectBookingName"></strong></p>

                <label class="block text-sm font-medium text-gray-700 mb-1">Reason for rejection</label>
                <textarea name="rejection_reason" rows="3" class="w-full border p-2 rounded mb-4" required></textarea>

                <label class="block text-sm font-medium text-gray-700 mb-1">Refund Proof (optional)</label>
                <input type="file" name="refund_proof" accept="image/*" class="w-full mb-4">

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Reject Booking</button>
                </div>
            </form>
        </div>
    </div>

    <div id="cancelModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg">
            <h2 class="text-lg font-semibold mb-4">Cancel Booking</h2>

            <form id="cancelForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="booking_id" id="cancelBookingId">

                <p class="mb-2 text-sm text-gray-700">Cancelling booking for <strong id="cancelBookingName"></strong></p>

                <label class="block text-sm font-medium text-gray-700 mb-1">Reason for cancellation</label>
                <textarea name="rejection_reason" rows="3" class="w-full border p-2 rounded mb-4" required></textarea>

                <label class="block text-sm font-medium text-gray-700 mb-1">Refund Proof (optional)</label>
                <input type="file" name="refund_proof" accept="image/*" class="w-full mb-4">

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeCancelModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">Cancel Booking</button>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    </script>
    @endif

    <script>
        function toggleDropdown(bookingId) {
            const dropdown = document.getElementById(`dropdown-${bookingId}`);

            // Close all other dropdowns
            document.querySelectorAll('[id^="dropdown-"]').forEach(d => {
                if (d.id !== `dropdown-${bookingId}`) {
                    d.classList.add('hidden');
                }
            });

            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('[onclick*="toggleDropdown"]') && !event.target.closest('[id^="dropdown-"]')) {
                document.querySelectorAll('[id^="dropdown-"]').forEach(d => {
                    d.classList.add('hidden');
                });
            }
        });

        function confirmAction(button, type) {
            const actionText = type === 'approve' ? 'approve' : 'cancel';
            const actionTextCap = actionText.charAt(0).toUpperCase() + actionText.slice(1);
            const form = button.closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to ${actionText} this booking?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: type === 'approve' ? '#16a34a' : '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: `Yes, ${actionTextCap}`,
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        function showSection(status) {
            // Hide all sections
            const sections = document.querySelectorAll('.booking-section');
            sections.forEach(section => {
                section.classList.add('hidden');
            });

            // Show selected section
            const selectedSection = document.getElementById('section-' + status);
            if (selectedSection) {
                selectedSection.classList.remove('hidden');
            }

            // Update active state in sidebar
            const navButtons = document.querySelectorAll('.status-nav');
            navButtons.forEach(btn => {
                btn.classList.remove('active', 'border-yellow-500', 'border-green-500', 'border-red-500', 'border-orange-500'); // Added orange
                if (btn.dataset.status === status) {
                    btn.classList.add('active');
                    if (status === 'pending') {
                        btn.classList.add('border-yellow-500');
                    } else if (status === 'approved') {
                        btn.classList.add('border-green-500');
                    } else if (status === 'rejected') { // Corrected from cancelled to rejected
                        btn.classList.add('border-red-500');
                    } else if (status === 'cancelled') { // Added cancelled
                        btn.classList.add('border-orange-500');
                    }
                }
            });

            // Close mobile menu after selection
            closeMobileMenu();
        }

        function toggleMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function closeMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        // Mobile menu event listeners
        document.getElementById('mobile-menu-btn').addEventListener('click', toggleMobileMenu);
        document.getElementById('sidebar-overlay').addEventListener('click', closeMobileMenu);

        // Close mobile menu on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                closeMobileMenu();
            }
        });

        // Initialize with pending section
        document.addEventListener('DOMContentLoaded', function() {
            showSection('pending');
        });

        function openCancelModal(button) {
            const bookingId = button.getAttribute('data-booking-id');
            const bookingName = button.getAttribute('data-booking-name');

            document.getElementById('cancelModal').classList.remove('hidden');
            document.getElementById('cancelBookingId').value = bookingId;
            document.getElementById('cancelBookingName').textContent = bookingName;

            // Update form action dynamically
            document.getElementById('cancelForm').action = `/admin/bookings/${bookingId}/cancel`;
        }

        function closeCancelModal() {
            document.getElementById('cancelModal').classList.add('hidden');
            document.getElementById('cancelForm').reset();
        }

        function openRejectModal(button) {
            const bookingId = button.getAttribute('data-booking-id');
            const bookingName = button.getAttribute('data-booking-name');

            document.getElementById('rejectModal').classList.remove('hidden');
            document.getElementById('rejectBookingId').value = bookingId;
            document.getElementById('rejectBookingName').textContent = bookingName;

            // Update form action dynamically
            document.getElementById('rejectForm').action = `/admin/bookings/${bookingId}/reject`;
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejectForm').reset();
        }

        // Export Dropdown
        function toggleExportDropdown() {
            document.getElementById('exportDropdown').classList.toggle('hidden');
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('[onclick="toggleExportDropdown()"]')) {
                const dropdowns = document.getElementsByClassName("origin-top-right");
                for (let i = 0; i < dropdowns.length; i++) {
                    const openDropdown = dropdowns[i];
                    if (!openDropdown.classList.contains('hidden') && openDropdown.id === 'exportDropdown') {
                        openDropdown.classList.add('hidden');
                    }
                }
            }
        }
    </script>
</body>

</html>