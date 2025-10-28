<?php

namespace Modules\Wpbox\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Wpbox\Models\Contact;

use Modules\Wpbox\Models\Message;
use Illuminate\Support\Facades\Storage;
use Modules\Wpbox\Models\Reply;
use Modules\Wpbox\Models\Template;
use Modules\Wpbox\Traits\Whatsapp;
use Illuminate\Support\Facades\Validator;
use Modules\Wpbox\Events\Chatlistchange;

use Modules\Contacts\Models\Field;
use Modules\Contacts\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder; // Asegúrate de tener este use arriba

class ChatController extends Controller
{
    use Whatsapp;

  
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {



        if($this->getCompany()->getConfig('whatsapp_webhook_verified','no')!='yes' || $this->getCompany()->getConfig('whatsapp_settings_done','no')!='yes'){
            return redirect(route('whatsapp.setup'));
         }

        $templates=Template::where('status','APPROVED')->select('name','id','language')->get();
      //  $replies = Reply::where('type', 1)->get();
        $replies = Reply::where('type', 1)->where('flow_id', null)->get();
        //Find the users of the company
        $users=$this->getCompany()->users()->pluck('name','id');
        // Get all groups with their contacts
        $grupos = Group::with('contacts')->get();


            // Cargar los contactos con sus relaciones y campos personalizados en una sola consulta
                $contactos_respondieron = Contact::has('messages')
                ->whereNotNull('last_reply_at') // Solo contactos con last_reply_at
                ->with([
                    'groups',
                    'country',
                    'fields' => function($query) {
                        $query->select('custom_contacts_fields.id', 'name')
                            ->withPivot('value');
                    },
                    'messages' => function($query) {
                        $query->orderBy('created_at', 'DESC')->limit(10);
                    }
                ])
                ->select('contacts.*')
                ->orderByDesc('last_reply_at') // Orden principal por last_reply_at
               // ->take(250) // Limitar a 10 contactos
                ->get();

            // Procesamiento de campos personalizados
            $fieldsTemplate = $this->getFields('col-md-4', true);

            $contactos_respondieron->transform(function ($contact) use ($fieldsTemplate) {
                $contact->custom_fields = collect($fieldsTemplate)->map(function ($field) use ($contact) {
                    $field['value'] = $contact->fields->firstWhere('id', $field['id'])->pivot->value ?? null;
                    return $field;
                })->toArray();
                return $contact;
            });

            return view('wpbox::chat.master', [
                'templates' => $templates->toArray(),
                'replies' => $replies->toArray(),
                'users' => $users->toArray(),
            //   'contactos' => $contactos->toArray(),
                'grupos' => $grupos->toArray(), // Pasar los grupos a la vista
            //   'contactosEloquent' => $contactos_todos ,
                'gruposEloquent' => $grupos,  // Pasar los grupos a la vista
               'contactos' => $contactos_respondieron->toArray(),
            //  'contactosTodos' => $contactos_todos->toArray()
            ]);
}




    /**
     * API
     */
 

public function chatlist($lastmessagetime)
{
    $shouldWeReturnChats = $lastmessagetime == "none";

    if(!$shouldWeReturnChats) {
        // Verificar si hay chats actualizados usando last_reply_at
        $lastUpdated = Contact::whereNotNull('last_reply_at')
            ->orderByDesc('last_reply_at')
            ->value('last_reply_at');
            
        if($lastUpdated == $lastmessagetime) {
            $shouldWeReturnChats = false;
        } else {
            $shouldWeReturnChats = true;
        }
    }

    if($shouldWeReturnChats) {
        $query = Contact::has('messages')
            ->whereNotNull('last_reply_at')
            ->with([
                'groups',
                'country',
                'fields' => function($query) {
                    $query->select('custom_contacts_fields.id', 'name')
                        ->withPivot('value');
                },
                'messages' => function($query) {
                    $query->orderBy('created_at', 'DESC')->limit(10);
                }
            ])
            ->select('contacts.*')
            ->orderByDesc('last_reply_at');

        // Filtro por agente si es necesario
        if(auth()->user()->hasRole('staff') && $this->getCompany()->getConfig('agent_assigned_only','false') != 'false') {
            $query->where('user_id', auth()->user()->id);
        }

        $chatList = $query->limit(200)->get();

        // Procesar campos personalizados igual que en index
        $fieldsTemplate = $this->getFields('col-md-4', true);
        $chatList->transform(function ($contact) use ($fieldsTemplate) {
            $contact->custom_fields = collect($fieldsTemplate)->map(function ($field) use ($contact) {
                $field['value'] = $contact->fields->firstWhere('id', $field['id'])->pivot->value ?? null;
                return $field;
            })->toArray();
            return $contact;
        });

        return response()->json([
            'data' => $chatList,
            'status' => true,
            'errMsg' => '',
            'last_reply_at' => $chatList->first()->last_reply_at ?? null
        ]);
    } else {
        return response()->json([
            'status' => false,
            'errMsg' => 'No changes',
        ]);
    }
}

