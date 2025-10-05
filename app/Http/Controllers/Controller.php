<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function response($status , $data, $code = 200)
    {
        return response()->json(['status' => $status , 'data' => $data, 'code' => $code]);
    }

    public function paginatedResponse($status , $data, $code = 200)
    {
        $responseData = [
            "data" => $data,
            "count" => (int)$data->count(),
            "total" => (int)$data->total(),
            "last_page" => (int)$data->lastPage(),
            "per_page" => (int)$data->perPage(),
            "current_page" => (int)$data->currentPage(),
            "prev_page_url" => $data->previousPageUrl(),
            "next_page_url" => $data->nextPageUrl(),
        ];

        return response()->json([
        'status' => $status ,
        'data' => $responseData,
        'code' => $code]);
    }
}
