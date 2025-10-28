<?php

namespace Modules\Wpbox\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\CompanyScope;
use Illuminate\Support\Facades\Log;

class Reply extends Model
{
   // use SoftDeletes;
    
    protected $table = 'replies';
    public $guarded = [];


public function shouldWeUseIt($receivedMessage, Contact $contact)
{
    // Check if enabled_bot is false and return false if so
    if (!$contact->enabled_bot) {
        return false;
    }

    $receivedMessage = " " . strtolower($receivedMessage);
    $shouldWeUseIt = false;

    //Check if this type is a welcome bot, and if this is contact first message
 

    // si es mensaje de bienvenida y es el primer mensaje del contacto del dia

            $today = now()->toDateString();
            $messagesToday = $contact->messages()
                ->whereDate('created_at', $today)
                ->where('is_message_by_contact', 1)
                ->get();
            $existsToday = $messagesToday->count() > 1;

       //     Log::info('Depuración shouldWeUseIt', [
       //         'type' => $this->type ,
       //         'today' => $today,
       //         'messagesTodayCount' => $messagesToday->count(),
       //         'existsToday' => $existsToday,
       //         'contact_id' => $contact->id,
       //     ]); 

//1 quick
//2 exact match
// 3 contains   
// 4 es que contesta exact
// 5 es bienvenida

    if ( $this->type == 5 && !$existsToday) {
  //  Log::info('Entra a Bienvenida', ['INFO' => "Entra"]);
    $shouldWeUseIt = true;
}

   else {
       //  Log::info('NO Entra a Bienvenida', ['INFO' => "NO entra"]);  
        //Check based on the trigger
        // Store the value of $this->trigger in a new variable
        $triggerValues = $this->trigger;

        // Convert $triggerValues into an array if it contains commas
        if (strpos($triggerValues, ',') !== false) {
            $triggerValues = explode(',', $triggerValues);
        }

        //Check if we can use this reply
        if (is_array($triggerValues)) {
            foreach ($triggerValues as $trigger) {
                if ($this->type == 2) {

					$trigger = " " . strtolower($trigger); //Brij Mohan Negi Update																   
                    // Exact match
                   if ($receivedMessage == $trigger) {
                        $shouldWeUseIt = true;
                        break; // exit the loop once a match is found
                    }
                } else if ($this->type == 3) {
                    // Contains
                    if (stripos($receivedMessage, $trigger) !== false) {
                        $shouldWeUseIt = true;
                        break; // exit the loop once a match is found
                    }
                } else if ($this->type == 4) {
                    // Type 4: Exact match + guarda respuesta
                    if ($receivedMessage == $trigger) {
                        $shouldWeUseIt = true;
                        // Guarda la respuesta en el último mensaje de campaña enviado a este contacto y le pongo 6 de contestado
                        $mensajeCampania = \Modules\Wpbox\Models\Message::where('contact_id', $contact->id)
                            ->where('is_campign_messages', 1)
                            ->where('is_message_by_contact', 0)
                            ->orderByDesc('id')
                            ->first();
                        if ($mensajeCampania) {
                            $mensajeCampania->respuesta = trim($receivedMessage);
                            $mensajeCampania->status = 6; // contestado
                            $mensajeCampania->save();
                        }
                        break; // exit the loop once a match is found
                    }
                }
            }
        } else {
            //Doesn't contain commas
				 $triggerValues = " " . strtolower($triggerValues); //Brij Mohan Ne																		   
            if ($this->type == 2) {
                // Exact match
                  if ($receivedMessage == $triggerValues) {
                    $shouldWeUseIt = true;
                }
            } else if ($this->type == 3) {
                // Contains
                if (stripos($receivedMessage, $triggerValues) !== false) {
                    $shouldWeUseIt = true;
                }
            } else if ($this->type == 4) {
                // Type 4: Exact Match + guarda respuesta
                if ($receivedMessage == $triggerValues) {
                    $shouldWeUseIt = true;
                    $mensajeCampania = \Modules\Wpbox\Models\Message::where('contact_id', $contact->id)
                        ->where('is_campign_messages', 1)
                        ->where('is_message_by_contact', 0)
                        ->orderByDesc('id')
                        ->first();
                           // Guarda la respuesta en el último mensaje de campaña enviado a este contacto y le pongo 6 de contestado
                    if ($mensajeCampania) {
                        $mensajeCampania->respuesta = trim($receivedMessage);
                         $mensajeCampania->status = 6; // contestado
                        $mensajeCampania->save();
                    }
                }
            }
        }
    }

    //Change message // SI ENCONTRO UN BOT
    if ($shouldWeUseIt == true) {
        $this->increment('used', 1);
        $this->update();

        //Change the values in the  $this->text
        $pattern = '/{{\s*([^}]+)\s*}}/';
        preg_match_all($pattern, $this->text, $matches);
        $variables = $matches[1];
        foreach ($variables as $key => $variable) {
            if ($variable == "name") {
                $this->text = str_replace("{{" . $variable . "}}", $contact->name, $this->text);
            } else if ($variable == "phone") {
                $this->text = str_replace("{{" . $variable . "}}", $contact->phone, $this->text);
            } else {
                //Field
                $val = $contact->fields->where('name', $variable)->first()->pivot->value;
                $this->text = str_replace("{{" . $variable . "}}", $val, $this->text);
            }
        }

        //Change the values in the  $this->header
        $pattern = '/{{\s*([^}]+)\s*}}/';
        preg_match_all($pattern, $this->header, $matches);
        $variables = $matches[1];
        foreach ($variables as $key => $variable) {
            if ($variable == "name") {
                $this->header = str_replace("{{" . $variable . "}}", $contact->name, $this->header);
            } else if ($variable == "phone") {
                $this->header = str_replace("{{" . $variable . "}}", $contact->phone, $this->header);
            } else {
                //Field
                $val = $contact->fields->where('name', $variable)->first()->pivot->value;
                $this->header = str_replace("{{" . $variable . "}}", $val, $this->header);
            }
        }
											  
							 

        $contact->sendReply($this);

        
             try {
               //Check if this reply has a next reply
                if($this->next_reply_id){
                  //  Log::info("next_reply_id: ".$this->next_reply_id);
                    $nextReply = Reply::find($this->next_reply_id);
                    $nextReply->sendTheReply($receivedMessage,$contact);
                }
            } catch (\Throwable $th) {
                //throw $th;
               // Log::info($th);
            }

        return true;
				 
					
    } else {
        // AQUI SE METE SI NO RESPONDE EL BOT
        return false;
    }
}

																								 
public function sendTheReply($receivedMessage,Contact $contact){
     //   Log::info("Let's send the reply");
        $this->increment('used', 1);
            $this->update();

            //Change the values in the  $this->text
            $pattern = '/{{\s*([^}]+)\s*}}/';
            preg_match_all($pattern, $this->text, $matches);
            $variables = $matches[1];
            foreach ($variables as $key => $variable) {
                if($variable=="name"){
                    $this->text=str_replace("{{".$variable."}}",$contact->name,$this->text);
                }else if($variable=="phone"){
                    $this->text=str_replace("{{".$variable."}}",$contact->phone,$this->text);
                }else{
                    //Field
                    $val=$contact->fields->where('name',$variable)->first()->pivot->value;
                    $this->text=str_replace("{{".$variable."}}",$val,$this->text);
                }
            }

            //Change the values in the  $this->header
            $pattern = '/{{\s*([^}]+)\s*}}/';
            preg_match_all($pattern, $this->header, $matches);
            $variables = $matches[1];
            foreach ($variables as $key => $variable) {
                if($variable=="name"){
                    $this->header=str_replace("{{".$variable."}}",$contact->name,$this->header);
                }else if($variable=="phone"){
                    $this->header=str_replace("{{".$variable."}}",$contact->phone,$this->header);
                }else{
                    //Field
                    $val=$contact->fields->where('name',$variable)->first()->pivot->value;
                    $this->header=str_replace("{{".$variable."}}",$val,$this->header);
                }
            }
          //  Log::info("Let's check if this reply has a next reply  before sending it");
            
            $contact->sendReply($this);

         //   Log::info("Let's check if this reply has a next reply");
            try {
               //Check if this reply has a next reply
                if($this->next_reply_id){
                  //  Log::info("next_reply_id: ".$this->next_reply_id);
                    $nextReply = Reply::find($this->next_reply_id);
                    $nextReply->sendTheReply($receivedMessage,$contact);
                }
            } catch (\Throwable $th) {
                //throw $th;
              //  Log::info($th);
            }

										   
            return true;
 
    }					  
						   
																						  

    // funcion para mandar template de aviso de mensaje cuando no encontro el Flow
    public function MensajeAviso($receivedMessage,Contact $contact){
													 

        $contact->sendReplyAviso($contact);
        return true;  
 
}





    protected static function booted(){
        static::addGlobalScope(new CompanyScope);

        static::creating(function ($model){
           $company_id=session('company_id',null);
            if($company_id){
                $model->company_id=$company_id;
            }
        });
    }
}
