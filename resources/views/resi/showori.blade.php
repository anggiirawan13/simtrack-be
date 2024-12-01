{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Resi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10 p-6 bg-white border border-gray-200 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-green-700 mb-6 text-center">Resi Detail</h1>
        
        <div class="space-y-4"> <!-- Space between elements for better readability -->
            <p class="text-lg"><strong>No Resi:</strong> {{ $resi['noResi'] }}</p>
            <p class="text-lg"><strong>Kota Tujuan:</strong> {{ $resi['kotaTujuan'] }}</p>
            <p class="text-lg"><strong>Perusahaan:</strong> {{ $resi['perusahaan'] }}</p>
            <p class="text-lg"><strong>Nama Penerima:</strong> {{ $resi['namaPenerima'] }}</p>
            <p class="text-lg"><strong>Tanggal Pengiriman:</strong> {{ $resi['tanggalPengiriman'] }}</p>
            <p class="text-lg"><strong>Tanggal Diterima:</strong> {{ $resi['tanggalDiterima'] }}</p>
            <p class="text-lg"><strong>Status:</strong> <span id="resiStatus" class="font-semibold">{{ $resi['status'] }}</span></p>
        </div>
        
        <!-- Action Buttons -->
        <div class="mt-6 flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4 justify-center">
            <button id="confirmArrivalBtn" onclick="confirmArrival()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 w-full sm:w-auto">
                Confirm Arrival
            </button>
            <button onclick="openMaps()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-auto">
                Track
            </button>
        </div>
        
        <a href="/" class="mt-4 inline-block text-blue-600 hover:underline focus:outline-none focus:ring-2 focus:ring-blue-500 text-center">Back to Tracking</a>
    </div>

    <script>
        function confirmArrival() {
            // Update the status in the page
            document.getElementById('resiStatus').textContent = 'Delivered';

            // Optionally, you can send an AJAX request here to update the status in the database
            alert('Arrival has been confirmed as "Delivered".');
            
            // Disable the button after confirmation
            document.getElementById('confirmArrivalBtn').disabled = true;
        }

        function openMaps() {
            // Change the coordinates as per your desired location
            const latitude = -6.1751; // Example: Jakarta
            const longitude = 106.8650;
            const url = `https://www.google.com/maps?q=${latitude},${longitude}`;
            window.open(url, '_blank');
        }
    </script>
</body>
</html> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Resi</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10 p-6 bg-white border border-gray-200 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-green-700 mb-6 text-center">Resi Detail</h1>

        <div class="space-y-4">
            <p class="text-lg"><strong>No Resi:</strong> {{ $resi['noResi'] }}</p>
            <p class="text-lg"><strong>Kota Tujuan:</strong> {{ $resi['kotaTujuan'] }}</p>
            <p class="text-lg"><strong>Perusahaan:</strong> {{ $resi['perusahaan'] }}</p>
            <p class="text-lg"><strong>Nama Penerima:</strong> <span id="namaPenerima">{{ $resi['namaPenerima'] }}</span></p>
            <p class="text-lg"><strong>Tanggal Pengiriman:</strong> {{ $resi['tanggalPengiriman'] }}</p>
            <p class="text-lg"><strong>Tanggal Diterima:</strong> {{ $resi['tanggalDiterima'] }}</p>
            <p class="text-lg"><strong>Status:</strong> <span id="resiStatus" class="font-semibold">{{ $resi['status'] }}</span></p>
        </div>
        
        <!-- Action Buttons -->
        <div class="mt-6 flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4 justify-center">
            <button id="confirmArrivalBtn" onclick="showConfirmationPopup()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 w-full sm:w-auto">
                Confirm Arrival
            </button>
            <button onclick="openMaps()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-auto">
                Track
            </button>
        </div>
        
        <a href="/" class="mt-4 inline-block text-blue-600 hover:underline focus:outline-none focus:ring-2 focus:ring-blue-500 text-center">Back to Tracking</a>
    </div>

    <!-- First Confirmation Popup -->
    <div id="confirmationPopup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full text-center">
            <p class="text-lg font-semibold mb-4">Are you sure the item has arrived?</p>
            <div class="flex justify-around">
                <button onclick="showRecipientPopup()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">Yes</button>
                <button onclick="hideConfirmationPopup()" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">No</button>
            </div>
        </div>
    </div>

    <!-- Second Popup for Recipient Name and Encryption Code -->
    <div id="recipientPopup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full text-center">
            <p class="text-lg font-semibold mb-4">Enter Recipient Name and Encryption Code</p>
            <input type="text" id="inputRecipientName" placeholder="Recipient Name" class="w-full mb-2 p-2 border rounded focus:outline-none">
            <input type="text" id="inputEncryptionCode" placeholder="Encryption Code" class="w-full mb-2 p-2 border rounded focus:outline-none">
            <p id="errorMessage" class="text-red-600 text-sm hidden">Incorrect encryption code. Please try again.</p> <!-- Inline error message -->
            <div class="flex justify-around mt-4">
                <button onclick="confirmRecipient()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">Confirm</button>
                <button onclick="hideRecipientPopup()" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">Cancel</button>
            </div>
        </div>
    </div>

        <!-- Delivered Stamp -->
<div id="deliveredStamp" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <img src="{{ asset('img/thanks.png') }}" alt="Delivered" class="w-1/2 h-auto">
</div>

    <!-- Thank You Popup -->
    <div id="thankYouPopup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full text-center">
            <img src="{{ asset('img/thanks.png') }}" alt="Thank You" class="mx-auto mb-4 w-24 h-24">
            <p class="text-xl font-semibold text-green-700 mb-4">Thank you!</p>
            <p>Your delivery has been successfully confirmed.</p>
            <button onclick="hideThankYouPopup()" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Close</button>
        </div>
    </div>

    {{-- <script>
        function showConfirmationPopup() {
            document.getElementById('confirmationPopup').classList.remove('hidden');
        }

        function hideConfirmationPopup() {
            document.getElementById('confirmationPopup').classList.add('hidden');
        }

        function showRecipientPopup() {
            hideConfirmationPopup();
            document.getElementById('recipientPopup').classList.remove('hidden');
        }

        function hideRecipientPopup() {
            document.getElementById('recipientPopup').classList.add('hidden');
            document.getElementById('errorMessage').classList.add('hidden'); // Hide error message when closing the popup
        }

        function confirmRecipient() {
            const inputName = document.getElementById('inputRecipientName').value;
            const inputCode = document.getElementById('inputEncryptionCode').value;
            const expectedCode = '12345'; // Example encryption code

            if (inputName && inputCode === expectedCode) {
                document.getElementById('namaPenerima').textContent = inputName;
                document.getElementById('resiStatus').textContent = 'Delivered';

                document.getElementById('confirmArrivalBtn').disabled = true;

                hideRecipientPopup();
                showThankYouPopup();
            } else {
                document.getElementById('errorMessage').classList.remove('hidden'); // Show error message if code is incorrect
            }
        }

        function showThankYouPopup() {
            document.getElementById('thankYouPopup').classList.remove('hidden');
        }

        function hideThankYouPopup() {
            document.getElementById('thankYouPopup').classList.add('hidden');
        }

        function openMaps() {
            const latitude = -6.1751;
            const longitude = 106.8650;
            const url = `https://www.google.com/maps?q=${latitude},${longitude}`;
            window.open(url, '_blank');
        }

        function confirmRecipient() {
    const inputName = document.getElementById('inputRecipientName').value;
    const inputCode = document.getElementById('inputEncryptionCode').value;
    const expectedCode = '12345'; // Example encryption code

    if (inputName && inputCode === expectedCode) {
        document.getElementById('namaPenerima').textContent = inputName;
        document.getElementById('resiStatus').textContent = 'Delivered';

        // Disable and hide the Confirm Arrival and Track buttons
        document.getElementById('confirmArrivalBtn').style.display = 'none';
        document.querySelector("button[onclick='openMaps()']").style.display = 'none';

        hideRecipientPopup();
        showThankYouPopup();
    } else {
        document.getElementById('errorMessage').classList.remove('hidden'); // Show error message if code is incorrect
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const status = document.getElementById('resiStatus').textContent.trim();

    if (status === 'Delivered') {
        document.getElementById('confirmArrivalBtn').style.display = 'none';
        document.querySelector("button[onclick='openMaps()']").style.display = 'none';
    }
});


    </script> --}}



    <script>
        // Function to show the confirmation popup
        function showConfirmationPopup() {
            document.getElementById('confirmationPopup').classList.remove('hidden');
        }
    
        // Function to hide the confirmation popup
        function hideConfirmationPopup() {
            document.getElementById('confirmationPopup').classList.add('hidden');
        }
    
        // Function to show the recipient name input popup
        function showRecipientPopup() {
            hideConfirmationPopup();
            document.getElementById('recipientPopup').classList.remove('hidden');
        }
    
        // Function to hide the recipient popup
        function hideRecipientPopup() {
            document.getElementById('recipientPopup').classList.add('hidden');
            document.getElementById('errorMessage').classList.add('hidden'); // Hide error message when closing the popup
        }
    
        // Function to confirm the recipient name and encryption code
        function confirmRecipient() {
            const inputName = document.getElementById('inputRecipientName').value;
            const inputCode = document.getElementById('inputEncryptionCode').value;
            const expectedCode = '12345'; // Example encryption code
    
            if (inputName && inputCode === expectedCode) {
                document.getElementById('namaPenerima').textContent = inputName;
                document.getElementById('resiStatus').textContent = 'Delivered';
    
                // Hide Confirm Arrival and Track buttons
                document.getElementById('confirmArrivalBtn').classList.add('hidden');
                document.querySelector("button[onclick='openMaps()']").classList.add('hidden');
    
                hideRecipientPopup();
                showDeliveredStamp(); // Show the delivered stamp
                showThankYouPopup(); // Show thank you popup
            } else {
                document.getElementById('errorMessage').classList.remove('hidden'); // Show error message if code is incorrect
            }
        }
    
        // Function to show the delivered stamp
        function showDeliveredStamp() {
            document.getElementById('deliveredStamp').classList.remove('hidden');
        }
    
        // Function to show the thank you popup
        function showThankYouPopup() {
            document.getElementById('thankYouPopup').classList.remove('hidden');
        }
    
        // Function to hide the thank you popup
        function hideThankYouPopup() {
            document.getElementById('thankYouPopup').classList.add('hidden');
        }
    
        // Function to open Google Maps
        function openMaps() {
            const latitude = -6.1751;
            const longitude = 106.8650;
            const url = `https://www.google.com/maps?q=${latitude},${longitude}`;
            window.open(url, '_blank');
        }
    
        // Check the status on page load
        document.addEventListener('DOMContentLoaded', function () {
            const status = document.getElementById('resiStatus').textContent.trim();
    
            // If status is 'Delivered', hide the buttons
            if (status === 'Delivered') {
                document.getElementById('confirmArrivalBtn').classList.add('hidden');
                document.querySelector("button[onclick='openMaps()']").classList.add('hidden');
            }
        });
    </script>
    

</body>
</html>