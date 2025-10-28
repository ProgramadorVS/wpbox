<?php

namespace Modules\Contacts\Imports;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Modules\Contacts\Models\Contact;
use Modules\Contacts\Models\Field;
use Modules\Contacts\Models\Group;
use App\Models\User;
use Illuminate\Support\Str;

class ContactsImport implements ToModel, WithHeadingRow, WithChunkReading
{
    /**
     * @param array $row
     *
     * @return User|null
     */
public function model(array $row)
{
    ini_set('max_execution_time', 300); // 5 minutos
    $keys = array_keys($row);
    $keysForFields = [];
    foreach ($keys as $key => $value) {
        $keysForFields[$key] = $this->getOrMakeField($value);
    }
    $telefonoFormateado = $this->formatPhone($row['telefono']);


        // Buscar el user_id por el nombre del agente
    $userId = null;
    if (isset($row['agente']) && !empty($row['agente'])) {
        $user = User::where('name', $row['agente'])->first();
        if ($user) {
            $userId = $user->id;
        }
    }

    // Prepara los datos para actualizar/crear ( AGENTE )
    $contactData = [
        'name'    => $row['nombre'],
        'user_id' => $userId,
    ];

    // Solo agrega 'observaciones' si viene en el Excel
    if (array_key_exists('observaciones', $row)) {
        $contactData['observaciones'] = $row['observaciones'];
    }

   // Solo agrega 'email' si viene en el Excel
    if (array_key_exists('email', $row)) {
        $contactData['email'] = $row['email'];
    }

   // Solo agrega 'expediente' si viene en el Excel y lo toma como ID
    if (array_key_exists('expediente', $row)) {
        $contactData['expediente'] = $row['expediente'];
       
        $prevContact = Contact::where('expediente', $row['expediente'])->first();
    }else {
        // Si no hay expediente, buscar por teléfono formateado
        // Esto es para mantener la compatibilidad con los contactos que no tienen expediente
        $prevContact = Contact::where('phone', $telefonoFormateado)->first();
    }

     $contactData['phone'] = $telefonoFormateado;

    // Si el contacto ya existe, actualizarlo
    if ($prevContact) {
        $prevContact->update($contactData);
    } else {
        
        $prevContact = Contact::create($contactData);
    }

    if (isset($row['grupo'])) {
        // Buscar o crear el grupo basado en el nombre del grupo
        $groupName = $row['grupo'];
        $group = Group::firstOrCreate(['name' => $groupName]);
        // Adjuntar el grupo solo si no está ya asociado
        if (!$prevContact->groups->contains($group->id)) {
            $prevContact->groups()->attach($group->id);
        }
    }

    if (isset($row['avatar'])) {
        $prevContact->avatar = $row['avatar'];
    }

    // LOS FIELDS EXTRAS 
    foreach ($keysForFields as $key => $fieldID) {
        if ($fieldID != 0 && !empty($row[$keys[$key]])) {
            // Verificar si la combinación de contact_id y custom_contacts_field_id ya existe
            $existingField = $prevContact->fields()->wherePivot('custom_contacts_field_id', $fieldID)->first();

            if ($existingField) {
                // Si ya existe, actualizar el valor
                $prevContact->fields()->updateExistingPivot($fieldID, ['value' => $row[$keys[$key]]]);
            } else {
                // Si no existe, adjuntar el nuevo valor
                $prevContact->fields()->attach($fieldID, ['value' => $row[$keys[$key]]]);
            }
        }
    }
    $prevContact->update();

    return $prevContact;
}


private function formatPhone($telefono)
{
    // Forzar a string
    $telefono = (string) $telefono;

    // Si viene en notación científica (como 5.21229E+12), lo convertimos
    if (stripos($telefono, 'e') !== false) {
        $telefono = number_format((float)$telefono, 0, '', '');
    }

    // Eliminar espacios, guiones, paréntesis, etc.
    $telefono = preg_replace('/[^0-9]/', '', $telefono);

    // Si ya tiene 13 dígitos y empieza con 521, lo dejamos igual
    if (strlen($telefono) === 13 && substr($telefono, 0, 3) === '521') {
        return $telefono;
    }

    // Si tiene solo 10 dígitos, le agregamos 521
    if (strlen($telefono) === 10) {
        return '521' . $telefono;
    }

    // Si no cumple, regresamos como está (opcional: lanzar error)
    return $telefono;
}


//VERIFICA SI EL CAMPO YA EXISTE, SINO LO CREA EN LA TABLA DE FIELDS
    private function getOrMakeField($field_name){
    
            if(
                $field_name == "expediente" ||
                $field_name == "nombre" ||
                $field_name == "telefono" ||
                $field_name == "avatar" ||
                $field_name == "grupo" ||
                $field_name == "agente" || // <-- agrega esta línea
                $field_name == "observaciones" || // <-- agrega esta línea
                $field_name == "email" // <-- agrega esta línea
            ){
                return 0;
            }
                    $field=Field::where('name',$field_name)->first();
                    if(!$field){
                        $field=Field::create([
                            'name'     => $field_name,
                            'type'=>"text",
                        ]);
                        $field->save();
                    }
                    return $field->id;
    }

  public function chunkSize(): int
    {
        return 100;
    }

}