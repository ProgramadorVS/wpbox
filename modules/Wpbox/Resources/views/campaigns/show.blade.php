@extends('general.index', $setup)

@section('head')

@endsection

@section('customheading')
 
   <div class="mt-4">
    @include('wpbox::campaigns.infoboxes',$item)
   </div>
   
@endsection

@section('thead')
    <th>{{ __('Phone') }}</th>
    <th>{{ __('Name') }}</th>
    <th>{{ __('Programado') }}</th>
    <th>{{ __('Status') }}</th>
    <th>{{ __('Respuesta') }}</th>
    <th>{{ __('Message') }}</th>
 
@endsection
@section('tbody')
    @foreach ($setup['items'] as $item)
      @isset($item->contact)
        <tr>
          <td>{{ $item->contact->phone }}</td>
          <td>{{ $item->contact->name }}</td>
          
          <td>{{ $item->scchuduled_at }}</td>

          <td>
              @if ( $item->status==0)
              <span class="badge badge-dot mr-4">
                  <i class="bg-warning"></i>
                  <span class="status">{{ __('PENDING SENT')}} {{ __( $item->error)}}</span>
                </span> 
              @elseif ( $item->status==1)
              <span class="badge badge-dot mr-4">
                  <i class="bg-warning"></i>
                  <span class="status">{{ __('SENT')}} {{ __( $item->error)}}</span>
                </span>
              @elseif( $item->status==2)
                  {{ __('SENT')}} 
              @elseif( $item->status==3)
              <span class="badge badge-dot mr-4">
                  <i class="bg-info"></i>
                  <span class="status">{{ __('DELIVERED')}} {{ __( $item->error)}}</span>
                </span>
              @elseif( $item->status==4)
              <span class="badge badge-dot mr-4">
                  <i class="bg-success"></i>
                  <span class="status">{{ __('READ')}} {{ __( $item->error)}}</span>
                </span>
              @elseif( $item->status==5)
              <span class="badge badge-dot mr-4">
                  <i class="bg-danger"></i>
                  <span class="status">{{ __('FAILED')}} : {{ __( $item->error)}} </span>
                </span>

              @elseif( $item->status==6)
              <span class="badge badge-dot mr-4">
                  <i class="bg-success"></i>
                  <span class="status">{{ __('CONTESTADO')}} </span>
                </span>


              @endif
          </td>
            <td>{{ $item->respuesta }}</td>
          <td>{{ $item->value }}</td>
        </tr>
      @endisset
         
    @endforeach
@endsection