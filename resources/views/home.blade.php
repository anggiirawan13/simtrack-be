<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>SimTrack Web</title>
</head>

<body>
    {{-- <header>
        <div class="container mx-auto max-w-full p-auto">
            <div class="flex items-center justify-center space-x-4 shadow-md p-4 bg-white rounded-md">
                <img src="img/logo.png" alt="" class="h-16 w-16 md:h-20 md:w-20">
                <h1 class="text-xl md:text-2xl font-bold font-serif text-green-700">Anugrah Hadi Electric</h1>                    
            </div>
        </div>
    </header>
    <section>
        <div class="container mx-auto max-w-full py-5 px-4 sm:px-6 lg:px-10 flex flex-col items-center">
            <div class="flex flex-col items-center mb-8">
                <img class="h-1/4 w-1/4 m-auto" src="img/navigation.png" alt="Navigation Icon">
                <h1 class="flex p-4 text-3xl md:text-5xl font-sans font-bold text-green-700">Tracking</h1>
            </div>
    
            <!-- Container Input Resi -->
            <div class="border rounded-3xl shadow-md max-w-lg w-full p-6 mx-auto">
                <!-- Input Resi -->
                <input id="resiInput" 
                    type="text" 
                    placeholder="Enter your receipt.." 
                    onkeydown="addResi(event)"
                    class="w-full py-2 text-black font-semibold rounded-md focus:outline-none">              
    
                <!-- Container for Resi Bubbles -->
                <div class="resi-container mt-4 flex flex-wrap gap-2">
                    <!-- Resi bubbles will be added here dynamically -->
                </div>
            </div>
    
            <!-- Search Button Outside Container -->
            <div class="flex justify-center mt-6">
                <button id="searchButton" class="bg-green-700 text-white font-semibold py-2 px-4 rounded-xl hover:bg-green-800 w-full sm:w-auto" onclick="showResiTable()">
                    Shipment Track
                </button>
            </div>
    
            <!-- Table to display resi information -->
            <div class="overflow-x-auto mt-8 w-full">
                <table id="resiTable" class="min-w-full border-collapse border border-gray-300 hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-2 py-2 text-sm sm:text-base">No Resi</th>
                            <th class="border border-gray-300 px-2 py-2 text-sm sm:text-base">Kota Tujuan</th>
                            <th class="border border-gray-300 px-2 py-2 text-sm sm:text-base">Perusahaan</th>
                            <th class="border border-gray-300 px-2 py-2 text-sm sm:text-base">Tanggal Diterima</th>
                            <th class="border border-gray-300 px-2 py-2 text-sm sm:text-base">Status</th>
                            <th class="border border-gray-300 px-2 py-2 text-sm sm:text-base">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="resiTableBody">
                        <!-- Rows will be dynamically added here -->
                    </tbody>
                </table>
            </div>
        </div>   
    </section>
    
    <footer class="text-black py-16 mt-10 shadow-lg border">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-center"> <!-- Flex container for alignment -->
            <div class="text-center md:text-left w-full md:w-1/3 mb-6 md:mb-0"> <!-- Centered text section on small screens -->
                <p class="text-lg font-semibold">Anugrah Hadi Electric</p>
                <p class="text-sm">General Supplier Electrical</p>
    
                <!-- Social Links -->
                <div class="flex justify-center md:justify-start mt-2 space-x-4"> <!-- Space between icons -->
                    <a href="https://wa.me/+62 856923534834" target="_blank" class="flex items-center">
                        <img src="img/wa.png" alt="WhatsApp" class="h-6 w-6"> <!-- Adjust path -->
                        <span class="text-sm">089629625484</span>
                    </a>
                    <a href="mailto:anugrahhadielectric.com" target="_blank" class="flex items-center">
                        <img src="img/email.png" alt="Email" class="h-6 w-6"> <!-- Adjust path -->
                        <span class="text-sm">anugrahhadielectric.com</span>
                    </a>
                </div>
            </div>
            
            <div class="w-full md:w-1/3"> <!-- Map container -->
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.397219777975!2d106.59237567603742!3d-6.211226960842041!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ff8c61e3b72d%3A0xb5aa5f38db758c1f!2sPT.%20Anugrah%20Hadi%20Electric!5e0!3m2!1sen!2sid!4v1730407289234!5m2!1sen!2sid" 
                    width="100%" 
                    height="200" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </footer> --}}

    <header>
        <div class="container mx-auto max-w-full p-auto">
            <div class="flex flex-col sm:flex-row items-center justify-center space-x-4 shadow-md p-4 bg-white">
                <img src="img/logo.png" alt="Logo" class="h-16 w-16 sm:h-20 sm:w-20">
                <h1
                    class="text-2xl sm:text-3xl md:text-4xl font-bold font-serif text-green-700 text-center sm:text-left">
                    Anugrah Hadi Electric</h1>
            </div>
        </div>
    </header>

    <section>
        <div class="container mx-auto max-w-full py-5 px-4 sm:px-6 lg:px-10 flex flex-col items-center">
            <div class="flex flex-col items-center mb-8">
                <img class="h-80 w-80 sm:h-28 sm:w-28 md:h-32 md:w-32 m-auto" src="img/navigation.png"
                    alt="Navigation Icon">
                <h1 class="flex p-4 text-3xl sm:text-4xl md:text-5xl font-sans font-bold text-green-700">Tracking</h1>
            </div>

            <!-- Container Input Resi -->
            <div class="border rounded-3xl shadow-md max-w-md w-full p-6">
                <!-- Input Resi -->
                <input id="resiInput" type="text" placeholder="Enter your receipt.." onkeydown="addResi(event)"
                    class="w-full py-2 text-black font-semibold rounded-md focus:outline-none">

                <!-- Container for Resi Bubbles -->
                <div class="resi-container mt-4 flex flex-wrap gap-2">
                    <!-- Resi bubbles will be added here dynamically -->
                </div>
            </div>

            <!-- Search Button Outside Container -->
            <div class="flex justify-center mt-6 w-full sm:w-auto">
                <button id="searchButton"
                    class="bg-green-700 text-white font-semibold py-2 px-4 rounded-xl hover:bg-green-800 w-full sm:w-auto"
                    onclick="showResiTable()">
                    Shipment Track
                </button>
            </div>

            <!-- Table to display resi information -->
            <div class="overflow-x-auto mt-8 w-full max-w-full">
                <table id="resiTable" class="min-w-full border-collapse border border-gray-300 hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-2 py-2 text-xs sm:text-sm">No Resi</th>
                            <th class="border border-gray-300 px-2 py-2 text-xs sm:text-sm">Kota Tujuan</th>
                            <th class="border border-gray-300 px-2 py-2 text-xs sm:text-sm">Perusahaan</th>
                            <th class="border border-gray-300 px-2 py-2 text-xs sm:text-sm">Tanggal Dikirim</th>
                            <th class="border border-gray-300 px-2 py-2 text-xs sm:text-sm">Status</th>
                            <th class="border border-gray-300 px-2 py-2 text-xs sm:text-sm">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="resiTableBody">
                        <!-- Rows will be dynamically added here -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <footer class="text-black py-10 mt-10 shadow-lg border">
        <div
            class="container mx-auto flex flex-col md:flex-row justify-between items-center space-y-6 md:space-y-0 md:space-x-6 px-4">
            <!-- Left Section with Company Info -->
            <div class="text-center md:text-left w-full md:w-1/3">
                <p class="text-lg font-semibold">Anugrah Hadi Electric</p>
                <p class="text-sm">General Supplier Electrical</p>

                <!-- Social Links -->
                <div class="flex justify-center md:justify-start mt-2 space-x-4">
                    <a href="https://wa.me/+62 856923534834" target="_blank" class="flex items-center space-x-1">
                        <img src="img/wa.png" alt="WhatsApp" class="h-6 w-6">
                        <span class="text-sm">089629625484</span>
                    </a>
                    <a href="mailto:anugrahhadielectric.com" target="_blank" class="flex items-center space-x-1">
                        <img src="img/email.png" alt="Email" class="h-6 w-6">
                        <span class="text-sm">anugrahhadielectric.com</span>
                    </a>
                </div>
            </div>

            <!-- Center Section with Map -->
            <div class="w-full md:w-1/3">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.397219777975!2d106.59237567603742!3d-6.211226960842041!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ff8c61e3b72d%3A0xb5aa5f38db758c1f!2sPT.%20Anugrah%20Hadi%20Electric!5e0!3m2!1sen!2sid!4v1730407289234!5m2!1sen!2sid"
                    width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
    </footer>

    <script>
        const resiList = [];
        const numberList = {
            "delivery": []
        };

        function addResi(event) {
            if (event.key === "Enter" || event.key === " ") {
                event.preventDefault();

                const resiInput = document.getElementById("resiInput");
                const resiNumber = resiInput.value.trim();
                numberList.delivery.push({
                    "number": resiNumber
                })

                if (resiNumber) {
                    let resiDetails = {
                        noResi: resiNumber,
                        kotaTujuan: "Surabaya",
                        perusahaan: "PT. ABC",
                        tanggalDiterima: new Date().toLocaleDateString(),
                        status: "In Transit"
                    };


                    if (resiNumber === "12345") {
                        resiDetails = {
                            noResi: "12345",
                            kotaTujuan: "Jakarta",
                            perusahaan: "PT. Anugrah Express",
                            tanggalDiterima: "11/01/2024 16:25",
                            status: "Delivered"
                        };
                    }

                    resiList.push(resiDetails);

                    const bubble = document.createElement("div");
                    bubble.className =
                        "bg-green-100 text-green-700 font-semibold px-4 py-2 rounded-full inline-flex items-center space-x-2 shadow-md";

                    const resiText = document.createElement("span");
                    resiText.textContent = resiNumber;
                    bubble.appendChild(resiText);

                    const closeButton = document.createElement("button");
                    closeButton.className = "text-red-500 hover:text-red-700 font-bold";
                    closeButton.innerHTML = "&times;";
                    closeButton.onclick = function() {
                        const index = resiList.findIndex(r => r.noResi === resiNumber);
                        if (index !== -1) resiList.splice(index, 1);


                        showResiTable();


                        bubble.remove();
                    };

                    bubble.appendChild(closeButton);

                    document.querySelector(".resi-container").appendChild(bubble);

                    resiInput.value = "";
                }
            }
        }

        function showResiTable() {
            const resiTable = document.getElementById("resiTable");
            const resiTableBody = document.getElementById("resiTableBody");

            numberList.delivery = numberList.delivery.filter(item => item.number);

            resiTableBody.innerHTML = "";
            const envURL = @json(env('API_URL'));
            const apiUrl = envURL.replace('API_URL=', '')
            fetch(`${apiUrl}/deliveries/check`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(numberList)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(resiList => {
                    console.log(resiList.data);
                    if (resiList.data.length > 0) {
                        resiList.data.forEach((resi, index) => {
                            const row = document.createElement("tr");

                            row.innerHTML = `
                        <td class="border border-gray-300 px-4 py-2">${resi.delivery_number}</td>
                        <td class="border border-gray-300 px-4 py-2">${resi.recipient.address.city}</td>
                        <td class="border border-gray-300 px-4 py-2">${resi.company_name}</td>
                        <td class="border border-gray-300 px-4 py-2">${resi.delivery_date}</td>
                        <td class="border border-gray-300 px-4 py-2">${resi.status.status}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <button onclick="openResiDetail(${resi.id})" class="text-blue-500 hover:text-blue-700">Detail</button>
                        </td>
                    `;

                            resiTableBody.appendChild(row);
                        });


                        resiTable.classList.remove("hidden");
                    } else {

                        resiTable.classList.add("hidden");
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);

                });
        }


        function openResiDetail(id) {
            window.location.href = `/resi/${id}`;
        }
    </script>

</body>

</html>
