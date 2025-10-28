<?php

namespace Modules\Wpbox\Models;

use App\Models\Company;
use Illuminate\Support\Facades\Log;
use Modules\Contacts\Models\Contact as ModelsContact;
use Modules\Contacts\Models\Group;
use Modules\Wpbox\Events\AgentReplies;
use Modules\Wpbox\Events\ContactReplies;
use Modules\Wpbox\Notifications\ContactReplies as NotificationContactReplies;
use Modules\Wpbox\Events\Chatlistchange;
use Modules\Wpbox\Traits\Whatsapp;
 



class Contact extends ModelsContact
{
    use Whatsapp;


    public function notes()
    {
        return $this->hasMany(
                Message::class
            )->where('is_note', true)->orderBy('created_at','DESC');
    }

    public function trimString($str, $maxLength) {
        if (mb_strlen($str) <= $maxLength) {
            return $str;
        } else {
            $trimmed = mb_substr($str, 0, $maxLength);
            $lastSpaceIndex = mb_strrpos($trimmed, ' ');
    
            if ($lastSpaceIndex !== false) {
                return mb_substr($trimmed, 0, $lastSpaceIndex) . '...';
            } else {
                return $trimmed . '...';
            }
        }
    }

    

    
    public function sendDemoMessage($content,$is_message_by_contact=true,$is_campaign_messages=false,$messageType="TEXT",$fb_message_id=null){
        //Check that all is set ok

        //Create the messages
         $messageToBeSend=Message::create([
            "contact_id"=>$this->id,
            "company_id"=>$this->company_id,
            "value"=>$messageType=="TEXT"?$content:"",
            "header_image"=>$messageType=="IMAGE"?$content:"",
            "header_document"=>$messageType=="DOCUMENT"?$content:"",
            "header_video"=>$messageType=="VIDEO"?$content:"",
            "header_location"=>$messageType=="LOCATION"?$content:"",
            "is_message_by_contact"=>$is_message_by_contact,
            "is_campign_messages"=>$is_campaign_messages,
            "status"=>1,
            "buttons"=>"[]",
            "components"=>"",
            "fb_message_id"=>$fb_message_id
         ]);
         $messageToBeSend->save();

         
    }

    public function addNote($content){
        $messageToBeSend=Message::create([
            "contact_id"=>$this->id,
            "company_id"=>$this->company_id,
            "value"=>$content,
            "header_text"=>__('Note'),
            "header_image"=>"",
            "header_document"=>"",
            "header_video"=>"",
            "header_location"=>"",
            "is_message_by_contact"=>false,
            "is_campign_messages"=>false,
            "status"=>4,
            "buttons"=>"[]",
            "components"=>"",
            "is_note"=>true,
            "fb_message_id"=>null
         ]);
         if(auth()->check()){
            $messageToBeSend->sender_name=auth()->user()->name;
        } 
         $messageToBeSend->save();

         $companyUser=Company::findOrFail($this->company_id)->user;
         event(new AgentReplies($companyUser,$messageToBeSend,$this));

         return $messageToBeSend;
    }



        /**
     * $reply - Reply - The reply to be send
     */
    public function sendReply(Reply $reply){
        //Create the message
        $buttons=[];

        for ($i=1; $i < 4; $i++) { 
            if ($reply->{"button".$i} != "") {
                $buttons[sizeof($buttons)] = [
                    "type" => "reply",
                    "reply" => [
                        "id" => $reply->{"button".$i."_id"},
                        "title" => $reply->{"button".$i}
                    ]
                ];
            }
        }


        //If buttons is empty array
        $is_cta=false;
        if(sizeof($buttons)==0){
            //MANDA UN ARCHIVO EN LUGAR DE CTA
            if($reply->button_name &&  $reply->button_name!="" && $reply->button_url && $reply->button_url!=""){
                $is_cta=true;
                $buttons[0] = 
                    [
                        "link" => $reply->button_url,
                        "filename" => $reply->button_name
                    ];
                
            }

        }
        
 
       // AQUI GUARDA EL MENSAJE DE REPLY

        $messageToBeSend=Message::create([
            "contact_id"=>$this->id,
            "company_id"=>$this->company_id,
            "value"=>$reply->text,
            "header_text"=>$reply->header,
            "footer_text"=>$reply->footer,
            "buttons"=>json_encode($buttons),
            "is_message_by_contact"=>false,
            "is_campign_messages"=>false,
            "status"=>1,
            "fb_message_id"=>null
        ]);
        $messageToBeSend->save();
        if($is_cta){
            $messageToBeSend->is_cta=true;
        }
       

        $this->last_support_reply_at=now();
        $this->is_last_message_by_contact=false;
        $this->sendMessageToWhatsApp($messageToBeSend,$this);
        //Find the user of the company
        $companyUser=Company::findOrFail($this->company_id)->user;
        event(new AgentReplies($companyUser,$messageToBeSend,$this));

        $this->last_message=$this->trimString($reply->text,40);
        $this->update();

        return $messageToBeSend;

    }