    public function assignContact(Request $request, Contact $contact)
    {
        // Validate the request...
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Assign the contact to the user
        $contact->user_id = $validatedData['user_id'];
        $contact->save();

        event(new Chatlistchange($contact->id,$contact->company_id)); 

        return response()->json([
            'status' => true,
            'message' => 'Contact assigned successfully',
        ]);
    }

    public function chatmessages($contact){
        $messages=Message::where('contact_id',$contact)->where('status','>',0)->orderBy('id','desc')->limit(20)->get();
        return response()->json([
            'data' =>  $messages,
            'status' => true,
            'errMsg' => '',
        ]);
    }


 
public function sendMessageToContact(Request $request, \Modules\Wpbox\Models\Contact $contact)
{
    $validator = Validator::make($request->all(), [
        'message' => 'required|string|max:500'
    ]);

    if ($validator->fails()) {
        $errorsString = implode("\n", $validator->errors()->all());
        return response()->json([
            'status' => false,
            'errMsg' => $errorsString,
        ]);
    }
    
    if(strip_tags($request->message) != $request->message) {
        return response()->json([
            'status' => false,
            'errMsg' => __('Only text is allowed!'),
        ]);
    }

    $messageSend = $contact->sendMessage(strip_tags($request->message), false);
    
        return response()->json([
            'status' => true,
            'messagetime' => $messageSend->created_at->format('Y-m-d H:i:s'),
            'message' => [
                'id' => $messageSend->id,
                'value' => $messageSend->value ?? $messageSend->content,
                'created_at' => $messageSend->created_at->format('Y-m-d H:i:s'),
                'is_from_contact' => false, // Esto es crucial
                // Incluir campos adicionales que usa tu vista
                'is_last_message_by_contact' => 0
            ],
            'errMsg' => '',
        ]);
}




    public function sendImageMessageToContact(Request $request, Contact $contact){
        /**
         * Contact id
         * Message
         */
        $imageUrl="";
        if(config('settings.use_s3_as_storage',false)){
            //S3 - store per company
            $path = $request->image->storePublicly('uploads/media/send/'.$contact->company_id,'s3');
            $imageUrl = Storage::disk('s3')->url($path);
        }else{
            //Regular
            $path = $request->image->store(null,'public_media_upload',);
            $imageUrl = Storage::disk('public_media_upload')->url($path);
        }

        $fileType = $request->file('image')->getMimeType();
        if (str_contains($fileType, 'image')) {
            // It's an image
            $messageType = "IMAGE";
        } elseif (str_contains($fileType, 'video')) {
            // It's a video
            $messageType = "VIDEO";
        } elseif (str_contains($fileType, 'audio')) {
            // It's audio
            $messageType = "VIDEO";
        } else {
            // Handle other types or show an error message
            $messageType = "IMAGE";
        }
       
        $messageSend=$contact->sendMessage($imageUrl,false,false,$messageType);
        return response()->json([
            'message'=> $messageSend,
            'messagetime'=>$messageSend->created_at->format('Y-m-d H:i:s'),
            'status' => true,
            'errMsg' => '',
        ]);
    }

    public function sendDocumentMessageToContact(Request $request, Contact $contact){
        /**
         * Contact id
         * Message
         */
        $fileURL="";
        if(config('settings.use_s3_as_storage',false)){
            //S3 - store per company
            $path = $request->file->storePublicly('uploads/media/send/'.$contact->company_id,'s3',);
            $fileURL = Storage::disk('s3')->url($path);
        }else{
            //Regular
            $path = $request->file->store(null,'public_media_upload',);
            $fileURL = Storage::disk('public_media_upload')->url($path);
        }

        $messageSend=$contact->sendMessage($fileURL,false,false,"DOCUMENT");
        return response()->json([
            'message'=> $messageSend,
            'messagetime'=>$messageSend->created_at->format('Y-m-d H:i:s'),
            'status' => true,
            'errMsg' => '',
        ]);
    }


    private function getFields($class = 'col-md-4', $getCustom = true)
    {
        $fields = [];

       
        // Simple Bot reply (los bots)

            $customFieldStart = 0;
           if ($getCustom) {
            $customFields = Field::get()->toArray();
            $i = $customFieldStart;
            foreach ($customFields as $filedkey => $customField) {
                $i++;
                $fields[$i] = ['class' => $class, 'ftype' => 'input', 'type' => $customField['type'], 'name' => __($customField['name']), 'id' => $customField['id'], 'placeholder' => __($customField['name']), 'required' => false];
            }
        }

        return $fields;
    }



 


}
     


