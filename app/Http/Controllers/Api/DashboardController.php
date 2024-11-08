<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardResource;
use App\Models\Delivery;

class DashboardController extends Controller
{
    public function index() {
        $totalDiproses = Delivery::whereRaw('LOWER(status) = ?', ['diproses'])->count();
        $totalDikirim = Delivery::whereRaw('LOWER(status) = ?', ['dikirim'])->count();
        $totalDiterima = Delivery::whereRaw('LOWER(status) = ?', ['diterima'])->count();
        $totalKeseluruhan = Delivery::count();

        return new DashboardResource(true, 'Data dashboard berhasil ditemukan', $totalDiproses, $totalDikirim, $totalDiterima, $totalKeseluruhan);
    }
}