    public function botReply($content,$messageToBeSend){
                //Reply bot ordenado por type para que el ultimo  sea el de bienvenida
                // sin quick replies ni welcome ( el welcome es despues del flow)
                   $textReplies = Reply::whereNotIn('type', [1, 5])
                    ->where('company_id', $this->company_id)
                    ->orderBy('type', 'asc')
                    ->get();
                $replySend=false;
                
                foreach ($textReplies as $key => $qr) {
                    // Log::info('For botReply checando si hay un replay para el texto escrito', ['INFO' => $qr]);    
    
                    if(!$replySend){
                         
    
                        $replySend=$qr->shouldWeUseIt($content,$this);
                    }
                }

                //If no text reply found, look for campaign reply
                if(!$replySend){
                    $campaignReplies=Campaign::where('is_bot',1)->where('is_bot_active',1)->where('company_id',$this->company_id)->get();
                    foreach ($campaignReplies as $key => $cr) {
                     //   Log::info('For botReply de  Campañas checando si hay un replay para el texto escrito', ['INFO' => $qr]);    
    
                        if(!$replySend){
                             Log::info('Entra a shouldWeUseIt de Campañas', ['INFO' => $qr]);   
                            $replySend=$cr->shouldWeUseIt($content,$this);
                          
                        }
                    }
                }
             Log::info('replySEND', ['INFO' => $replySend]);  
                if($replySend){
                     Log::info('SI encontro para mandar del bot reply', ['INFO' => "entra"]);   
                    $messageToBeSend->bot_has_replied=true;
                    $messageToBeSend->update();
                }else{
                     Log::info('No encontro nada para mandar del bot reply, ira al FLOW o despues al Welcome', ['INFO' => "No hay mensaje"]);   
                   
                }

    }
    

public function botReplyWelcome($content, $messageToBeSend){
    // Solo el welcome
    $textReplies = Reply::where('type', 5)
        ->where('company_id', $this->company_id)
        ->orderBy('type', 'asc')
        ->get();
    $replySend = false;

    foreach ($textReplies as $key => $qr) {
        if (!$replySend) {
            $replySend = $qr->shouldWeUseIt($content, $this);
        }
    }

    Log::info('replyWELCOME', ['INFO' => $replySend]);  
    if ($replySend) {
        Log::info('SI encontro para mandar del bot reply WELCOME', ['INFO' => "entra"]);   
        $messageToBeSend->bot_has_replied = true;
        $messageToBeSend->update();
        return $messageToBeSend; // <-- RETORNA el mensaje actualizado
    } else {
        Log::info('No encontro nada para mandar del bot reply WELCOME, PROCEDE A ver si manda aviso a Humano', ['INFO' => "No hay mensaje"]);   
        $reply = new Reply();
        $replySend = $reply->MensajeAviso($content, $this);
        return null; // <-- O false si prefieres
    }
}
    


