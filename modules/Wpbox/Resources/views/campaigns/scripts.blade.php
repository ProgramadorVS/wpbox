<script type="text/javascript">
$(document).ready(function() {
    // Inicializa Select2 para selects con clase .select2
    $('.select2').select2({
        placeholder: 'Selecciona campañas',
        width: '100%'
    });

    // Handle "Select All" checkbox
    $('#select-all').change(function() {
        $('.select-item').prop('checked', $(this).is(':checked'));
        updateSelectedCount();
        toggleBulkActionButton();
    });

    // Handle individual checkbox change
    $('.select-item').change(function() {
        updateSelectedCount();
        toggleBulkActionButton();
    });

    // Update the number of selected items
    function updateSelectedCount() {
        var count = $('.select-item:checked').length;
        $('#selected-count').text(count + ' Campañas seleccionadas');
    }
});
</script>
