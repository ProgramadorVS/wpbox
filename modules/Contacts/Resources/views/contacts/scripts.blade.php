<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.eliminar-registro').forEach(function(boton) {
        boton.addEventListener('click', function (e) {
            e.preventDefault(); // Prevenir navegación directa

            const id = this.dataset.id;
            const url = this.dataset.url;

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción eliminará el registro.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Sí, proceder',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redireccionar manualmente a la ruta
                    window.location.href = url;
                }
            });
        });
    });
});
</script>

<script type="text/javascript">
$(document).ready(function() {
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

    // Handle individual checkbox change
    $('.select-item').change(function() {
        updateSelectedCount();
    });

    // Update the number of selected items
    function updateSelectedCount() {
        var count = $('.select-item:checked').length;
        $('#selected-count').text(count + ' records selected');
    }

    // Handle "Move to group" action
    $('#move-to-group').click(function(e) {
        e.preventDefault();
        $('#move-to-group-modal').modal('show');
    });



    // Handle "Move" button click in the modal
    $('#move-to-group-confirm').click(function() {
        var selectedIds = getSelectedIds();
        var selectedGroupId = $('input[name="group"]:checked').val();

        // Make an AJAX call to assign the selected items to the selected group
        $.ajax({
            url: '/contacts/contacts/assigntogroup/' + selectedIds.join(',')+"?group_id="+selectedGroupId,
            type: 'GET',
            success: function(result) {
                // Handle success here
                console.log('Successfully assigned:', result);

                // Close the modal
                $('#move-to-group-modal').modal('hide');

                js.notify(result.message, 'success');

                // Refresh the page after 4 seconds
                setTimeout(function() {
                            location.reload();
                        }, 4000);
            },
            error: function(xhr, status, error) {
                // Handle error here
                console.log('Error:', error);
                js.notify(error, 'error');
            }
        });
    });



    // Handle "Move to Agent" action
    $('#move-to-agent').click(function(e) {
        e.preventDefault();
        $('#move-to-agent-modal').modal('show');
    });


  $('#move-to-agent-confirm').click(function() {
        var selectedIds = getSelectedIds();
        var selectedGroupId = $('input[name="user"]:checked').val();

        // Make an AJAX call to assign the selected items to the selected group
        $.ajax({
            url: '/contacts/contacts/assigntoagent/' + selectedIds.join(',')+"?user_id="+selectedGroupId,
            type: 'GET',
            success: function(result) {
                // Handle success here
                console.log('Successfully assigned:', result);

                // Close the modal
                $('#move-to-agent-modal').modal('hide');

                js.notify(result.message, 'success');

                // Refresh the page after 4 seconds
                setTimeout(function() {
                            location.reload();
                        }, 4000);
            },
            error: function(xhr, status, error) {
                // Handle error here
                console.log('Error:', error);
                
                js.notify(error, 'error');
            }
        });
    });




//

 // Handle "Remove from agent" action
    $('#remove-from-agent').click(function(e) {
        e.preventDefault();
        $('#remove-from-agent-modal').modal('show');
    });

  // Handle "Remove" button click in the modal
$('#remove-from-agent-confirm').click(function() {
    var selectedIds = getSelectedIds();

    // Llama al endpoint sin el parámetro user_id
    $.ajax({
        url: '/contacts/contacts/removeagent/' + selectedIds.join(','),
        type: 'GET',
        success: function(result) {
            // Handle success here
            console.log('Successfully removed:', result);

            // Close the modal
            $('#remove-from-agent-modal').modal('hide');

            js.notify(result.message, 'success');

            // Refresh the page after 4 seconds
            setTimeout(function() {
                location.reload();
            }, 4000);
        },
        error: function(xhr, status, error) {
            // Handle error here
            console.log('Error:', error);
            js.notify(error, 'error');
        }
    });
});
//


    



    // Handle "Remove from group" action
    $('#remove-from-group').click(function(e) {
        e.preventDefault();
        $('#remove-from-group-modal').modal('show');
    });

    // Handle "Remove" button click in the modal
    $('#remove-from-group-confirm').click(function() {
        var selectedIds = getSelectedIds();
        var selectedGroupId = $('input[name="groupremove"]:checked').val();

        // Make an AJAX call to remove the selected items from the selected groups
        $.ajax({
            url: '/contacts/contacts/removefromgroup/' + selectedIds.join(',')+"?group_id="+selectedGroupId,
            type: 'GET',
            success: function(result) {
                // Handle success here
                console.log('Successfully removed:', result);

                // Close the modal
                $('#remove-from-group-modal').modal('hide');

                js.notify(result.message, 'success');

                // Refresh the page after 4 seconds
                setTimeout(function() {
                    location.reload();
                }, 4000);
            },
            error: function(xhr, status, error) {
                // Handle error here
                console.log('Error:', error);
                js.notify(error, 'error');
            }
        });
    });

    // Handle "Delete selected" action
    $('#delete-selected').click(function(e) {
        e.preventDefault();
        var selectedIds = getSelectedIds();

        // Now you have all selected IDs in the `selectedIds` array
        // Add your code here to delete the selected items
        if (confirm('Delete selected items\nAre you sure you would like to do this?')) {
            // User confirmed deletion
            // Now you have all selected IDs in the `selectedIds` array
            // Add your code here to delete the selected items
            console.log('Delete selected:', selectedIds);

            $.ajax({
                url: '/contacts/contacts/bulkremove/' + selectedIds.join(','),
                type: 'GET',
                success: function(result) {
                    // Handle success here
                    js.notify(result.message, 'success');

                    // Refresh the page after 4 seconds
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    // Handle error here
                    console.log('Error:', error);
                    js.notify(error, 'error');
                }
            });


        }
    });

    // Show or hide bulk action button
    function toggleBulkActionButton() {
        if ($('.select-item:checked').length > 0) {
            $('#bulk-action-button').show();
        } else {
            $('#bulk-action-button').hide();
        }
    }

    // Get IDs of all selected items
    function getSelectedIds() {
        return $('.select-item:checked').map(function() {
            return $(this).val();
        }).get();
    }
});
</script>