     /**
     * $content- String - The content to be stored, text or link
     * $is_message_by_contact - Boolean - is this a message send by contact - RECEIVE
     * $is_campaign_messages - Boolean - is this a message generated from campaign
     * $messageType [TEXT | IMAGE | VIDEO | DOCUMENT ]
     * $fb_message_id String - The Facebook message ID
     */
    public function sendMessage($content,$is_message_by_contact=true,$is_campaign_messages=false,$messageType="TEXT",$fb_message_id=null,$extra = null){
        //Check that all is set ok

        //If message is from contact, and fb_message_id is set, check if the message is already in the system
        if($is_message_by_contact && $fb_message_id){
            $message=Message::where('fb_message_id',$fb_message_id)->first();
            if($message){
                return $message;
            }
        }

        //GUARDAR MENSAJE EN LA TABLA MESSAGES
         $messageToBeSend=Message::create([
            "contact_id"=>$this->id,
            "company_id"=>$this->company_id,
            "value"=>$messageType=="TEXT"?$content:"",
            "header_image"=>$messageType=="IMAGE"?$content:"",
            "header_document"=>$messageType=="DOCUMENT"?$content:"",
            "header_video"=>$messageType=="VIDEO"?$content:"",
            "header_audio"=>$messageType=="AUDIO"?$content:"",
            "header_location"=>$messageType=="LOCATION"?$content:"",
            "is_message_by_contact"=>$is_message_by_contact,
            "is_campign_messages"=>$is_campaign_messages,
            "status"=>1,
            "buttons"=>"[]",
            "components"=>"",
            "fb_message_id"=>$fb_message_id,
            "extra"  => $extra, // <-- agrega esta línea
         ]);
         $messageToBeSend->save();

           Log::info('Mensaje guardado en la tabla de Mensajes', ['flowData' => $content]);

        //Update the contact last message, time etc
        

        if(!$is_campaign_messages){
            $this->has_chat=true;
            $this->last_reply_at=now();
            if($is_message_by_contact){
                $this->last_client_reply_at=now();
                $this->is_last_message_by_contact=true;
                Log::info('Entra al BotReply <> campaña', ['flowData' => $content]);

                //Reply bots
                $this->botReply($content,$messageToBeSend);

           
             
                event(new ContactReplies(auth()->user(),$messageToBeSend,$this));
                event(new Chatlistchange($this->id,$this->company_id)); 
                

            }else{
                  Log::info('Entra al BotReply == campaña', ['flowData' => $content]);
                $this->last_support_reply_at=now();
                $this->is_last_message_by_contact=false;
                $this->sendMessageToWhatsApp($messageToBeSend,$this);
               
              
               
                  event(new AgentReplies(auth()->user(),$messageToBeSend,$this));
            }    
        }
        $this->last_message=$this->trimString($content,40);
        $this->update();

       


        
        return $messageToBeSend;
    }
   


//CONTRUYE EL CONTACTO COMPLETO PARA MANDAR A LA VISTA DE CHAT
public function getFullContactForBroadcast()
{
    $contact = self::with([
        'groups',
        'country',
        'fields' => function($query) {
            $query->select('custom_contacts_fields.id', 'name')
                ->withPivot('value');
        },
        'messages' => function($query) {
            $query->orderBy('created_at', 'DESC')->limit(10);
        }
    ])->find($this->id);

    // Procesar custom_fields igual que en el controlador
    $fieldsTemplate = app(\Modules\Wpbox\Http\Controllers\ChatController::class)->getFields('col-md-4', true);
    $contact->custom_fields = collect($fieldsTemplate)->map(function ($field) use ($contact) {
        $field['value'] = $contact->fields->firstWhere('id', $field['id'])->pivot->value ?? null;
        return $field;
    })->toArray();

    return $contact;
}




//funcion para MANDAR A LLAMAR A LA FUNCION DE TEMPLATE DE AVISOS DE MENSAJES
public function sendReplyAviso(Contact $contact)
{
    Log::info("Entra a SendReplyAviso: ".$contact->id);

    // Último mensaje del agente
    $lastAgentMessage = Message::where('contact_id', $contact->id)
        ->where('is_message_by_contact', 0)
        ->orderBy('id', 'desc')
        ->first();

    // Mensaje del contacto más reciente
    $lastContactMessage = Message::where('contact_id', $contact->id)
        ->where('is_message_by_contact', 1)
        ->orderBy('id', 'desc')
        ->first();

    // Si no hay mensaje del contacto, no hacer nada
    if (!$lastContactMessage) {
        Log::info("No hay mensajes del contacto, no se manda aviso.");
        return;
    }

    // Si el último mensaje del agente es posterior al último mensaje del contacto, no hacer nada
    if ($lastAgentMessage && $lastAgentMessage->id > $lastContactMessage->id) {
        Log::info("El agente ya respondió después del último mensaje del contacto, no se manda aviso.");
        return;
    }

    // ¿Ya hay un mensaje del contacto SIN respuesta del agente y con aviso_sent?
    $avisoSent = Message::where('contact_id', $contact->id)
        ->where('is_message_by_contact', 1)
        ->where('id', '>', $lastAgentMessage ? $lastAgentMessage->id : 0)
        ->where('extra', 'aviso_sent')
        ->exists();

    if ($avisoSent) {
        Log::info("Ya se mandó aviso para este bloque de mensajes, no se repite.");
        // Marca el mensaje actual también, por si acaso
        $lastContactMessage->extra = 'aviso_sent';
        $lastContactMessage->save();
        return;
    }

    // Si no se ha mandado aviso, mándalo y marca el mensaje
    Log::info("Mandando aviso de humano por mensaje del contacto.");
    $this->sendTemplateMessageToWhatsAppAviso($contact);
    $lastContactMessage->extra = 'aviso_sent';
    $lastContactMessage->save();
}

  
}
