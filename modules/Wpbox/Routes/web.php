<?php
 
use Modules\Wpbox\Http\Controllers\CampaignsTypesController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// para cambair el status del enable_bot en la seccion del CHAT
// E:\wpbox\modules\Contacts\Routes\web.php
Route::post('/api/contacts/{id}/toggle-enabled-bot', 'Modules\Contacts\Http\Controllers\Main@toggleEnabledBot');

Route::post('/api/contacts/{id}/toggle-cambiar-grupo', 'Modules\Contacts\Http\Controllers\Main@toggleCambiarGrupo');

Route::post('/api/contacts/{id}/toggle-cambiar-observacion', 'Modules\Contacts\Http\Controllers\Main@toggleCambiarObservacion');





Route::middleware(['web', 'auth', 'impersonate'])
    ->prefix('logs')
    ->name('logs.')
    ->group(function () {
        Route::get('/', function () {
            return view('wpbox::logs.index', [
                'title' => 'Logs de actividad',
                'subtitle' => 'Registros de actividad por usuario',
                'custom_table' => true,
            ]);
        })->name('index');
    });



Route::prefix('wpbox')->group(function() {
    Route::get('/', 'WpboxController@index');
});

    Route::group([
        'middleware' =>[ 'web','impersonate'],
        'namespace' => 'Modules\Wpbox\Http\Controllers'
    ], function () {
        Route::group([
            'middleware' =>[ 'web','auth','impersonate','XssSanitizer','isOwnerOnPro','Modules\Wpbox\Http\Middleware\CheckPlan'],
        ], function () {
            //Chat
            Route::get('chat', 'ChatController@index')->name('chat.index');


            //Setup
            Route::get('whatsapp/setup', 'DashboardController@setup')->name('whatsapp.setup');
            Route::post('whatsapp/setup', 'DashboardController@savesetup')->name('whatsapp.store');


            //Campaigns
            Route::get('campaigns', 'CampaignsController@index')->name('campaigns.index');
            Route::get('campaigns/{campaign}/show', 'CampaignsController@show')->name('campaigns.show');
            Route::get('campaigns/create', 'CampaignsController@create')->name('campaigns.create');
            Route::post('campaigns', 'CampaignsController@store')->name('campaigns.store');
            Route::put('campaigns/{campaign}', 'CampaignsController@update')->name('campaigns.update');
            Route::get('campaigns/del/{campaign}', 'CampaignsController@destroy')->name('campaigns.delete');



            //Campaign Types
          Route::get('tiposcampa', 'CampaignsTypesController@index')->name('campaigns.tiposcampa.index');
          
        Route::get('tiposcampa/{tiposcampa}/edit', 'CampaignsTypesController@edit')->name('campaigns.tiposcampa.edit');
        Route::get('tiposcampa/create', 'CampaignsTypesController@create')->name('campaigns.tiposcampa.create');
        Route::post('tiposcampa', 'CampaignsTypesController@store')->name('campaigns.tiposcampa.store');
        
        Route::put('tiposcampa/{tiposcampa}', 'CampaignsTypesController@update')->name('campaigns.tiposcampa.update');
        Route::get('tiposcampa/del/{tiposcampa}', 'CampaignsTypesController@destroy')->name('campaigns.tiposcampa.delete');
 
                


            //Templates
   
            Route::get('templates', 'TemplatesController@index')->name('templates.index');
            Route::get('templates/create', 'TemplatesController@create')->name('templates.create');
            Route::post('templates/store', 'TemplatesController@store')->name('templates.store');
            Route::get('templates/load', 'TemplatesController@loadTemplates')->name('templates.load');
            Route::post('templates/submit', 'TemplatesController@submit')->name('templates.submit');
            Route::delete('templates/del/{template}', 'TemplatesController@destroy')->name('templates.destroy');
            Route::post('templates/upload-image', 'TemplatesController@uploadImage')->name('templates.upload-image');
            Route::post('templates/upload-video', 'TemplatesController@uploadVideo')->name('templates.upload-video');
            Route::post('templates/upload-pdf', 'TemplatesController@uploadPdf')->name('templates.upload-pdf');







            //Replies
            Route::get('replies', 'RepliesController@index')->name('replies.index');
            Route::get('replies/{reply}/edit', 'RepliesController@edit')->name('replies.edit');
            Route::get('replies/create', 'RepliesController@create')->name('replies.create');
            Route::post('replies', 'RepliesController@store')->name('replies.store');
            Route::put('replies/{reply}', 'RepliesController@update')->name('replies.update');
            Route::get('replies/del/{reply}', 'RepliesController@destroy')->name('replies.delete');



  
            //Deactivate and activate bot
            Route::get('campaigns/deactivatebot/{campaign}', 'CampaignsController@deactivateBot')->name('campaigns.deactivatebot');
            Route::get('campaigns/activatebot/{campaign}', 'CampaignsController@activateBot')->name('campaigns.activatebot');

            //Pause and resume campaign
            Route::get('campaigns/pause/{campaign}', 'CampaignsController@pause')->name('campaigns.pause');
            Route::get('campaigns/resume/{campaign}', 'CampaignsController@resume')->name('campaigns.resume');
            Route::delete('campaigns/{campaign}', 'CampaignsController@destroycampa')->name('campaigns.destroycampa');

            Route::post('campaigns/{campaign}', 'CampaignsController@borrarerrores')->name('campaigns.borrarerrores');

            Route::post('campaigns/{campaign}/continuar', 'CampaignsController@continuar')->name('campaigns.continuar');
            
            
            //Report
            Route::get('campaigns/report/{campaign}', 'CampaignsController@report')->name('campaigns.report');
            Route::get('campaigns/report-multi', 'CampaignsController@reportMulti')->name('campaigns.reportMulti');

            //API
      
            Route::prefix('api/wpbox')->group(function() {
				Route::get('me', 'APIController@me')->name('wpbox.api.me');														   
                Route::get('campaings/apis', 'APIController@index')->name('wpbox.api.index');
                Route::get('info', 'APIController@info')->name('api.info');
                Route::get('chats/{lastmessagetime}', 'ChatController@chatlist');
                Route::get('chat/{contact}', 'ChatController@chatmessages');
                Route::post('send/{contact}', 'ChatController@sendMessageToContact');
			    Route::post('sendnote/{contact}', 'ChatController@sendNoteToContact');																	  
                Route::post('sendimage/{contact}', 'ChatController@sendImageMessageToContact');
                Route::post('sendfile/{contact}', 'ChatController@sendDocumentMessageToContact');
                Route::post('assign/{contact}', 'ChatController@assignContact');
				Route::post('setlanguage/{contact}', 'ChatController@setLanguage');
                Route::post('updateContact', 'APIController@updateContact');
                Route::post('updateAIBot', 'APIController@updateAIBot');
                Route::get('contact-groups-and-custom-fields/{contact}', 'APIController@getContactGroupsAndCustomFields');
                Route::get('notes/{contact}', 'APIController@getNotes');
																   

            });
        });

        //Webhook
        Route::prefix('webhook/wpbox')->group(function() {
            Route::post('receive/{token}', 'ChatController@receiveMessage');
            Route::get('receive/{tokenViaURL}', 'ChatController@verifyWebhook');
            Route::get('sendschuduledmessages', 'CampaignsController@sendSchuduledMessages')
               ->name('wpbox.sendscheduled'); 
            Route::get('sendschuduledmessagesconfirm', 'CampaignsController@sendSchuduledMessagesConfirm');
        });


        // EJECUTAR COLA PARA MANDAR MENSAJES PENDIENTES
			Route::get('ejecutar-cola', 'CampaignsController@ejecutarCola');	  
		   
          


        //PUBLIC API
            Route::prefix('api/wpbox')->group(function() {
            Route::post('sendtemplatemessage', 'APIController@sendTemplateMessageToPhoneNumber');
            Route::post('sendmessage', 'APIController@sendMessageToPhoneNumber');
            Route::get('getTemplates', 'APIController@getTemplates');
            Route::get('getGroups', 'APIController@getGroups');

            //getCampaigns
            Route::get('getCampaigns', 'APIController@getCampaigns');
            Route::get('getContacts', 'APIController@getContacts');
            Route::post('makeContact', 'APIController@contactApiMake');
			Route::post('sendcampaigns', 'APIController@sendCampaignMessageToPhoneNumber');  
																					 

    
			//getSingleContact
            Route::get('getSingleContact', 'APIController@getSingleContact');

                //Mobile App
             Route::post('getConversations/{lastmessagetime}', 'APIController@getConversations');
             Route::post('getMessages', 'APIController@getMessages');																	 
            
     
        });


});
