<?php

namespace Modules\Wpbox\Traits;

use App\Models\Company;
use App\Models\Config;
use Modules\Wpbox\Models\Message;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Http\Request;
// use Modules\Contacts\Models\Contact;
use Modules\Wpbox\Models\Contact;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Modules\Wpbox\Models\Campaign;
use Modules\Wpbox\Models\Template;
use Illuminate\Support\Facades\Log;

trait Whatsapp
{

    public static $facebookAPI = 'https://graph.facebook.com/v19.0/';

    private function getToken(Company $company=null){
        if($company==null){
            $company=$this->getCompany();
        }
        return $company->getConfig('whatsapp_permanent_access_token','');
    }

    private function getPhoneID(Company $company=null){
        if($company==null){
            $company=$this->getCompany();
        }
        return $company->getConfig('whatsapp_phone_number_id','');
    }

    private function getAccountID(Company $company=null){
        if($company==null){
            $company=$this->getCompany();
        }
        return $company->getConfig('whatsapp_business_account_id','');
    }



    // FUNCION PARA MANDAR EL MENSAJE DE AVISO POR TEMPLATE, ANTES ERA
    //sendMessageToWhatsAppAviso

private function sendTemplateMessageToWhatsAppAviso(Contact $contact)
{
    $company = $this->getCompany();

    $aviso_mensaje_sino = $company->getConfig('aviso_mensaje_sino', 'false');
    $aviso_mensaje_template = $company->getConfig('aviso_mensaje_template', 'aviso_mensajes1');
    $aviso_mensaje_celular = $company->getConfig('aviso_mensaje_celular', '');
    $aviso_mensaje_lenguaje = $company->getConfig('aviso_mensaje_lenguaje', '');

    // Log::info("[AVISO] Configuración", [
    //     'aviso_mensaje_sino' => $aviso_mensaje_sino,
    //     'aviso_mensaje_template' => $aviso_mensaje_template,
    //     'aviso_mensaje_celular' => $aviso_mensaje_celular,
    //     'aviso_mensaje_lenguaje' => $aviso_mensaje_lenguaje,
    //     'contact_id' => $contact->id,
    //     'contact_name' => $contact->name,
    // ]);

    if ($aviso_mensaje_sino === "false") {
       // Log::info("[AVISO] NO MANDA MENSAJE DE AVISO, PORQUE NO ESTA ACTIVADO");
        return false;
    }

   // Log::info("[AVISO] ENTRA A INTENTAR MANDAR MENSAJE DE AVISO");

    if ($company) {
        $url = self::$facebookAPI . $this->getPhoneID($company) . '/messages';
        $accessToken = $this->getToken($company);

        Log::info("[AVISO] URL y Token", [
            'url' => $url,
            'accessToken' => substr($accessToken, 0, 8) . '...'
        ]);

        // Obtener el último mensaje del contacto
        $lastUserMessage = \Modules\Wpbox\Models\Message::where('contact_id', $contact->id)
            ->where('is_message_by_contact', 1)
            ->orderBy('id', 'desc')
            ->first();

        $userMessageText = $lastUserMessage ? $lastUserMessage->value : '';
        Log::info("[AVISO] Último mensaje del usuario", [
            'lastUserMessage_id' => $lastUserMessage ? $lastUserMessage->id : null,
            'userMessageText' => $userMessageText
        ]);

        $componentsArray = [
            [
                "type" => "body",
                "parameters" => [
                    [
                        "type" => "text",
                        "text" => $contact->name
                    ],
                    [
                        "type" => "text",
                        "text" => $userMessageText
                    ]
                ]
            ]
        ];

       // Log::info("[AVISO] Components Array", $componentsArray);

        $componentsJson = json_encode($componentsArray);
        $components = json_decode($componentsJson, true);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post($url, [
                'messaging_product' => 'whatsapp',
                'to' => $aviso_mensaje_celular,
                'type' => 'template',
                'template' => [
                    'name' => $aviso_mensaje_template,
                    'language' => [
                        'code' => $aviso_mensaje_lenguaje
                    ],
                    'components' => $components
                ]
            ]);

            $statusCode = $response->status();
            $content = json_decode($response->body(), true);

            // Log::info("[AVISO] Respuesta de WhatsApp", [
            //     'statusCode' => $statusCode,
            //     'content' => $content
            // ]);
        } catch (\Exception $e) {
            Log::error("[AVISO] Error al mandar mensaje de aviso", [
                'error' => $e->getMessage()
            ]);
        }
    }
}

   
// funcion que manda los mensajes de la campaña a whatsapp desde el job o normal es lo que 
// se ejecuta al apretar el boton de ENVIAR MENSAJES PENDIENTES ( LOS QUE TIENEN STATUS 0 )
    private function sendCampaignMessageToWhatsApp(Message $message)
{
    //We need data per company
    $company = null;
    try {
        $company = $message->campaign->company;
        $message->contact->phone;
    } catch (\Throwable $th) {
        $message->error = "The company or contact is not found";
        $message->status = 5;
        $message->update();
          return; // Salir de la función, no continuar con el proceso
    }



      // Validación del número de teléfono
    if ($message->contact->phone === '0000000000') {
        $message->error = "El número no esta especificado";
        $message->status = 5;
        $message->update();
        return; // Salir de la función, no continuar con el proceso
    }



    if ($company) {
        $url = self::$facebookAPI . $this->getPhoneID($company) . '/messages';
        $accessToken = $this->getToken($company);

        // --- Aquí creas el array antes de enviarlo ---
        $dataToSend = [
            'messaging_product' => 'whatsapp',
            'to' => $message->contact->phone,
            'type' => 'template',
            'template' => [
                "name" => $message->campaign->template->name,
                "language" => [
                    "code" => $message->campaign->template->language
                ],
                "components" => json_decode($message->components)
            ]
        ];

        // Puedes poner un breakpoint aquí o usar dd/log para ver el array:
        // dd($dataToSend);
        // \Log::info('WhatsApp JSON:', $dataToSend);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post($url, $dataToSend);

            $statusCode = $response->status();
            $content = json_decode($response->body(), true);
            
            $message->mandado_at = now();
            if (isset($content['messages'])) {
                $message->fb_message_id = $content['messages'][0]['id'];
            } else {
                $message->error = isset($content['error']) ? $content['error']['message'] : "Unknown error";
            }
           
            $message->update();
        } catch (\Exception $e) {
            // Manejo de excepción
        }
    }
}

