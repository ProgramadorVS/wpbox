<?php

namespace Modules\Wpbox\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Wpbox\Models\Template;
use Modules\Wpbox\Traits\Whatsapp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TemplatesController extends Controller
{

    use Whatsapp;
    /**
     * Provide class.
     */
    private $provider = Template::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'templates.';

    /**
     * View path.
     */
    private $view_path = 'wpbox::templates.';

    /**
     * Parameter name.
     */
    private $parameter_name = 'templates';

    /**
     * Title of this crud.
     */
    private $title = 'plantilla';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'plantillas';


    public function index()
    {
        $this->authChecker();

        if($this->getCompany()->getConfig('whatsapp_webhook_verified','no')!='yes' || $this->getCompany()->getConfig('whatsapp_settings_done','no')!='yes'){
            return redirect(route('whatsapp.setup'));
        }


        $items=$this->provider::orderBy('name', 'asc');
        if(isset($_GET['name'])&&strlen($_GET['name'])>1){
            $items=$items->where('name',  'like', '%'.$_GET['name'].'%');
        }else{
            //If there are 0 template,and there is no filter, load them
            try {
                 
                $this->loadTemplatesFromWhatsApp();
               Log::info('Carga de Plantillas desde Whatsapp API', [
                    'status' => 'success',
                    'message' => 'Plantillas cargados éxitosamente desde WhatsApp API'
                ]);
            } catch (\Throwable $th) {
                //throw $th;
                Log::error('Error cargando Plantillas desde WhatsApp API', [
                    'status' => $th->getCode(),
                    'message' => $th->getMessage()
                ]);
            }
        }
        $items=$items->paginate(config('settings.paginate'));

        //If there is a refresh request
        if(isset($_GET['refresh'])&&$_GET['refresh']=='yes'){
            $this->loadTemplatesFromWhatsApp();
        }
        

        $setup = [
            'title'          => __('crud.item_managment', ['item' => __($this->titlePlural)]),
            'action_link'    => route($this->webroute_path.'load'),
            'action_name'    => __('Sincronizar Plantillas'),
            'action_link5'   => "https://business.facebook.com/wa/manage/message-templates/",
            'action_name5'   => __('WhatsApp Manager'),
            'action_link3'   => route($this->webroute_path.'create'),
            'action_name3'   => "+ ".__('Crear Plantilla'),
            'items'          => $items,
            'item_names'     => $this->titlePlural,
            'webroute_path'  => $this->webroute_path,
            'fields'         => [],
            'custom_table'   => true,
            'parameter_name' => $this->parameter_name,
            'parameters'     => count($_GET) != 0
        ];

        // Loguea el contenido en formato JSON
        Log::info('Setup enviado a la vista de Plantillas', ['setup' => json_encode($setup)]);

        return view($this->view_path.'index', ['setup' => $setup]);
    }

    /**
     * Auth checker functin for the crud.
     */
    private function authChecker()
    {
        $this->ownerAndClientOnly();
    }

    public function loadTemplates(){
        
        if($this->loadTemplatesFromWhatsApp()){
            return redirect()->route($this->webroute_path.'index')->withStatus(__('crud.item_has_been_updated', ['item'=>__($this->titlePlural)]));
            // Process $responseData as needed
        } else {
            // Handle error response
            return redirect()->route($this->webroute_path.'index')->withStatus(__('crud.error', ['error'=>'Error']));
        }
    }

    public function create(){
        $this->authChecker();

      //  $languages="Afrikaans,af,Albanian,sq,Arabic,ar,Azerbaijani,az,Bengali,bn,Bulgarian,bg,Catalan,ca,Chinese (CHN),zh_CN,Chinese (HKG),zh_HK,Chinese (TAI),zh_TW,Croatian,hr,Czech,cs,Danish,da,Dutch,nl,English,en,English (UK),en_GB,English (US),en_US,Estonian,et,Filipino,fil,Finnish,fi,French,fr,Georgian,ka,German,de,Greek,el,Gujarati,gu,Hausa,ha,Hebrew,he,Hindi,hi,Hungarian,hu,Indonesian,id,Irish,ga,Italian,it,Japanese,ja,Kannada,kn,Kazakh,kk,Kinyarwanda,rw_RW,Korean,ko,Kyrgyz (Kyrgyzstan),ky_KG,Lao,lo,Latvian,lv,Lithuanian,lt,Macedonian,mk,Malay,ms,Malayalam,ml,Marathi,mr,Norwegian,nb,Persian,fa,Polish,pl,Portuguese (BR),pt_BR,Portuguese (POR),pt_PT,Punjabi,pa,Romanian,ro,Russian,ru,Serbian,sr,Slovak,sk,Slovenian,sl,Spanish,es,Spanish (ARG),es_AR,Spanish (SPA),es_ES,Spanish (MEX),es_MX,Swahili,sw,Swedish,sv,Tamil,ta,Telugu,te,Thai,th,Turkish,tr,Ukrainian,uk,Urdu,ur,Uzbek,uz,Vietnamese,vi,Zulu,zuv";
        $languages="Español (MEX),es_MX"; 
        $languages=explode(',',$languages);
        $languages=array_chunk($languages, 2);
       
        return view($this->view_path.'create', ['languages' => $languages,'isDemo'=>config('settings.is_demo',false)]);
    }

    public function submit(Request $request){
        $this->authChecker();
        $result=$this->submitWhatsAppTemplate($request->all());

        //Check status code
        if($result['status']==200){
            //Respond with json
            return response()->json(['status'=>'success']);
        }else{
            //Respond with json
            return response()->json(['status'=>'error','response'=>$result]);
        }

    }

    //uploadImage
    public function uploadImage(Request $request){
        $this->authChecker();
        try {
            $handle=$this->uploadDocumentToFacebook($request->imageupload);
            
        $imageURL=$this->saveDocument(
            "media",
            $request->imageupload,
        );

            return response()->json(['status'=>'success','url'=>$imageURL,'handle'=>$handle]);
        } catch (\Exception $e) {
            return response()->json(['status'=>'error','response'=>$e->getMessage()]);
        }

    }

    //uploadVideo
    public function uploadVideo(Request $request){
        $this->authChecker();
        try {
            $handle=$this->uploadDocumentToFacebook($request->videoupload);
            
            $videoURL=$this->saveDocument(
                "media",
                $request->videoupload,
            );

            return response()->json(['status'=>'success','url'=>$videoURL,'handle'=>$handle]);
        } catch (\Exception $e) {
            return response()->json(['status'=>'error','response'=>$e->getMessage()]);
        }

    }

    //uploadPdf
    public function uploadPdf(Request $request){
        $this->authChecker();
        try {
            $handle=$this->uploadDocumentToFacebook($request->pdfupload);
            $pdfURL=$this->saveDocument(
            "media",
            $request->pdfupload,
        );

            return response()->json(['status'=>'success','url'=>$pdfURL,'handle'=>$handle]);
        } catch (\Exception $e) {
            return response()->json(['status'=>'error','response'=>$e->getMessage()]);
        }

    }

    //Destroy
    public function destroy($id)
    {
        $this->authChecker();

        //Don't allow to delete if it is demo
        if(config('settings.is_demo',false)){
            return redirect()->route($this->webroute_path.'index',['refresh'=>"yes"])->withStatus(__('crud.error', ['error'=>'Disabled in demo']));
        }
       // $item=$this->provider::find($id);
           $item = $this->provider::withoutGlobalScopes()->find($id);
        if($item){
            $result=$this->deleteWhatsAppTemplate($item->name);
            if($result['status']==200){
                return redirect()->route($this->webroute_path.'index',['refresh'=>"yes"])->withStatus(__('crud.item_has_been_deleted', ['item'=>__($this->title)]));
            }else{
                return redirect()->route($this->webroute_path.'index',['refresh'=>"yes"])->withStatus(__('crud.error', ['error'=>'Error']));
            }
        }else{
            return redirect()->route($this->webroute_path.'index',['refresh'=>"yes"])->withStatus(__('crud.error', ['error'=>'Error']));
        }
    }
}