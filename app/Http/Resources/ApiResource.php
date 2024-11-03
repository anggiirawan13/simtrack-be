<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    public function __construct($resource, $statusCode = 200)
    {
        parent::__construct($resource);
        $this->statusCode = $statusCode;
    }

    public function toArray($request)
    {
        return [
            'success' => $this->resource['status'] ?? false,
            'message' => $this->resource['message'] ?? 'An error occurred.',
            'data'    => $this->resource['resource'] ?? null,
        ];
    }

    public function with($request)
    {
        return [
            'status' => $this->statusCode,
        ];
    }
}

?>