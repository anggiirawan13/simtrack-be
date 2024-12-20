<?php

// // app/Http/Controllers/ResiController.php
// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// class ResiController extends Controller
// {
//     public function show($noResi)
//     {
//         // Sample data; replace with actual query logic
//         $resi = [
//             'noResi' => $noResi,
//             'kotaTujuan' => 'Surabaya',
//             'perusahaan' => 'PT. ABC',
//             'tanggalDiterima' => now()->format('d-m-Y'),
//             'status' => 'In Transit',
//         ];

//         return view('resi.show', compact('resi'));
//     }
// }

// app/Http/Controllers/ResiController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ResiController extends Controller
{
    public function show($noResi)
    {
        try {
            // Inisialisasi Guzzle Client
            $client = new Client();

            // Panggil API
            $response = $client->get('http://localhost:8000/api/deliveries/' . $noResi);

            // Decode respons JSON
            $data = json_decode($response->getBody()->getContents(), true);

            // Cek apakah request sukses
            if ($data['success']) {
                $resi = $data['data']; // Ambil data dari respons API
                return view('resi.show', compact('resi')); // Kirim data ke view
            } else {
                return redirect()->back()->withErrors(['error' => 'Failed to fetch delivery data: ' . $e->getMessage()]);
            }
        } catch (\Exception $e) {
            // Tangani error jika API gagal dipanggil
            return redirect()->back()->withErrors(['error' => 'Failed to fetch delivery data: ' . $e->getMessage()]);
        }
    }
}


// app/Http/Controllers/ResiController.php