// Este es el webhook que recibe los mensajes de whatsapp
    public function receiveMessage(Request $request,$token){
       
         // Log::info("[MENSAJE RECIBIDO] Recibiendo mensaje", ['request' => $request->all()]);
        $token = PersonalAccessToken::findToken($token);
  
        if ($token) {

         //   Log::info("[MENSAJE RECIBIDO] TOKEN VALIDO");
            // Token is valid
            // Proceed with the request handling

            //Find the user
            $user=User::findOrFail($token->tokenable_id);
            Auth::login($user);

            //if the user is admin
            if($user->hasRole('admin')){
                //Find company based on the WABAID
                $wabaid=$request->entry[0]['id'];
                $company_id=Config::where('value',$wabaid)->first()->model_id;
                if($company_id){
                    $company=Company::find($company_id);
                    if(!$company){
                       // Log::info("[MENSAJE RECIBIDO] Company not found 1");
                        return response()->json(['send' => false,'error'=>"Company not found"]);
                         
                    }
                }else{
                    // Log::info("[MENSAJE RECIBIDO] Company not found 2");
                    return response()->json(['send' => false,'error'=>"Company not found"]);
                     
                }
            }else{
                 //Company
                $company=$this->getCompany();
                 //Log::info("[MENSAJE RECIBIDO] Company found", ['company_id' => $company->id]);
            }
            
           

            //Resend the Request to webhook
            try {
                $whatsapp_data_send_webhook=$company->getConfig('whatsapp_data_send_webhook',"");
                if(strlen($whatsapp_data_send_webhook)>5){
                    //Send the data to a webhook
                    Http::post($whatsapp_data_send_webhook, $request->all());
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
            
            //Get the message object
            try {
                $value=$request->entry[0]['changes'][0]['value'];
                if(isset($value['statuses'])){

                    //Status change -- Message update
                    $newStatus=$value['statuses'][0]['status'];
                    $messageFBID=$value['statuses'][0]['id'];
                    $message=Message::where('fb_message_id',$messageFBID)->first();
                    if($message){

                         $message_previous_status=$message->status;
                        if($newStatus=="sent"&&$message->status!=3){
                            $message->status=2;
                        }else if($newStatus=="delivered"&&$message->status!=4){
                            $message->status=3;
                        }else if($newStatus=="read"){
                            $message->status=4;
                        }else if($newStatus=="failed"){
                            $message->status=5;
                            $message->error=$value['statuses'][0]['errors'][0]['message'];
                        }
                        $message->update();
                         if($message->campaign_id!=null &&  $message_previous_status!=$message->status){
                        //  if($message->campaign_id!=null){
                            $campaign=Campaign::where('id',$message->campaign_id)->first();
                           
                        if ($campaign) {
                            $campaign->sended_to = \Modules\Wpbox\Models\Message::where('campaign_id', $campaign->id)
                                ->where('status', '<>', 0)
                                ->count();

                            $campaign->sending_to = \Modules\Wpbox\Models\Message::where('campaign_id', $campaign->id)
                                ->where('status', 1)
                                ->count();

                            $campaign->delivered_to = \Modules\Wpbox\Models\Message::where('campaign_id', $campaign->id)
                                ->whereIn('status', [2, 3, 4, 6])
                                ->count();

                            $campaign->read_by = \Modules\Wpbox\Models\Message::where('campaign_id', $campaign->id)
                                ->where('status', 4)
                                ->count();

                          $campaign->con_error = \Modules\Wpbox\Models\Message::where('campaign_id', $campaign->id)
                                ->where('status', 5)
                                ->count();

                            $campaign->contestado_por = \Modules\Wpbox\Models\Message::where('campaign_id', $campaign->id)
                                ->where('status', 6)
                                ->count();

                            $campaign->update();
                        }
                           
                         
                            
                        }
                    }
                }else{
                    //Message receive
                     // Log::info("[MENSAJE RECIBIDO] Message receive", ['value' => $value]);
                    $phone=$value['messages'][0]['from'];

                     //Check if this phone is in the blacklist
                    $blacklist=$company->getConfig('black_listed_phone_numbers',"");
                    if(strlen($blacklist)>5){
                        $blacklist=explode(",",$blacklist);
                        
                        if(in_array($phone,$blacklist)){
                            return response()->json(['send' => false,'error'=>"Blacklisted"]);
                        }
                    }

                    $type=$value['messages'][0]['type'];
                    $name=$value['contacts'][0]['profile']['name'];
                    $messageID=$value['messages'][0]['id'];

                    //Find the contact
                    $contact=Contact::where('phone',$phone)->orWhere('phone',"+".$phone)->first();

                    if(!$contact){
                        //Create new contact
                        $contact=Contact::create([
                            'name' => $name . '_' . now()->format('YmdHis'), // Ejemplo: Juan_20251008143025
                            'phone' =>  $phone,
                            'avatar'=> '',
                            'company_id'=>$company->id,
                            'has_chat'=>true,
                            'created_at' => now(),
                            'updated_at' => now(),
                            'enabled_ai_bot' => 1,
                            'subscribed' => 1,

                            'last_support_reply_at'=>null,
                            'last_reply_at'=>now(),
                            "last_message"=>"",
                            "is_last_message_by_contact"=>true,    
                        ]);
                    }

                    

                    if($type=="image"){
                        //We need to download and store the image
                        $urlLink=$this->downloadAndStoreMedia($value['messages'][0]['image']['id'],".jpg");
                        $message=$contact->sendMessage($urlLink,true,false,"IMAGE",$messageID);
                    }else if($type=="audio"){
                        // We need to download and store the audio
                        $urlLink = $this->downloadAndStoreMedia($value['messages'][0]['audio']['id'], '.mp3');
                        $message = $contact->sendMessage($urlLink, true, false, "AUDIO", $messageID);
                    } else if($type=="video"){
                        //We need to download and store the video
                        $urlLink=$this->downloadAndStoreMedia($value['messages'][0]['video']['id'],'.mp4');
                        $message=$contact->sendMessage($urlLink,true,false,"VIDEO",$messageID);
                    }else if($type=="document"){
                        //We need to download and store the video
                        $urlLink=$this->downloadAndStoreMedia($value['messages'][0]['document']['id'],'.pdf');
                        $message=$contact->sendMessage($urlLink,true,false,"DOCUMENT",$messageID);
                    }else if($type=="text"){
                        
                        $message=$value['messages'][0]['text']['body'];
                        //Store the message
                        $message=$contact->sendMessage($message,true,false,"TEXT",$messageID);

                    }else 
                    
                     if($type=="interactive"){
                        if($value['messages'][0]['interactive']['type']=="button_reply"){
                   
                            $messageContent = $value['messages'][0]['interactive']['button_reply']['title'];
                            $buttonId = $value['messages'][0]['interactive']['button_reply']['id'];
                            // Guarda el mensaje y el ID del botón
                            $message = $contact->sendMessage($messageContent, true, false, "TEXT", $messageID, $buttonId);
                          //  Log::info("desde el archivo whatsapp", [
                           //                     'message_id' => $message->id ?? null,
                          //                      'message_value' => $message->value ?? null,
                                            // 'full_message' => $message,
                          //                      'extra' => $message->extra ?? null,
                           //                 ]);
                            
                            try {
                                $contact->botReply($buttonId, $message);
                            } catch (\Throwable $th) {
                                // Manejo de error
                            }
                        }
                    }
                    
                    else if($type=="contacts"||$type=="contact"){
                        $message=$contact->sendMessage(__("Contact message is sent. But the message format is unsupported"),true,false,"TEXT",$messageID);
                    }else if($type=="location"){

                        //return response()->json(['send' => "Location"]);
                        $message="https://www.google.com/maps?q=".$value['messages'][0]['location']['latitude'].','.$value['messages'][0]['location']['longitude'];
                        //Store the message
                        $message=$contact->sendMessage($message,true,false,"LOCATION",$messageID);
                    }else if($type=="button"){
                        $message=$value['messages'][0]['button']['text'];
                        //Store the message
                        $message=$contact->sendMessage($message,true,false,"TEXT",$messageID);
                    } 
                    
                    
                }
      
                return response()->json(['send' => true]);


            } catch (\Throwable $th) {
               return response()->json(['send' => false,'error'=>$th,'data'=>$request->all()]);
            }

           
        }else{
            return response()->json(['send' => false]);
        }
    }

    public function downloadAndStoreMedia($mediaID,$ext=".jpg"){
        $url =  self::$facebookAPI.$mediaID;
        $accessToken = $this->getToken();
        $company=$this->getCompany();
        try {
 
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->get($url);
        
            
            $statusCode = $response->status();
            $content = json_decode($response->body(),true);

            $responseImage = $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($content['url']);
        
            $fileContents = $responseImage->getBody()->getContents();
            

            // Define the local path where you want to save the downloaded file
            if(config('settings.use_s3_as_storage',false)){
                //S3 - store per company
                $fileName='uploads/media/received/'.$company->id."/".$content['id'].$ext;
                $path = Storage::disk('s3')->put($fileName, $fileContents,'public');
                return Storage::disk('s3')->url($fileName);
            }else{
                //Regular
                $localPath = public_path('uploads/media/'.$content['id'].$ext);
                file_put_contents($localPath, $fileContents);
                $url=config('app.url')."/uploads/media/".$content['id'].$ext;
                return preg_replace('#(https?:\/\/[^\/]+)\/\/#', '$1/', $url);
            }
    

        }catch (\Exception $e) {
            dd($e);
            // Handle the exception
        }
    }


// Este es el Webhook que verifica el si pasa la peticion del Webhook
//https://movil.alever.mx/webhook/wpbox/receive/l3UxwKHZ2htHYwizOFGTDeR0I8B6ee7c5FYhDa4he308bee6?hub.mode=subscribe&hub.verify_token=l3UxwKHZ2htHYwizOFGTDeR0I8B6ee7c5FYhDa4he308bee6&hub.challenge=123456

    public function verifyWebhook(Request $request,$tokenViaURL){
        // Parse params from the webhook verification request
        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');
        
        $token = PersonalAccessToken::findToken($token);
        if ($token) {
            // Token is valid
            // Proceed with the request handling
            // Check if a token and mode were sent
            if ($mode && $token) {
                // Check the mode and token sent are correct
                if ($mode === 'subscribe') {
                    $user=User::findOrFail($token->tokenable_id);
                    Auth::login($user);

                    //Company
                    $company=$this->getCompany();

                    $company->setConfig('whatsapp_webhook_verified',"yes");

                    // Respond with 200 OK and challenge token from the request
                    return response($challenge.'simon', 200);
                } else {
                    // Respond with '403 Forbidden' if verify tokens do not match
                    return response()->json([], 403);
                }
            }
        }else{
            return response()->json([], 403);
        }

        

       
    }


/**
     * Upload a file to facebook and return the handle using the upload API
     */
    public function uploadDocumentToFacebook($file){
        //Upload a file to facebook and return the handle using the upload API
        $company=$this->getCompany();
        $facebook_app_id=$company->getConfig('whatsapp_business_account_id','');
        if(strlen($facebook_app_id)<5){
            throw new \Exception('Facebook App ID is not set. Please set it in the App Settings.');
        }
        $url =  self::$facebookAPI.$facebook_app_id.'/media';
        $mediaURL=self::$facebookAPI.$facebook_app_id.'/uploads';
        $accessToken = $this->getToken();

        //Get an upload sessions id
        try {
            // First get an upload session ID
            $uploadSessionResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post($mediaURL, [
                'file_length' => $file->getSize(),
                'file_type' => $file->getMimeType(),
                'file_name' => $file->getClientOriginalName()
            ]);


            $uploadSession = json_decode($uploadSessionResponse->body(), true);

            if (!isset($uploadSession['id'])) {
                throw new \Exception('Failed to get upload session ID');
            }

            
            $uploadURL=self::$facebookAPI . $uploadSession['id'];


            // Now upload the actual file using the session ID
            $response = Http::withHeaders([
                'Authorization' => 'OAuth ' . $accessToken,
                'Content-Type' => 'application/json',
                'file_offset' => '0'
            ])->withBody(
                file_get_contents($file->getRealPath()),
                $file->getMimeType()
            )->post($uploadURL);

    

            $result = json_decode($response->body(), true);
            
            if (isset($result['h'])) {
                return $result['h']; // Return the handle
            }

            throw new \Exception('Failed to upload document');

        } catch (\Exception $e) {
            // Handle any errors
            // Log::error('Facebook document upload failed: ' . $e->getMessage());
            return null;
        }
    }

    public function submitWhatsAppTemplate($templateData){
        $company=$this->getCompany();
        $url =  self::$facebookAPI.$this->getAccountID().'/message_templates';
        $accessToken = $this->getToken();
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post($url, $templateData);
        
            
            $statusCode = $response->status();
            $content = json_decode($response->body(),true);
            return ['status'=>$statusCode,'content'=>$content];
        } catch (\Exception $e) {
            // Handle the exception
            return ['status'=>500,'content'=>$e->getMessage()];
        }
    }

    public function deleteWhatsAppTemplate($templateName){
        $company=$this->getCompany();
        $url =  self::$facebookAPI.$this->getAccountID().'/message_templates?name='.$templateName;
        $accessToken = $this->getToken();
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->delete($url);
        
            
            $statusCode = $response->status();
            $content = json_decode($response->body(),true);
            return ['status'=>$statusCode,'content'=>$content];
        } catch (\Exception $e) {
            // Handle the exception
            return ['status'=>500,'content'=>$e->getMessage()];
        }
    }




