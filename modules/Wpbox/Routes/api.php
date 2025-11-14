<?php

use Illuminate\Http\Request;
use Modules\Wpbox\Http\Controllers\ChatController;
use Modules\Wpbox\Http\Controllers\CampaignsController;

Route::post('webhookapi/wpbox/receive/{token}', [ChatController::class, 'receiveMessage']);
Route::get('webhookapi/wpbox/receive/{token}', [ChatController::class, 'verifyWebhook']);

Route::middleware('auth:api')->get('/wpbox', function (Request $request) {
    return $request->user();
});


