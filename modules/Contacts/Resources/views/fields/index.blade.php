@extends('general.index', $setup)
@section('thead')
    <th>{{ __('Name') }}</th>
    <th class="text-center">{{ 'Mostrar en Reporte' }}</th>
    <th>{{ __('crud.actions') }}</th>
@endsection
@section('tbody')
    @foreach ($setup['items'] as $item)
        <tr>
            <td>{{ $item->name }}</td>
           <td class="text-center">{{ $item->mostrarenreporte == 1 ? 'SI' : 'NO' }}</td>
            <td>
                <!-- EDIT -->
                <a href="{{ route('contacts.fields.edit',['field'=>$item->id]) }}" class="btn btn-green btn-sm">
                    <i class="ni ni-ruler-pencil"></i>
                </a>

                <!-- borrar  -->
         
                <a href="#" class="btn btn-danger btn-sm eliminar-registro" data-id="{{ $item->id }}" data-url="{{ route('contacts.fields.delete',['field'=>$item->id]) }}">
                    <i class="ni ni-fat-remove"></i>
                </a>
            </td>
        </tr> 
    @endforeach
@endsection

