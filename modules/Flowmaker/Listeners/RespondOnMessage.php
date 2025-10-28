<?php

namespace Modules\Flowmaker\Listeners;

use App\Models\Company;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\Flowmaker\Models\Flow;
use Modules\Wpbox\Models\Reply;

class RespondOnMessage
{

    public function handleMessageByContact($event){
        try {
            $contact=$event->message->contact;
            $message=$event->message;

     

            if($contact->enabled_ai_bot&&!$message->bot_has_replied&&!$message->ai_has_replied){
            
                //Based on the contact company, find this company firs active AI Bot
                $company_id= $contact->company_id;


                //Get the company
                $company=Company::findOrFail($company_id);
                Log::info("================================");
              
                        // Log completo del mensaje recibido
                Log::info("Message received in RespondOnMessage", [
                    'message_id' => $message->id ?? null,
                    'message_value' => $message->value ?? null,
                   // 'full_message' => $message,
                    'extra' => $message->extra ?? null,
                ]);



                //Get all the flow from the company
                $flows=Flow::where('company_id',$company_id)->get();

                   

                //Loop through the flows and check if the message matches the flow
                foreach($flows as $flow){
                  Log::info("Flow: ".$flow->name);
                  $flow->processMessage($message); // va al Flow.php
                  Log::info("Flow processed");
                }
                 Log::info("STATUS MENSAJE: ", ['flow_has_replied' => $message->flow_has_replied]);
               // si no contesto el flow, flow_has_replied entonces busco si tiene mensaje
               // de bienvenida

           $message = \Modules\Wpbox\Models\Message::find($message->id);
  
           if(!$message->flow_has_replied){
             $welcomeMessage = $contact->botReplyWelcome($message->value, $message);
                Log::info("No flow has replied, checking for welcome message");
               
                Log::info("mensaje a buscar el Welcome", ['Message' => $welcomeMessage]);
            }
        }
    } 
            catch (\Throwable $th) {
              Log::error('Error in handleMessageByContact', ['error' => $th->getMessage()]);
                }
       
        


    }



    public function subscribe($events)
    {
        $events->listen(
            'Modules\Wpbox\Events\ContactReplies',
            [RespondOnMessage::class, 'handleMessageByContact']
        );
    }

}
