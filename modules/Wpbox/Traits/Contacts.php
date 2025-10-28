<?php

namespace Modules\Wpbox\Traits;


use Modules\Wpbox\Models\Contact;
trait Contacts {
    
public function getOrMakeContact($phone, $company, $name)
{
    try {
        //Find the contact
        $contact = Contact::where('company_id', $company->id)
                          ->where(function ($query) use ($phone) {
                              $query->where('phone', $phone)
                                    ->orWhere('phone', "+" . $phone);
                          })->first();

        if(!$contact){
            //Create new contact
            $contact = Contact::create([
                'name' => $name,
                'phone' => $phone,
                'avatar' => '',
                'company_id' => $company->id,
                'has_chat' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'last_support_reply_at' => null,
                'last_reply_at' => now(),
                "last_message" => "",
                "is_last_message_by_contact" => true,    
            ]);
        }

        return $contact;
        
    } catch (\Illuminate\Database\QueryException $e) {
        // Si hay error de llave única (código 23000)
        if ($e->getCode() == 23000) {
            try {
                // Intenta crear el contacto con timestamp agregado al nombre
                $contact = Contact::create([
                    'name' => $name . '_' . now()->format('YmdHis'),
                    'phone' => $phone,
                    'avatar' => '',
                    'company_id' => $company->id,
                    'has_chat' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'last_support_reply_at' => null,
                    'last_reply_at' => now(),
                    "last_message" => "",
                    "is_last_message_by_contact" => true,    
                ]);
                
                return $contact;
                
            } catch (\Exception $e2) {
                // Si aún así falla, lanza excepción
                throw new \Exception("No se pudo crear el contacto: " . $e2->getMessage());
            }
        }
        
        // Para otros errores de base de datos
        throw new \Exception("Error al buscar o crear contacto: " . $e->getMessage());
        
    } catch (\Exception $e) {
        // Captura cualquier otro error
        throw new \Exception("Error inesperado al procesar contacto: " . $e->getMessage());
    }
}

   
}

?>