public function loadTemplatesFromWhatsApp($after = "")
{
   // Log::info('Entra a LoadTemplates', ['INFO' =>  "entra a LoadTemplates"]);
    $url = self::$facebookAPI . $this->getAccountID() . '/message_templates';
   // Log::info('URL', ['INFO' =>  $url]);
    $queryParams = [
        'fields' => 'name,category,language,quality_score,components,status',
        'limit' => 100
    ];
    if ($after != "") {
        $queryParams['after'] = $after;
    }
    $headers = [
        'Authorization' => 'Bearer ' . $this->getToken()
    ];

    $response = Http::withHeaders($headers)->get($url, $queryParams);

   // Log::info('response', ['INFO' =>   $response]);

    if ($response->successful()) {
        $responseData = $response->json();
       // Log::info('response', ['INFO' =>   "Success"]);

        $companyID = $this->getCompany()->id;

        // 1. Obtén los IDs de la API
        $apiTemplateIds = collect($responseData['data'])->pluck('id')->toArray();

        // 2. Soft delete solo los que ya no existen en la API
        Template::where('company_id', $companyID)
            ->whereNotIn('id', $apiTemplateIds)
            ->update(['deleted_at' => now()]);

        // 3. Upsert los templates de la API
        foreach ($responseData['data'] as $template) {
            try {
                $data = [
                    'id' => $template['id'],
                    'name' => $template['name'],
                    'category' => $template['category'],
                    'language' => $template['language'],
                    'status' => $template['status'],
                    'company_id' => $companyID,
                    'components' => json_encode($template['components']),
                    'deleted_at' => null,
                ];
                Template::updateOrCreate(
                    ['id' => $template['id'], 'company_id' => $companyID],
                    $data
                );
               // Log::info('Insert/Update Template', ['INFO' => $template['name']]);
            } catch (\Throwable $th) {
               // Log::error('Error inserting/updating template', [
               //     'name' => $template['name'],
                //    'error' => $th->getMessage()
               // ]);
            }
        }

        // Si hay más páginas, sigue
        if (
            isset($responseData['paging']['next']) &&
            isset($responseData['paging']['cursors']['after'])
        ) {
            return $this->loadTemplatesFromWhatsApp($responseData['paging']['cursors']['after']);
        } else {
            return true;
        }
    } else {
        //Log::error('xError loading templates from WhatsApp', [
        //    'status' => $response->status(),
       //     'body' => $response->body()
       // ]);
        return false;
    }
}




