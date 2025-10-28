<?php

namespace Modules\Flowmaker\Models\Nodes;
use Illuminate\Support\Facades\Log;
use Modules\Flowmaker\Models\Contact;

class Media extends Node
{
   

    public function process($message, $data)
    {
        Log::info('Processing message in media node', ['message' => $message, 'data' => $data]);
        Log::info('Data', ['data' => $data]);
        // Get message from node data
        try{
            $message= $this->getDataAsArray()['settings']['caption'];
            $node= $this->getDataAsArray();
            Log::info('Message', ['message' => $message]);
            Log::info('Node', ['node' => $node]);

            $type= $node['type'];
            //Get the media URL, based on the type of the node
            if($type === 'image'){
                $mediaUrl = $node['settings']['imageUrl'];
            }else if($type === 'video'){
                $mediaUrl = $node['settings']['videoUrl'];
            }else if($type === 'pdf'){
                $mediaUrl = $node['settings']['pdfUrl'];
            }


           

            //Find the contact
            $contact = Contact::find($data->contact_id);
            Log::info('Contact', ['contact' => $contact]);

            //Send the media
            //  $messageType [TEXT | IMAGE | VIDEO | DOCUMENT 
            if($type === 'image'){
                $messageType = "IMAGE";
            }else if($type === 'video'){
                $messageType = "VIDEO";
            }else if($type === 'pdf'){
                $messageType = "DOCUMENT";
            }

               $messageData = $data ?? null;
                        $messageId = $messageData['id'] ?? null;
                        Log::info('MEDIA:MENSAJE A EDITAR PARA EL FLOW_HAS_REPLIED', ['keyword' => $messageData]);
                        if ($messageId) {
                            \Modules\Wpbox\Models\Message::where('id', $messageId)->update(['flow_has_replied' => 1]);
                        }

            $contact->sendMessage($mediaUrl,false,false,$messageType);

            //Send the message
            $contact->sendMessage($contact->changeVariables($message),false);


        }catch(\Exception $e){
            Log::error('Error getting message from node data', ['error' => $e->getMessage()]);
        }
    

        // Continue flow to next node if one exists
        $nextNode = $this->getNextNodeId();
        if ($nextNode) {
            $nextNode->process($message, $data);
        }

        return [
            'success' => true
        ];
    }

    protected function getNextNodeId( $data =null)
    {
        // Get the first outgoing edge's target
        if (!empty($this->outgoingEdges)) {
            return $this->outgoingEdges[0]->getTarget();
        }
        return null;
    }
}
