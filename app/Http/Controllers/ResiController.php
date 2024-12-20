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

use App\Models\Delivery;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ResiController extends Controller
{
    public function show($noResi)
    {
        $resi = $this->getDetailOrder($noResi);
    
        return view('resi.show', compact('resi'));
    }
    
    public function getDetailOrder($id)
    {
        $delivery = Delivery::with([
            'recipient',
            'recipient.address',
            'shipper',
            'status'
        ])->find($id);
    
        if ($delivery) {
            $latestHistory = $delivery->history()->orderBy('created_at', 'desc')->first();
            $delivery->setRelation('history', $latestHistory);
        }
    
        return $delivery;
    }
    
}


