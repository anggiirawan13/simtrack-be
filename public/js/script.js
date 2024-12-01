
  // // Fungsi untuk menambahkan resi ke dalam resiContainer
  // function addResi(event) {
  //   if (event.key === 'Enter') {
  //     event.preventDefault();
      
  //     const resiInput = document.getElementById('resiInput');
  //     const resiContainer = document.getElementById('resiContainer');
  //     const resiValue = resiInput.value.trim();
      
  //     // Hanya menambahkan jika input tidak kosong
  //     if (resiValue) {
  //       // Membuat elemen baru untuk menampilkan nomor resi
  //       const resiTab = document.createElement('div');
  //       resiTab.className = 'resi-tab';
  //       resiTab.innerText = resiValue;
        
  //       // Menambahkan elemen ke dalam container
  //       resiContainer.appendChild(resiTab);
        
  //       // Mengosongkan input setelah memasukkan resi
  //       resiInput.value = '';
  //     }
  //   }
  // }

// Function to add a resi bubble
function addResi(event) {
  // Check if the Enter key is pressed
  if (event.key === "Enter") {
      // Prevent the default form submission
      event.preventDefault();
      
      // Get the resi input value
      const resiInput = document.getElementById("resiInput");
      const resiNumber = resiInput.value.trim();

      // Check if the resi number is not empty
      if (resiNumber) {
          // Create a new bubble element
          const bubble = document.createElement("div");
          bubble.className = "bg-green-100 text-green-700 font-semibold px-4 py-2 rounded-full inline-flex items-center space-x-2 shadow-md";

          // Create the text node for the resi number
          const resiText = document.createElement("span");
          resiText.textContent = resiNumber;
          bubble.appendChild(resiText);

          // Create the close button
          const closeButton = document.createElement("button");
          closeButton.className = "text-red-500 hover:text-red-700 font-bold";
          closeButton.innerHTML = "&times;"; // HTML for the "×" symbol
          closeButton.onclick = function () {
              bubble.remove();
          };

          bubble.appendChild(closeButton);

          // Append the bubble to the resi-container
          document.querySelector(".resi-container").appendChild(bubble);

          // Clear the input
          resiInput.value = "";
      }
  }
}

