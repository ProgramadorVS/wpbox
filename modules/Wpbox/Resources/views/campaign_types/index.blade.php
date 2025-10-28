@extends('general.index', $setup)
@section('thead')
  
    <th>{{ __('Tipo Campaña') }}</th>
    <th>{{ __('crud.actions') }}</th>
@endsection
@section('tbody')
    @foreach ($setup['items'] as $item)
        <tr>
           
            <td>{{ $item->name }}</td>
            <td>
                <!-- EDIT -->
                <a href="{{ route('campaigns.tiposcampa.edit',['tiposcampa'=>$item->id]) }}" class="btn btn-green btn-sm">
                    <i class="ni ni-ruler-pencil"></i>
                </a>


                <!-- borrar -->
                    <a href="#" 
                    class="btn btn-danger btn-sm eliminar-registro" 
                    data-id="{{ $item->id }}" 
                    data-url="{{ route('campaigns.tiposcampa.delete',['tiposcampa'=>$item->id]) }}">
                        <i class="ni ni-fat-remove"></i>
                    </a>




            </td>
        </tr> 
    @endforeach
@endsection