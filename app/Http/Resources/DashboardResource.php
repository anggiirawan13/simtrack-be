<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardResource extends JsonResource
{
   
    public $status;
    public $message;
    public $resource;
    public $proses;
    public $kirim;
    public $terima;
    public $total;

    /**
     * __construct
     *
     * @param  mixed $status
     * @param  mixed $message
     * @param  mixed $resource
     * @return void
     */
    public function __construct($status, $message, $proses, $kirim, $terima, $total)
    {
        $this->status  = $status;
        $this->message = $message;
        $this->proses = $proses;
        $this->kirim = $kirim;
        $this->terima = $terima;
        $this->total = $total;
    }

    /**
     * toArray
     *
     * @param  mixed $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'success'   => $this->status,
            'message'   => $this->message,
            'data' => [
                'proses' => $this->proses,
                'kirim' => $this->kirim,
                'terima' => $this->terima,
                'total' => $this->total,
            ]
        ];
    }
}