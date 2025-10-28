<div class="campign_elements">
@if (!isset($_GET['contact_id']))
    @if ($isBot)
        @include('partials.input',['id'=>'name','name'=>'Nombre del Bot','placeholder'=>'Nombre del Bot', 'required'=>true])
    @else
        @include('partials.input',['id'=>'name','name'=>'Nombre de Campaña','placeholder'=>'Nombre de la Campaña', 'required'=>true])
    @endif 
@endif

@include('partials.select',['id'=>'tipo','name'=>'Tipo de Campaña','data'=>$tipocampaña, 'required'=>true]) 

@include('partials.select',['id'=>'template_id','name'=>'Template','data'=>$templates, 'required'=>true])






@if (isset($_GET['contact_id'])  )
   
   
             @include('partials.select',['id'=>'contact_id','name'=>'Contact','data'=>$contacts, 'required'=>true])

@elseif($isBot)
    <input type="hidden" name="type" value="bot">
    @include('partials.select',['id'=>'reply_type','name'=>'Reply type','value'=>2,'data'=>['2'=>__('Reply bot: On exact match'),'3'=>__('Reply bot: When message contains')], 'required'=>true])  
    @include('partials.input',[ 'name'=>'Trigger', 'id'=>'trigger', 'placeholder'=>'Enter bot reply trigger', 'required'=>false])
@elseif($isAPI)
    <input type="hidden" name="type" value="api">
@elseif($isSimple)
     <input type="hidden" name="type" value="simple">
@else



    @include('partials.select',['id'=>'group_id','name'=>'Contacts','data'=>$groups, 'required'=>false])
    <div class="form-group">
        <label for="example-datetime-local-input" class="form-control-label">{{ __('Horario para mandar') }}</label>
        <input class="form-control" type="datetime-local" @isset($_GET['send_time'])
            value="{{$_GET['send_time']}}"
        @endisset id="send_time" name="send_time" min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i')}}">
        <small class="text-muted"><strong>{{ __('Necesita un Cron para funcionar') }}</strong></small>
    </div>
    @include('partials.toggle',['dloff'=>'Schudule send','dlon'=>'Send now','dloff'=>'Schudule send','id'=>'send_now','name'=>'Ignorar horario, mandar ahora', 'checked'=>(isset($_GET['send_now']))])
@endif



<div class="d-flex justify-content-end">
    <button onclick="submitJustCampign()" class="btn btn-success mt-4">{{ __('Aplicar') }}</button>
</div>
</div>