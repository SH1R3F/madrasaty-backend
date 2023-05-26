<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Share localization files with frontend
     */
    public function localization()
    {
        $ar = file_get_contents(base_path('lang/ar.json'));
        $en = file_get_contents(base_path('lang/en.json'));

        return response()->json([
            'ar' => json_decode($ar),
            'en' => json_decode($en)
        ]);
    }
}