//codigo nuevo que corta los mensajes si se pasan de la longitud


public function sendMessageToWhatsApp(Message $message, $contact){
    $url =  self::$facebookAPI.$this->getPhoneID().'/messages';
    $accessToken = $this->getToken();

    if(strlen($accessToken>5)){
        try {

            $dataToSend=[
                'messaging_product' => 'whatsapp',
                'recipient_type'=> 'individual',
                'to' => $contact->phone, // Add recipient information
            ];

            if(strlen($message->buttons)>5){ // inicio si es interactivo
                //Interactive message

                if($message->is_cta){ // CAMBIO para que mande archivo cuando sea un CTA
                    $dataToSend['type']='document';
                    $dataToSend['document']= array_values(json_decode($message->buttons,true))[0];
                }else{
                    $dataToSend['type']='interactive'; // son botones normales sin CTA
                    $dataToSend['interactive']['type']="button";

                    //Header if available
                    if(strlen($message->header_text)>0){
                        $headerText = mb_substr($message->header_text, 0, 50);
                        $dataToSend['interactive']['header']=[
                            'type' => 'text',
                            'text' => $headerText,
                        ];
                    }

                    $dataToSend['interactive']['body']=[
                        'text' => $message->value,
                    ];

                    //Footer if available
                    if(strlen($message->footer_text)>0){
                        $footerText = mb_substr($message->footer_text, 0, 50);
                        $dataToSend['interactive']['footer']=[
                            'text' => $footerText,
                        ];
                    }

                    // Cortar los títulos de los botones a 20 caracteres
                    $buttons = array_values(json_decode($message->buttons,true));
                    foreach ($buttons as &$button) {
                        if (isset($button['type']) && $button['type'] === 'reply' && isset($button['reply']['title'])) {
                            $button['reply']['title'] = mb_substr($button['reply']['title'], 0, 20);
                        }
                    }

                    //->is_cta is runtime property
                    if($message->is_cta){
                        unset($message->is_cta); //We don't need this, since will cause error
                        $dataToSend['interactive']['action']= $buttons[0];
                    }else{
                        //Reply buttons
                        $dataToSend['interactive']['action']['buttons']= $buttons;
                    }
                }// fin del else donde se pone todo lo interactivo
            } // fin de si es interactivo

            else if(strlen($message->value)>0){
                //Text message
                $dataToSend['type']='text';

                if(config('settings.is_demo',false)){
                    //Demo
                    $dataToSend['text']=[
                        'body' => "[ESTO ES UN DEMO] ".$message->value,
                        'preview_url' => true,
                    ];
                }else{
                    //Production
                    $dataToSend['text']=[
                        'body' => $message->value,
                        'preview_url' => true,
                    ];
                }
            }else if(strlen($message->header_image)>0){
                $dataToSend['type']='image';
                $dataToSend['image']=[
                    'link' => $message->header_image
                ];
            }else if(strlen($message->header_video)>0){
                if (substr($message->header_video, -4) === ".mp3") {
                    $dataToSend['type']='audio';
                    $dataToSend['audio']=[
                        'link' => $message->header_video
                    ];
                }else{
                    $dataToSend['type']='video';
                    $dataToSend['video']=[
                        'link' => $message->header_video
                    ];
                }
            }else if(strlen($message->header_audio)>0){
                $dataToSend['type']='audio';
                $dataToSend['audio']=[
                    'link' => $message->header_audio
                ];
            }else if(strlen($message->header_document)>0){
                $path = parse_url($message->header_document, PHP_URL_PATH);
                $filename = pathinfo($path, PATHINFO_FILENAME);
                $dataToSend['type']='document';
                $dataToSend['document']=[
                    'link' => $message->header_document,
                    "filename"=>$filename,
                ];
            }

            // Escribir a un archivo de registro
            // file_put_contents('xxx.log', print_r($dataToSend, true), FILE_APPEND);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post($url, $dataToSend);

            $statusCode = $response->status();
            $content = json_decode($response->body(),true);

            // If error
            if (isset($content['error'])) {
                $message->error = $content['error']['message'] ;
                $message->update();
            } else {
                $message->fb_message_id = $content['messages'][0]['id'];
                $message->update();
            }
        } catch (\Exception $e) {
            // Log::error('ERROR al mandar el mensaje', ['Error' => $e]);
            if(config('app.debug',false)){
                dd($e);
            }
        }
    }
}




}