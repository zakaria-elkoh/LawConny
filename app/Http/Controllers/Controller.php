<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// the command to generate the docs
    // php artisan l5-swagger:generate
// the website url
    // host/api/documentation

/**
*    @OA\Info(
*    title="Post API",
*    version="1.0.0",
*    description="API to manage posts",
*    )
*/

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
