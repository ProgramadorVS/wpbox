@extends('general.index', $setup)
@section('cardbody')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ $setup['action'] }}" method="POST" enctype="multipart/form-data">
        @csrf
        @isset($setup['isupdate'])
            @method('PUT')
        @endisset
        @isset($setup['inrow'])
            <div class="row">
        @endisset
            @include('partials.fields',['fiedls'=>$fields])
        @isset($setup['inrow'])
            </div>
        @endisset
        @if (isset($setup['isupdate']))
            <button type="submit" class="btn btn-green">{{ __('Update')}}</button>  
        @else
            <button type="submit" class="btn btn-green">{{ __('Insert')}}</button>  
        @endif
    </form>
@endsection

@section('js')

<!-- para la mascara de telefono -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.phone-mask').forEach(function(phoneInput) {
        
        // Establece el valor inicial
        if(!phoneInput.value || phoneInput.value === '') {
            phoneInput.value = '521';
        }
        
        phoneInput.addEventListener('focus', function(e) {
            // Al hacer focus, asegura que empiece con 521
            if(!e.target.value || e.target.value === '') {
                e.target.value = '521';
            }
            // Coloca el cursor después del 521
            e.target.setSelectionRange(3, 3);
        });
        
        phoneInput.addEventListener('keydown', function(e) {
            // Previene borrar el prefijo 521
            if(e.target.selectionStart < 3 && (e.key === 'Backspace' || e.key === 'Delete')) {
                e.preventDefault();
            }
        });
        
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value;
            
            // Si intentan borrar el prefijo, lo restaura
            if(!value.startsWith('521')) {
                value = '521' + value.replace(/521/g, '').replace(/\D/g, '');
            } else {
                // Mantiene solo el prefijo y números después
                value = '521' + value.substring(3).replace(/\D/g, '');
            }
            
            // Limita a 10 dígitos después del 521 (total 13)
            if(value.length > 13) {
                value = value.substring(0, 13);
            }
            
            e.target.value = value;
        });
        
        phoneInput.addEventListener('click', function(e) {
            // Previene que el cursor se coloque antes del 521
            if(e.target.selectionStart < 3) {
                e.target.setSelectionRange(3, 3);
            }
        });
    });
});
</script>

<script type="text/javascript">
setTimeout(() => {
    $('.select2init').select2({
        }); 
}, 1000);
</script>
<script>
// Make the Name field uppercase as the user types/pastes
document.addEventListener('DOMContentLoaded', function() {
    // Try to find by id first, then by name attribute
    var nameInput = document.getElementById('name') || document.querySelector('input[name="name"]');
    if (!nameInput) return;

    // Ensure initial value is uppercase (when editing existing record)
    if (nameInput.value) nameInput.value = nameInput.value.toUpperCase();

    // Preserve cursor position when transforming
    function toUpperPreserveCaret(el) {
        try {
            var start = el.selectionStart;
            var end = el.selectionEnd;
            el.value = el.value.toUpperCase();
            // clamp positions
            var len = el.value.length;
            start = Math.min(start, len);
            end = Math.min(end, len);
            el.setSelectionRange(start, end);
        } catch (e) {
            // if selection not supported, fallback
            el.value = el.value.toUpperCase();
        }
    }

    nameInput.addEventListener('input', function(e) {
        toUpperPreserveCaret(e.target);
    });

    // Handle paste (paste event occurs before input value is updated in some browsers)
    nameInput.addEventListener('paste', function(e) {
        // Use timeout to run after paste is applied
        setTimeout(function() {
            toUpperPreserveCaret(nameInput);
        }, 0);
    });

    // Optionally ensure blur also uppercases (safe fallback)
    nameInput.addEventListener('blur', function(e) {
        e.target.value = e.target.value.toUpperCase();
    });
});
</script>
 
@endsection