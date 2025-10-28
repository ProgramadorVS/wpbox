<?php

namespace App\Traits;

use App\Models\Appointment;
use Carbon\Carbon;
use Modules\Wpbox\Models\Campaign;
use Modules\Wpbox\Models\Template;
use Modules\Contacts\Models\Contact;

trait AppointmentMessageTrait
{
// FUNCION QUE AGREGA EL MENSAJE EN LA TABLA DE MESSAGES TOMANDO LOS DATOS DE LA CAMPAÑA Y LA CITA
//TIPO 1 AGENDA 2 CONFIRMA 3 CANCELA
//$id es la cita
public function AgregarMensaje($id, $campaña_id,$tipo)
{
             $appointment = Appointment::find($id);


// PARA MANDAR MENSAJE DE CONFIRMACION

// Ahora 10:00, cita 14:00 → Recordatorio a las 12:00 (2 horas antes)
// Ahora 13:00, cita 14:30 → Recordatorio a las 13:30 (1 hora antes)
// Ahora 13:45, cita 14:00 → Recordatorio a las 13:50 (inmediato + 5 min)
// Cita mañana (sin importar la hora actual) → Recordatorio mañana 09:00
// Cita en 2+ días → Recordatorio 1 día antes a las 17:00

// es recordatorio se procede a calcular la hora de envio
        if ($tipo == 2) {
            $fechaCita = Carbon::parse($appointment->fecha);
            $ahora = now();
            
            // Comparar solo las fechas (sin horas)
            $fechaSoloCita = $fechaCita->copy()->startOfDay();
            $fechaSoloHoy = $ahora->copy()->startOfDay();
            $diasDiferencia = $fechaSoloHoy->diffInDays($fechaSoloCita, false);
            
            if ($diasDiferencia == 0) {
                // Cita es HOY → Recordatorio 1 o 2 horas antes
                $horasHastaCita = $ahora->diffInHours($fechaCita, false);
                
                if ($horasHastaCita >= 2) {
                    $scheduledAt = $fechaCita->copy()->subHours(2);
                } elseif ($horasHastaCita >= 1) {
                    $scheduledAt = $fechaCita->copy()->subHour();
                } else {
                    $scheduledAt = $ahora->copy()->addMinutes(15);
                }
                
            } elseif ($diasDiferencia == 1) {
                // Cita es mañana → Recordatorio mañana a las 09:00
                $scheduledAt = $fechaCita->copy()->setTime(9, 0, 0);
                
            } elseif ($diasDiferencia >= 2) {
                // Cita es en 2 o más días → Recordatorio 1 día antes a las 17:00
                $scheduledAt = $fechaCita->copy()->subDay()->setTime(15, 0, 0);
                
            } else {
                // Cita en el pasado → No enviar recordatorio
                $scheduledAt = null;
            }
        } 
        else {
                    // si es mandar mensaje de cita normal se le pone automatico a la hora actual para que al ejecutar el proceso se mande
                    $scheduledAt = now();
        }
        // fin de es recordatorio

            // INICIO DEL PROCEDIMIENTO PARA MANDAR WHATS
            $campaign = Campaign::findOrFail($campaña_id);
 
            $template = Template::find($campaign->template_id);
            if ($template && $template->components) {
                $template->components = $this->normalizeComponentVariablesString($template->components);
            }


            $variablesValues = json_decode($campaign->variables, true);
            $variables_match = json_decode($campaign->variables_match, true);

        // 2) Toma el contacto de la cita
            $contact =Contact::findOrFail($appointment->contact_id);
            $messages = [];

        // 3) Inserta en la tabla de messages uno por uno, solo si no existe ya ese mensaje
            


                $content = "";
                $header_text = "";
                $header_image = "";
                $header_document = "";
                $header_video = "";
                $header_audio = "";
                $footer = "";
                $buttons = [];
                $APIComponents = [];



           //  $this->dispatch('notify', type: 'success', message: 'llega' . $id);
           //   return;

                $components = json_decode($template->components, true);
                foreach ($components as $component) {
                    $lowKey = strtolower($component['type']);

                    $lowKey = strtolower($component['type']);

                    if ($component['type'] == "HEADER" && $component['format'] == "TEXT") {
                        $header_text = $component['text'];
                        $component['parameters'] = [];
                        if (isset($variables_match[$lowKey])) {
                          //  $this->setParameter($variables_match[$lowKey], $variablesValues[$lowKey], $component, $header_text, $contact);
                            $this->setParameter($variables_match[$lowKey], $variablesValues[$lowKey], $component, $header_text, $contact, "text", $appointment);
                           
                            unset($component['text'], $component['format'], $component['example']);
                            array_push($APIComponents, $component);
                        }
                    } else if ($component['type'] == "BODY") {
                        $content = $component['text'];
                        $component['parameters'] = [];
                        if (isset($variables_match[$lowKey])) {
                          //  $this->setParameter($variables_match[$lowKey], $variablesValues[$lowKey], $component, $content, $contact);
                            $this->setParameter($variables_match[$lowKey], $variablesValues[$lowKey], $component, $content, $contact, "text", $appointment);
                            
                            unset($component['text'], $component['format'], $component['example']);
                            array_push($APIComponents, $component);
                        }
                    } else if ($component['type'] == "HEADER" && $component['format'] == "DOCUMENT") {
                        $component['parameters'] = [[
                            "type" => "document",
                            "document" => ['link' => $campaign->media_link]
                        ]];
                        $header_document = $campaign->media_link;
                        unset($component['format'], $component['example']);
                        array_push($APIComponents, $component);
                    } else if ($component['type'] == "HEADER" && $component['format'] == "IMAGE") {
                        $component['parameters'] = [[
                            "type" => "image",
                            "image" => ['link' => $campaign->media_link]
                        ]];
                        $header_image = $campaign->media_link;
                        unset($component['format'], $component['example']);
                        array_push($APIComponents, $component);
                    } else if ($component['type'] == "HEADER" && $component['format'] == "VIDEO") {
                        $component['parameters'] = [[
                            "type" => "video",
                            "video" => ['link' => $campaign->media_link]
                        ]];
                        $header_video = $campaign->media_link;
                        unset($component['format'], $component['example']);
                        array_push($APIComponents, $component);
                    } else if ($component['type'] == "HEADER" && $component['format'] == "AUDIO") {
                        $component['parameters'] = [[
                            "type" => "audio",
                            "audio" => ['link' => $campaign->media_link]
                        ]];
                        $header_audio = $campaign->media_link;
                        unset($component['format'], $component['example']);
                        array_push($APIComponents, $component);
                    } else if ($component['type'] == "FOOTER") {
                        $footer = $component['text'];
                    } else if ($component['type'] == "BUTTONS") {
                        $keyButton = 0;
                        foreach ($component['buttons'] as $keyButtonFromLoop => $valueButton) {
                            if (isset($variables_match[$lowKey][$keyButton]) && (($valueButton['type'] == "URL" && stripos($valueButton['url'], "{{") !== false) || ($valueButton['type'] == "COPY_CODE"))) {
                                $buttonName = "";
                                $button = [
                                    "type" => "button",
                                    "sub_type" => strtolower($valueButton['type']),
                                    "index" => $keyButtonFromLoop . "",
                                    "parameters" => []
                                ];
                                $paramType = $valueButton['type'] == "COPY_CODE" ? "coupon_code" : "text";
                               // $this->setParameter($variables_match[$lowKey][$keyButton], $variablesValues[$lowKey][$keyButton], $button, $buttonName, $contact, $paramType);
                                $this->setParameter($variables_match[$lowKey][$keyButton], $variablesValues[$lowKey][$keyButton], $button, $buttonName, $contact, $paramType, $appointment);
                                array_push($APIComponents, $button);
                                array_push($buttons, $valueButton);
                                $keyButton++;
                            } else {
                                array_push($buttons, $valueButton);
                            }
                        }
                    }
                }

                $components = $APIComponents;

                // Inicializar todas las variables en 0
                $es_cita_agenda = 0;
                $es_cita_confirma = 0;
                $es_cita_cancela = 0;
                $es_cita_ok = 0;

                switch($tipo) {
                    case 1:
                        $es_cita_agenda = 1;
                         $scheduledAt = now(); // Para cancelación, enviar inmediatamente
                        break;
                    case 2:// es confirmacion 
                        $es_cita_confirma = 1;
                        break;
                    case 3:
                        $es_cita_cancela = 1;
                        $scheduledAt = now(); // Para cancelación, enviar inmediatamente
                        break;
                    case 4:
                        $es_cita_ok = 1;
                        $scheduledAt = now(); // Para confirmar al whats desde la pagina cuando le da confirmar, enviar inmediatamente
                        break;    
                }

                $messages[] = [
                    "contact_id" => $contact->id,
                    "company_id" => $contact->company_id,
                    "value" => $content,
                    "header_image" => $header_image,
                    "header_video" => $header_video,
                    "header_audio" => $header_audio,
                    "header_document" => $header_document,
                    "footer_text" => $footer,
                    "buttons" => json_encode($buttons),
                    "header_text" => $header_text,
                    "is_message_by_contact" => false,
                    "is_campign_messages" => true,
                    "status" => 0,
                    "created_at" => now(),
                    "scchuduled_at" => $scheduledAt,
                    "components" => json_encode($components),
                    "campaign_id" => $campaign->id,
                    "cita_id" => $appointment->id,
                    "es_cita_agenda" => $es_cita_agenda,
                    "es_cita_confirma" => $es_cita_confirma,
                    "es_cita_cancela" => $es_cita_cancela,
                    "es_cita_ok" => $es_cita_ok,
                ];
     

            if (!empty($messages)) {


            // aqui MANDAMOS EL MENSAJE SI ES DE CITA

                 

                \Modules\Wpbox\Models\Message::insert($messages);

                 $totalEnviados = \Modules\Wpbox\Models\Message::where('campaign_id', $campaign->id)
                ->where('is_campign_messages', true)
                ->count();
                $campaign->send_to = $totalEnviados;
                $campaign->save(); // AQUI LO GUARDA EN LA TABLA DE CAMPAÑAS CON STATUS 0 LISTO PARA MANDARSE CUANDO SE EJECUTE EL PROCESO 
    

                // SI ES EL AVISO DE AGENDA 
               

                switch($tipo) {
                    case 1:
                          // Llama al método del controlador usando el facade de app()
                         $result = app(\Modules\Wpbox\Http\Controllers\CampaignsController::class)->sendSchuduledMessagesCita($id);
                        break;
                     
                    case 3:
                         // Llama al método del controlador usando el facade de app()
                     $result = app(\Modules\Wpbox\Http\Controllers\CampaignsController::class)->sendSchuduledMessagesCitaCancelada($id);
                        break;

                    case 4:
                         // Llama al método del controlador usando el facade de app()
                     $result = app(\Modules\Wpbox\Http\Controllers\CampaignsController::class)->sendSchuduledMessagesCitaOk($id);
                        break;
                }

                    

            }

           


}


// para que sirve la funcion de arriba  continuarCampañaAgrega
private function normalizeComponentVariablesString($componentsJson)
{
    $components = json_decode($componentsJson, true);
    foreach ($components as &$component) {
        if (isset($component['text'])) {
            // Si ya tiene variables numéricas, no hacer nada
            if (preg_match('/{{\s*\d+\s*}}/', $component['text'])) {
                continue;
            }
            // Reemplaza variables con nombre por numéricas
            preg_match_all('/{{\s*([\w]+)\s*}}/', $component['text'], $matches);
            if (!empty($matches[1])) {
                $replaceMap = [];
                foreach ($matches[1] as $idx => $name) {
                    $replaceMap['{{'.$name.'}}'] = '{{'.($idx+1).'}}';
                }
                $component['text'] = str_replace(array_keys($replaceMap), array_values($replaceMap), $component['text']);
            }
        }
    }
    return json_encode($components, JSON_UNESCAPED_UNICODE);
}



// para que sirve la funcion de arriba  continuarCampañaAgrega

private function setParameter($variables, $values, &$component, &$content, $contact, $type = "text", $appointment = null) {
    foreach ($variables as $keyVM => $vm) { 
        $data = ["type" => $type];
        
        if($vm == "-2") {
            // Use static value
            $data[$type] = $values[$keyVM];
            array_push($component['parameters'], $data);
            $content = str_replace("{{" . $keyVM . "}}", $values[$keyVM], $content);
            
        } else if($vm == "-3") {
            // Contact extra value in runtime
            try {
                $extraValueNeeded = $values[$keyVM];
                $extraValues = $contact->extra_value;
                $valueNeeded = null;
                if (isset($extraValues)) {
                    $keys = explode('.', $extraValueNeeded);
                    $valueNeeded = $extraValues;
                    
                    foreach ($keys as $key) {
                        if (isset($valueNeeded[$key])) {
                            $valueNeeded = $valueNeeded[$key];
                        } else {
                            $valueNeeded = $values[$keyVM];
                            break;
                        }
                    }
                }
             
                $data[$type] = $valueNeeded;
                array_push($component['parameters'], $data);
                $content = str_replace("{{" . $keyVM . "}}", $valueNeeded, $content);
                
            } catch (\Throwable $th) {
                $data[$type] = $values[$keyVM];
                array_push($component['parameters'], $data);
                $content = str_replace("{{" . $keyVM . "}}", $values[$keyVM] . "---", $content);
            }
           
        } else if($vm == "-4") {
            // Fecha de Cita
         
                // Configurar Carbon para español
                \Carbon\Carbon::setLocale('es');

                $fechaCita = $appointment ? 
                    \Carbon\Carbon::parse($appointment->fecha)
                        ->translatedFormat('l j \d\e F \d\e\l Y') : '';

                $data[$type] = $fechaCita;
                array_push($component['parameters'], $data);
                $content = str_replace("{{" . $keyVM . "}}", $fechaCita, $content);
            
        } else if($vm == "-5") {
            // Hora de Cita  
            $horaCita = $appointment ? $appointment->hora : '';
            // Si quieres formatear la hora, puedes usar Carbon:
            // $horaCita = $appointment ? \Carbon\Carbon::parse($appointment->time)->format('H:i') : '';
            
            $data[$type] = $horaCita;
            array_push($component['parameters'], $data);
            $content = str_replace("{{" . $keyVM . "}}", $horaCita, $content);
            
        } else if($vm == "-6") {
            // Nombre del doctor o responsable
            $doctorName = $appointment?->doctor?->name ?? '';
            $data[$type] = $doctorName;

           
            array_push($component['parameters'], $data);
            $content = str_replace("{{" . $keyVM . "}}", $doctorName, $content);



        } else if($vm == "-7") {
            // codigo de cita

             $citaCodigo = $appointment ? $appointment->citacodigo : '';

            $data[$type] = $citaCodigo;
            array_push($component['parameters'], $data);
            $content = str_replace("{{" . $keyVM . "}}", $citaCodigo, $content);

        }  
        
        
        
        else if($vm == "-1") {
            // Expediente
            $data[$type] = $contact->expediente;
            array_push($component['parameters'], $data);
            $content = str_replace("{{" . $keyVM . "}}", $contact->expediente, $content);
            
        } else if($vm == "0") {
            // Contact name
            $data[$type] = $contact->name;
            array_push($component['parameters'], $data);
            $content = str_replace("{{" . $keyVM . "}}", $contact->name, $content);
            
        } else if($vm == "1") {
            // Contact phone
            $data[$type] = $contact->phone;
            array_push($component['parameters'], $data);
            $content = str_replace("{{" . $keyVM . "}}", $contact->phone, $content);
            
        } else {
            // Use defined contact field
            if($contact->fields->where('id', $vm)->first()) {
                $val = $contact->fields->where('id', $vm)->first()->pivot->value;
                $data[$type] = $val;
                array_push($component['parameters'], $data);
                $content = str_replace("{{" . $keyVM . "}}", $val, $content);
            } else {
                $data[$type] = "";
                array_push($component['parameters'], $data);
                $content = str_replace("{{" . $keyVM . "}}", "", $content);
            }
        }
    }
}




}