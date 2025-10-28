@extends('general.index', $setup)
@section('thead')
    <th>{{ __('Name') }}</th>
    <th class="text-center">{{ __('Contacts') }}</th>
     <th class="text-center">{{ __('Es Automático') }}</th>
    <th>{{ __('crud.actions') }}</th>
@endsection
@section('tbody')
    @foreach ($setup['items'] as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td class="text-center">{{ $item->contacts->count() }}</td>
            <td class="text-center">{{ $item->esauto == 1 ? 'SI' : 'NO' }}</td>
            <td>
             @if($item->esauto == 0)
                    <!-- EDIT -->
                    <a href="{{ route('contacts.groups.edit',['group'=>$item->id]) }}" class="btn btn-green btn-sm">
                        <i class="ni ni-ruler-pencil"></i>
                    </a>


             
                        <!-- borrar -->
                        <a href="#" 
                        class="btn btn-danger btn-sm eliminar-registro" 
                        data-id="{{ $item->id }}" 
                        data-url="{{ route('contacts.groups.delete', ['group' => $item->id]) }}">
                            <i class="ni ni-fat-remove"></i>
                        </a>
                @endif
            </td>
        </tr> 
    @endforeach
@endsection