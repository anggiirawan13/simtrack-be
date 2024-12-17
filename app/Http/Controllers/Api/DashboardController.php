<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardResource;
use App\Models\Delivery;

class DashboardController extends Controller
{
    public function index() {
        $totalDiproses = Delivery::whereRaw('status_id = ?', [1])->count();
        $totalDikirim = Delivery::whereRaw('status_id = ?', [2])->count();
        $totalDiterima = Delivery::whereRaw('status_id = ?', [3])->count();
        $totalKeseluruhan = Delivery::count();

        return new DashboardResource(true, 'Data dashboard berhasil ditemukan', $totalDiproses, $totalDikirim, $totalDiterima, $totalKeseluruhan);
    }

    public function show($id) {
        $totalDiproses = Delivery::whereRaw('status_id = ?', [1])->whereHas('shipper', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->count();
        $totalDikirim = Delivery::whereRaw('status_id = ?', [2])->whereHas('shipper', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->count();
        $totalDiterima = Delivery::whereRaw('status_id = ?', [3])->whereHas('shipper', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->count();
        $totalKeseluruhan = Delivery::whereHas('shipper', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->count();

        return new DashboardResource(true, 'Data dashboard berhasil ditemukan', $totalDiproses, $totalDikirim, $totalDiterima, $totalKeseluruhan);
    }
}
