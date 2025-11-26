<div>



<div class="calendar-container">
    <div id="calendar"></div>
</div>
 

 

 <!-- Botón flotante para actualizar -->
<button id="refreshButton" class="refresh-btn">
    <i class="fas fa-sync-alt"></i> Actualizar
</button>



<!-- Modal para detalles de cita -->
<div id="appointmentModal" class="modal2">
    <div class="modal2-content">
        <div class="modal2-header">
            <h2 id="modalTitle">
                <i class="bi bi-calendar-check"></i>
                Detalles de la Cita
            </h2>
            <span class="close">&times;</span>
        </div>
        
        <div class="modal2-body">
            <!-- Información principal -->
            <div class="info-card">
                <div class="info-row">
                    <div class="info-label">
                        <i class="bi bi-person-check icon-user"></i>
                        {{ Str::title($companyLabels['label_responsable_name_singular']) }}:
                    </div>
                    <div class="info-value" id="modalDoctor"></div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">
                        <i class="bi bi-person icon-user"></i>
                        {{ Str::title($companyLabels['label_contact_name_singular']) }}:
                    </div>
                    <div class="info-value" id="modalPatient"></div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">
                        <i class="bi bi-telephone icon-phone"></i>
                        Teléfono:
                    </div>
                    <div class="info-value" id="modalPhone"></div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">
                        <i class="bi bi-calendar3 icon-calendar"></i>
                        Fecha:
                    </div>
                    <div class="info-value" id="modalDate"></div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">
                        <i class="bi bi-clock icon-clock"></i>
                        Hora:
                    </div>
                    <div class="info-value" id="modalTime"></div>
                </div>
                

                <div class="info-row">
                    <div class="info-label">
                        <i class="bi bi-prescription2"></i>
                        Tipo de Cita:
                    </div>
                    <div class="info-value" id="modalTipoCitaText"></div>
                </div>


                <div class="info-row">
                    <div class="info-label">
                        <i class="bi bi-journal-text icon-notes"></i>
                        Notas:
                    </div>
                    <div class="info-value" id="modalNotes"></div>
                </div>
            </div>

            <!-- Estado y notificaciones -->
            <div class="status-section">
                <div class="status-header">
                    <i class="bi bi-activity"></i>
                    Estado de la Cita y Notificaciones
                </div>
                
                <div class="status-item">
                    <div class="status-label">
                        <i class="bi bi-circle-fill status-indicator"></i>
                        Status Cita:
                    </div>
                    <div>
                        <span   id="modalStatus"></span>
                    </div>
                </div>
                
                <div class="status-item">
                    <div class="status-label">
                        <i class="bi bi-whatsapp whatsapp-green"></i>
                        Cita:
                    </div>
                    <div >
                        <span id="modalCita"></span>
                    </div>
                </div>
                
                <div class="status-item">
                    <div class="status-label">
                        <i class="bi bi-whatsapp whatsapp-green"></i>
                        Recordatorio:
                    </div>
                    <div >
                        <span id="modalRecordatorio"></span>
                    </div>
                </div>
                
                <div class="status-item">
                    <div class="status-label">
                        <i class="bi bi-whatsapp whatsapp-green"></i>
                        Confirmación:
                    </div>
                    <div >
                        <span id="modalConfirmacion"></span>
                    </div>
                </div>
                
                <div class="status-item">
                    <div class="status-label">
                        <i class="bi bi-whatsapp whatsapp-green"></i>
                        Cancelación:
                    </div>
                    <div >
                        <span id="modalCancelacion"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer con botones -->
        <div class="modal2-footer">
            <div style="flex: 1; text-align: left;">
                <button id="asisteToggleBtn" class="btn btn-danger">
                    <i class="bi bi-x-circle"></i>
                    ASISTE (NO)
                </button>
            </div>
            {{-- <button id="deleteAppointmentBtn" class="btn btn-danger">
                <i class="bi bi-trash"></i>
                Eliminar cita
            </button> --}}
            <button id="editarAppointmentBtn" class="btn btn-primary">
                <i class="bi bi-pencil-square"></i>
                Editar cita
            </button>
            <button id="cerrarAppointmentBtn" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i>
                Cerrar
            </button>
        </div>
    </div>
</div>



<!-- Modal para detalles de cita -->


</div>


 @section('js')
   


    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.min.js'></script>



        <script>
            var calendar; // Declarar global

            // Guard: coerce numeric/string payloads for toggle-asiste into object
            // This prevents Livewire's internal unpacking error when older code
            // or other scripts emit a raw numeric id. We only transform the
            // specific event name to avoid changing other behaviors.
            (function () {
                if (!window.Livewire) return;

                try {
                    const originalEmit = Livewire.emit.bind(Livewire);
                    Livewire.emit = function(eventName, payload) {
                        if (eventName === 'toggle-asiste' && (typeof payload === 'number' || typeof payload === 'string')) {
                            payload = { id: Number(payload) };
                        }
                        return originalEmit(eventName, payload);
                    };

                    if (typeof Livewire.dispatch === 'function') {
                        const originalDispatch = Livewire.dispatch.bind(Livewire);
                        Livewire.dispatch = function(eventName, payload) {
                            if (eventName === 'toggle-asiste' && (typeof payload === 'number' || typeof payload === 'string')) {
                                payload = { id: Number(payload) };
                            }
                            return originalDispatch(eventName, payload);
                        };
                    }
                } catch (e) {
                    console.warn('Livewire guard setup failed:', e);
                }
            })();

      
            document.addEventListener('DOMContentLoaded', function () {
              
                var calendarEl = document.getElementById('calendar');
                var modal = document.getElementById('appointmentModal');
                var span = document.getElementsByClassName("close")[0];
                var refreshButton = document.getElementById('refreshButton');
                var doctorFilter = document.getElementById('doctor-filter');

                var autoRefreshOnNavigation = false;

                calendar = new FullCalendar.Calendar(calendarEl, {
                    locale: 'es',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
                    },

                    initialView: 'dayGridMonth',
                    
                    // AQUI LA LÓGICA: Si el tipo es > 1, agregamos la clase 'hide-time'
                        eventClassNames: function(arg) {
                            if (Number(arg.event.extendedProps.tipocita) > 1) {
                                return [ 'hide-time' ];
                            }
                            return []; // Si es 1, no agregamos nada y se ve normal
                        },


                  // displayEventTime: false,


                    eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    },




                    
                    navLinks: true,
                    nowIndicator: true,
                    dayMaxEvents: true,
                    slotMinTime: '10:00:00',
                    slotMaxTime: '20:00:00',
                    slotDuration: '00:20:00',


                    height: window.innerWidth < 768 ? 884.444 : 'auto',
                    windowResize: function(view) {
                            if (window.innerWidth < 768) {
                                calendar.setOption('height', 884.444);
                            } else {
                                calendar.setOption('height', 'auto');
                            }
                        },



                    events: function(fetchInfo, successCallback, failureCallback) {
                        var doctorId = doctorFilter.value;
                        var url = '{{ route("calendario.data") }}'
                            + '?start=' + fetchInfo.startStr
                            + '&end=' + fetchInfo.endStr
                            + '&doctor_id=' + doctorId;

                        fetch(url)
                            .then(response => response.json())
                            .then(events => successCallback(events))
                            .catch(error => failureCallback(error));
                    },

                    dateClick: function (info) {
                        // Cambiar a vista día desde vista mes o semana
                        if (calendar.view.type === 'dayGridMonth' || calendar.view.type === 'timeGridWeek') {
                            calendar.changeView('timeGridDay', info.date);
                        }
                    },

                    eventClick: function (info) {
                        var event = info.event;
                        var start =  event.start;
                        var end = event.end;
                        var idCita = Number(event.id);
                        var tipocita = Number(event.extendedProps.tipocita);
                        var whatscita_agenda = Number(event.extendedProps.whatscita_agenda);
                        var whatscita_confirma = Number(event.extendedProps.whatscita_confirma);
                        var whatscita_cancela = Number(event.extendedProps.whatscita_cancela);
                        var whatscita_ok = Number(event.extendedProps.whatscita_ok);
                        var scheduledAt = event.extendedProps.scheduledAt;

                        var tipoId = Number(event.extendedProps.tipocita);
                        var tipoText = event.extendedProps.tipocitaText;
                        var badgeColor = '';

                            // 2. Definimos el color según tu lógica exacta
                            switch (tipoId) {
                                case 1: 
                                    badgeColor = '#196cf3d9'; //  
                                    break;
                                case 2: 
                                    badgeColor = '#8166b3ff'; //  
                                    break;
                                case 3: 
                                    badgeColor = '#fb00cd70'; //  
                                    break;
                                case 4: 
                                    badgeColor = '#4cbbb6b8'; // ORAL
                                    break;
                                default: 
                                    badgeColor = '#fcfc04ff'; // Gris (Aplica para el tipo 1 si no se especifica otro)
                                    break;
                            }
                          
                        // 3. Construimos el HTML del Badge (asumiendo Bootstrap)
                        // Usamos 'innerHTML' para que renderice la etiqueta <span>
                        var badgeHtml = `<span class="badge rounded-pill" style="background-color: ${badgeColor}; color: #fff; font-size: 0.8em; padding: 8px 12px;">${tipoText}</span>`;
  
                        const estadoAgenda = getEstadoAgendaJS(whatscita_agenda);
                        const estadoConfirma = getEstadoConfirmaJS(whatscita_confirma);
                        const estadoCancela = getEstadoAgendaJS(whatscita_cancela);
                        const estadoOk= getEstadoConfirmaJS(whatscita_ok);


                        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                        var dateFormatted = start.toLocaleDateString('es-ES', options);

                        let timeFormatted;
                        // Verificamos explícitamente la cadena 'NORMAL'
                         
                        if (tipocita !== 1) {
                            timeFormatted = "TODO EL DIA";
                        } else {

                          timeFormatted = start.toLocaleTimeString('es-ES', {
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        if (end) {
                            timeFormatted += ' - ' + end.toLocaleTimeString('es-ES', {
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        }
                    }


                        var statusText = '';
                        var statusClass = '';

                        const statusId = Number(event.extendedProps.status_id);
                        switch (statusId) {
                            case 1:
                                statusText = 'Agendada';
                                statusClass = 'badge badge-primary';
                                break;
                            case 2:
                                statusText = 'Confirmada';
                                statusClass = 'badge badge-success';
                                break;
                            case 3:
                                statusText = 'Cancelada';
                                statusClass = 'badge badge-danger';
                                break;
                        }

                        document.getElementById('modalDoctor').textContent = event.extendedProps.doctor_name;
                        document.getElementById('modalPatient').textContent = event.extendedProps.contact_name;
                        document.getElementById('modalPhone').textContent = event.extendedProps.contact_phone.substring(3);
                        document.getElementById('modalDate').textContent = dateFormatted;
                        document.getElementById('modalTime').textContent = timeFormatted;
                        
                        //document.getElementById('modalTipoCitaText').textContent = event.extendedProps.tipocitaText;
                        // 4. Insertamos en el DOM
                        document.getElementById('modalTipoCitaText').innerHTML = badgeHtml;
                       
                        
                       // document.getElementById('modalTipoCita').textContent = event.extendedProps.tipocita;

                        document.getElementById('modalNotes').textContent = event.extendedProps.note || 'Sin notas';
                        document.getElementById('modalStatus').innerHTML =
                            '<span class="' + statusClass + '">' + statusText + '</span>';

                        // Configurar botón ASISTE según payload
                        var asisteBtn = document.getElementById('asisteToggleBtn');
                        if (asisteBtn) {
                            var asisteVal = Number(event.extendedProps.asiste || 0);
                            if (asisteVal === 1) {
                                asisteBtn.className = 'btn btn-success';
                                asisteBtn.innerHTML = '<i class="bi bi-check-circle"></i> ASISTE (SI)';
                            } else {
                                asisteBtn.className = 'btn btn-danger';
                                asisteBtn.innerHTML = '<i class="bi bi-x-circle"></i> ASISTE (NO)';
                            }

                            // Click handler para alternar (JS puro -> fetch)
                            asisteBtn.onclick = async function() {

                                // Prepare CSRF token for Laravel
                                var tokenMeta = document.querySelector('meta[name="csrf-token"]');
                                var token = tokenMeta ? tokenMeta.getAttribute('content') : '{{ csrf_token() }}';

                                // show loading state (keep color)
                                var previousHtml = asisteBtn.innerHTML;
                                var previousClass = asisteBtn.className;
                                var previousStyle = asisteBtn.getAttribute('style') || '';
                                // block button while processing and change to secondary color
                                asisteBtn.disabled = true;
                                var processingClass = 'btn btn-secondary';
                                // store current class to restore later
                                var currentClass = asisteBtn.className;
                                asisteBtn.className = processingClass;
                                // ensure visible opacity
                                asisteBtn.style.opacity = '1';
                                asisteBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...';

                                fetch('{{ url("calendario/toggle-asiste") }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': token
                                    },
                                    body: JSON.stringify({ id: idCita })
                                })
                                .then(function(resp) {
                                    return resp.json().then(function(data) { return { status: resp.status, body: data }; });
                                })
                                .then(function(result) {
                                    var status = result.status;
                                    var body = result.body || {};
                                    if (status >= 200 && status < 300) {
                                        var asisteVal = Number(body.asiste || 0);
                                        if (asisteVal === 1) {
                                            asisteBtn.className = 'btn btn-success';
                                            asisteBtn.innerHTML = '<i class="bi bi-check-circle"></i> ASISTE (SI)';
                                        } else {
                                            asisteBtn.className = 'btn btn-danger';
                                            asisteBtn.innerHTML = '<i class="bi bi-x-circle"></i> ASISTE (NO)';
                                        }
                                        if (calendar && typeof calendar.refetchEvents === 'function') calendar.refetchEvents();
                                        // restore inline style after successful update
                                        if (previousStyle) asisteBtn.setAttribute('style', previousStyle); else asisteBtn.removeAttribute('style');
                                        // keep the success/danger class set above so color reflects the new state
                                        // re-enable button after processing
                                        asisteBtn.disabled = false;
                                    } else {
                                        var msg = body.error || 'Error al actualizar asistencia';
                                        // restore previous state on error
                                        asisteBtn.className = previousClass;
                                        if (previousStyle) asisteBtn.setAttribute('style', previousStyle); else asisteBtn.removeAttribute('style');
                                        asisteBtn.innerHTML = previousHtml;
                                        // re-enable button after error
                                        asisteBtn.disabled = false;
                                        alert(msg);
                                    }
                                })
                                .catch(function(err) {
                                    console.error('Error toggling asiste:', err);
                                    // restore previous state on network error
                                    asisteBtn.className = previousClass;
                                    if (previousStyle) asisteBtn.setAttribute('style', previousStyle) ; else asisteBtn.removeAttribute('style');
                                    asisteBtn.innerHTML = previousHtml;
                                    // re-enable button after network error
                                    asisteBtn.disabled = false;
                                    alert('Error de red al intentar actualizar la asistencia');
                                });
                            };
                        }

                      
                        // INICIO para mandar el mensaje
                        var modalCita = document.getElementById('modalCita');
                        var today = new Date();
                        today.setHours(0,0,0,0);
                        //   var eventDate = new Date(start.getFullYear(), start.getMonth(), start.getDate());

                        // Validar si el teléfono es inválido
                            if (String(event.extendedProps.contact_phone).trim() === '0000000000') {
                                modalCita.innerHTML = `<span class="badge badge-danger">EL NÚMERO NO ES VÁLIDO</span>`;
                            } else {
                            if (whatscita_agenda === 7) {
                                // Compara fecha y hora exacta
                                var now = new Date();
                                if (start.getTime() < now.getTime()) {
                                    // Si la fecha y hora de la cita es menor a ahora, muestra la leyenda
                                    modalCita.innerHTML = `<span class="badge badge-danger">mensaje no mandado a tiempo</span>`;
                                } else {
                                    // Validación adicional: si statusId es 2 o 3, mostrar solo el badge
                                    if (statusId === 3 || statusId === 2) {
                                        modalCita.innerHTML = `<span class="${estadoAgenda.class}">${estadoAgenda.label}</span>`;
                                    } else {
                                        // Muestra el botón y llama a Livewire al hacer clic
                                        modalCita.innerHTML = `
                                            <button id="btnMandarMensaje" class="btn btn-success btn-sm" title="Mandar mensaje de cita agendada por Whatsapp">
                                                <i class="bi bi-whatsapp"></i>
                                            </button>
                                        `;
                                        document.getElementById('btnMandarMensaje').onclick = function() {
                                            if (confirm('¿Seguro que quieres mandar el mensaje de WhatsApp?')) {
                                                Livewire.dispatch('mandar-whats', { id: idCita });
                                            }
                                        };
                                    }
                                }
                            } else {
                                // Muestra el badge
                                modalCita.innerHTML = `<span class="${estadoAgenda.class}">${estadoAgenda.label}</span>`;
                            }
                        }
                        // FIN para mandar el mensaje


                        //inicio para recordatorio
                       var recordatorioSpan = document.getElementById('modalRecordatorio');
                       var fechaTexto = '';
                       
                         if (statusId != 1 && (whatscita_confirma == 7 || whatscita_confirma == 0 || whatscita_confirma == 8)) {
                           // Si está cancelada y el estado de confirma es 7 o 0, mostrar CANCELADO
                           recordatorioSpan.innerHTML = '<span class="badge badge-light text-dark">N/A </span>';
                       } else {
                           if (scheduledAt) {
                               // Si quieres formatear la fecha en JS, puedes ajustar aquí:
                               var fechaObj = new Date(scheduledAt);
                               fechaTexto = ' <small>(' + fechaObj.toLocaleString('es-MX', { dateStyle: 'short', timeStyle: 'short' }) + ')</small>';
                           }
                           recordatorioSpan.innerHTML = '<span class="' + estadoConfirma.class + '">' + estadoConfirma.label + '</span>' +  fechaTexto;
                       }

                        // fin para recordatorio


                    //inicio para Confirmacion
                       var ConfirmacionSpan = document.getElementById('modalConfirmacion');
                       var fechaTexto = '';
                       
                         if (statusId != 1 && (whatscita_ok == 7 || whatscita_ok == 0 || whatscita_ok == 8)) {
                           // Si está cancelada y el estado de confirma es 7 o 0, mostrar CANCELADO
                           ConfirmacionSpan.innerHTML = '<span class="badge badge-light text-dark">N/A </span>';
                       } else {
                          
                          ConfirmacionSpan.innerHTML = '<span class="' + estadoOk.class + '">' + estadoOk.label + '</span>';
                       }

                        // fin para Confirmacion



                    //inicio para mensaje de cancelacion
                       var CancelacionSpan = document.getElementById('modalCancelacion');
                       var fechaTexto = '';
                       
                         if (statusId != 1 && (whatscita_cancela == 7 || whatscita_cancela == 0 || whatscita_cancela == 8)) {
                           // Si está cancelada y el estado de confirma es 7 o 0, mostrar CANCELADO
                           CancelacionSpan.innerHTML = '<span class="badge badge-light text-dark">N/A </span>';
                       } else {
                          
                          CancelacionSpan.innerHTML = '<span class="' + estadoCancela.class + '">' + estadoCancela.label + '</span>';
                       }

                        // fin para mensaje de cancelacion





                       Livewire.dispatch('setEditingAppointment', { appointmentId: idCita }); // le paso los datos por si le pica en editar
                         // aqui para que no pueda editar si ya se mandó el mensaje de whats
                                // solo podria cambiar el status ; 2 es cancelado y <> 7 es que ya se mandó un mensaje
                       var soloEstadoEditable =(statusId === 2 || whatscita_agenda !==7 );
                       Livewire.dispatch('setSoloEstadoEditable', { value: soloEstadoEditable });
                       
                       
                       modal.style.display = "block";

                       // ELIMINAR
                        // var deleteBtn = document.getElementById('deleteAppointmentBtn');
                        // if (deleteBtn) {
                        //     // Oculta el botón si la fecha es menor o igual a hoy o si whatscita_agenda != 7
                        //     var today = new Date();
                        //     today.setHours(0,0,0,0);
                        //     var eventDate = new Date(start.getFullYear(), start.getMonth(), start.getDate());
                        //     if (eventDate <= today || whatscita_agenda != 7) {
                        //         deleteBtn.style.display = 'none';
                        //     } else {
                        //         deleteBtn.style.display = '';
                        //         deleteBtn.onclick = function() {
                        //             if (confirm("¿Seguro que quieres eliminar esta cita?")) {
                        //                 Livewire.dispatch('eliminar-cita', { id: idCita });
                        //                 modal.style.display = "none";
                        //                 setTimeout(function() {
                        //                     if (calendar && typeof calendar.refetchEvents === 'function') {
                        //                         calendar.refetchEvents();
                        //                     }
                        //                 }, 500);
                        //             }
                        //         };
                        //     }
                        // }

                                 // Se mueve el dispatch al onclick del botón editar
// EDITAR
                             var editarBtn = document.getElementById('editarAppointmentBtn');
                            if (editarBtn) {
                                var today = new Date();
                                today.setHours(0,0,0,0);
                                var eventDate = new Date(start.getFullYear(), start.getMonth(), start.getDate());
                                var hideEdit = false;
                               
  

                                // Validación adicional: ocultar si status_id es 3 (cancelada)
                                    if (statusId === 3) {
                                        hideEdit = true;
                                    }


                                if (eventDate < today) {
                                    hideEdit = true;
                                } else if (eventDate.getTime() === today.getTime()) {
                                    // Si es hoy, comparar hora actual con la hora de la cita
                                    var now = new Date();
                                    var citaMinutes = start.getHours() * 60 + start.getMinutes();
                                    var nowMinutes = now.getHours() * 60 + now.getMinutes();
                                    if (nowMinutes >= citaMinutes) {
                                        hideEdit = true;
                                    }
                                }

                              

                                if (hideEdit) {
                                    editarBtn.style.display = 'none';
                                } else {
                                    editarBtn.style.display = '';
                                    editarBtn.onclick = function() {
                                     
                                        
                                        modal.style.display = "none";
                                        document.getElementById('editarAppointmentModal').style.display = "block";
                                    };
                                }
                            }
// EDITAR


 




// CERRAR
                             var cerrarBtn = document.getElementById('cerrarAppointmentBtn');
                            if (cerrarBtn) {
                               cerrarBtn.onclick = function() {                       
                                    modal.style.display = "none";
  
                                };
                            }
// CERRAR

 

                    },

                    slotLabelContent: function (arg) {
                        let hour = arg.date.getHours();

                        switch (hour) {
                            case 14: // Tipo 2
                                return { 
                                    html: '<div class="divider" style="color: #6f42c1; font-weight: bold; font-size: 0.8em;">ALERGOIDE</div>' 
                                };
                            case 15: // Tipo 3
                                return { 
                                    html: '<div class="divider" style="color: #fb00cd; font-weight: bold; font-size: 0.8em;">ACUOSA</div>' 
                                };
                            case 16: // Tipo 4
                                return { 
                                    html: '<div class="divider" style="color: #4cbbb6; font-weight: bold; font-size: 0.9em;">ORAL</div>' 
                                };
                        }

                        // Para el resto de horas, muestra la hora normal (ej: 10:00)
                        return {
                            html: arg.text
                        };
                    },

        viewDidMount: function (info) {
            if (autoRefreshOnNavigation) {
                calendar.refetchEvents();
                resetAutoRefreshTimer();
            }

            // Limpia los botones existentes (por si cambias de vista)
            document.querySelectorAll('.day-slot-button').forEach(btn => btn.remove());

            // Solo en vista diaria muestra botones
            if (info.view.type === 'timeGridDay') {
                setTimeout(() => {
                    addDayViewButtons();
                }, 100);
            }
        },

        datesSet: function (arg) {
            if (autoRefreshOnNavigation) {
                calendar.refetchEvents();
                resetAutoRefreshTimer();
            }

            // Limpia los botones existentes (por si cambias de vista)
            document.querySelectorAll('.day-slot-button').forEach(btn => btn.remove());

            // Solo en vista diaria muestra botones
            if (calendar.view.type === 'timeGridDay') {
                setTimeout(() => {
                    addDayViewButtons();
                }, 100);
            }
        }
                });

                // FUNCIONALIDAD SOLO PARA VISTA DIARIA
                function addDayViewButtons() {
                    document.querySelectorAll('.day-slot-button').forEach(btn => btn.remove());

                    const view = calendar.view;
                    if (view.type !== 'timeGridDay') return;

                    const currentViewDate = view.currentStart;
                    const timeSlots = document.querySelectorAll('.fc-timegrid-slot[data-time]');

                    timeSlots.forEach(slot => {
                        const timeStr = slot.getAttribute('data-time');
                        if (!timeStr) return;

                        const [hours, minutes] = timeStr.split(':').map(Number);
                        const viewDate = calendar.view.currentStart;
                        // Construye la fecha y hora local usando componentes
                        const slotDateTime = new Date(
                            viewDate.getFullYear(),
                            viewDate.getMonth(),
                            viewDate.getDate(),
                            hours,
                            minutes,
                            0,
                            0
                        );

                        // Oculta el botón si el día del slot es menor a hoy
                        const today = new Date();
                        today.setHours(0,0,0,0); // Normaliza a medianoche
                        const slotDay = new Date(slotDateTime.getFullYear(), slotDateTime.getMonth(), slotDateTime.getDate());
                        if (slotDay < today) {
                            return; // No crear botón para días pasados
                        }

                        // Si es el día actual, muestra el botón si el slot incluye la hora actual
                        if (slotDay.getTime() === today.getTime()) {
                            const now = new Date();
                            const slotStart = slotDateTime.getHours() * 60 + slotDateTime.getMinutes();
                            const slotEnd = slotStart + 20; // slot de 20 minutos
                            const nowTime = now.getHours() * 60 + now.getMinutes();
                            if (nowTime > slotEnd) {
                                return; // No crear botón si el slot ya terminó
                            }
                            // Si nowTime está entre slotStart y slotEnd, o es menor a slotEnd, se muestra el botón
                        }

                        const addButton = document.createElement('button');
                        addButton.innerHTML = '<i class="bi bi-plus" style="font-size: 10px;"></i>';
                        addButton.className = 'btn btn-success btn-sm p-0 day-slot-button';
                        addButton.style.cssText = `
                            width: 22px;
                            height: 22px;
                            border-radius: 50%;
                            opacity: 0;
                            transition: opacity 0.2s ease;
                            position: absolute;
                            top: 2px;
                            right: 2px;
                            z-index: 10;
                        `;

                        // addButton.onclick = function (e) {
                        //     e.stopPropagation();
                        //     e.preventDefault();
                        //     // Formatea la fecha yyyy-mm-dd
                        //     window.selectedSlotDate = slotDateTime.getFullYear() + '-' +
                        //         String(slotDateTime.getMonth() + 1).padStart(2, '0') + '-' +
                        //         String(slotDateTime.getDate()).padStart(2, '0');
                        //     // Formatea la hora HH:mm
                        //     window.selectedSlotTime = String(slotDateTime.getHours()).padStart(2, '0') + ':' +
                        //         String(slotDateTime.getMinutes()).padStart(2, '0');
                        //     Livewire.dispatch('setSlotDateTime', { fecha: window.selectedSlotDate, hora: window.selectedSlotTime });
                        //     document.getElementById('createAppointmentModal').style.display = "block";
                        // };
                        
                    // CODIGO OPTIMISTA MEJORADO PARA NO ESPERAR EL LAG DE LIVEWIRE
                        addButton.onclick = function (e) {
                            e.stopPropagation();
                            e.preventDefault();

                            // --- 1. PREPARACIÓN DE DATOS (JS PURO) ---
                            
                            // Formato Fecha YYYY-MM-DD
                            let fYear = slotDateTime.getFullYear();
                            let fMonth = String(slotDateTime.getMonth() + 1).padStart(2, '0');
                            let fDay = String(slotDateTime.getDate()).padStart(2, '0');
                            let fechaStr = `${fYear}-${fMonth}-${fDay}`;

                            // Formato Hora Inicio HH:mm
                            let hStart = String(slotDateTime.getHours()).padStart(2, '0');
                            let mStart = String(slotDateTime.getMinutes()).padStart(2, '0');
                            let horaStr = `${hStart}:${mStart}`;

                            // Cálculo Hora Fin (+20 min)
                            // Usamos timestamps para evitar errores de cambio de hora/día
                            let endTimeObj = new Date(slotDateTime.getTime() + 20 * 60000); 
                            let hEnd = String(endTimeObj.getHours()).padStart(2, '0');
                            let mEnd = String(endTimeObj.getMinutes()).padStart(2, '0');
                            let horaFinStr = `${hEnd}:${mEnd}`;

                            // Cálculo Tipo de Cita (Lógica espejo del Backend)
                            let hour = slotDateTime.getHours();
                            let tipoCitaCalc = 1; // Default
                            if (hour === 14) tipoCitaCalc = 2; // Alergoide
                            if (hour === 15) tipoCitaCalc = 3; // Acuosa
                            if (hour === 16) tipoCitaCalc = 4; // Oral


                            // --- 2. ACTUALIZACIÓN VISUAL INMEDIATA (OPTIMISTIC UI) ---

                            // A) Actualizar Inputs Directamente
                            // Buscamos los inputs por ID (asegúrate de que tus inputs tengan estos IDs)
                            let inputFecha = document.getElementById('fecha');
                            let inputHora = document.getElementById('hora');
                            let inputHoraFin = document.getElementById('horafin');
                            let selectTipo = document.getElementById('tipocita-select');

                            if (inputFecha) inputFecha.value = fechaStr;
                            if (inputHora) inputHora.value = horaStr;
                            if (inputHoraFin) inputHoraFin.value = horaFinStr;

                            // B) Actualizar el Select y Disparar Reactividad de Alpine
                            if (selectTipo) {
                                selectTipo.value = tipoCitaCalc;
                                // CRÍTICO: Disparar el evento 'change' manualmente hace que 
                                // tu código Alpine (x-on:change="...") se ejecute al instante,
                                // actualizando el texto del botón y los badges.
                                selectTipo.dispatchEvent(new Event('change')); 
                                selectTipo.dispatchEvent(new Event('input')); // Por seguridad para Livewire
                            }
                            
                            // Disparar input events para otros campos si tienen lógica atada
                            if (inputFecha) inputFecha.dispatchEvent(new Event('input'));


                            // --- 3. SINCRONIZACIÓN Y APERTURA ---

                            // Guardamos variables globales para tu lógica existente (opcional si ya no las usas abajo)
                            window.selectedSlotDate = fechaStr;
                            window.selectedSlotTime = horaStr;

                            // Abrimos el modal INMEDIATAMENTE. 
                            // Como ya inyectamos los valores en el DOM, el usuario ve la info correcta.
                            document.getElementById('createAppointmentModal').style.display = "block";

                            // Enviamos los datos al backend para que el estado ($this->state) sea consistente.
                            // Livewire procesará esto en segundo plano. Cuando responda, sobreescribirá
                            // los valores, pero como son idénticos a los calculados, el usuario no notará nada.
                            Livewire.dispatch('setSlotDateTime', { 
                                fecha: fechaStr, 
                                hora: horaStr 
                            });
                        };

                        slot.style.position = 'relative';
                        slot.appendChild(addButton);

                        let hideTimeout;

                        const showButton = () => {
                            clearTimeout(hideTimeout);
                            addButton.style.opacity = '1';
                        };

                        const hideButton = () => {
                            hideTimeout = setTimeout(() => {
                                addButton.style.opacity = '0';
                            }, 100);
                        };

                        slot.addEventListener('mouseenter', showButton);
                        slot.addEventListener('mouseleave', hideButton);
                        addButton.addEventListener('mouseenter', showButton);
                        addButton.addEventListener('mouseleave', hideButton);
                    });
                }

                // Agrega el listener SOLO UNA VEZ, después de inicializar el calendario y antes de calendar.render()
                if (doctorFilter) {
                    doctorFilter.addEventListener('change', function() {
                        if (calendar && typeof calendar.refetchEvents === 'function') {
                            calendar.refetchEvents();
                        }
                        // Actualiza el doctor_id en el componente Livewire de crear cita
                        Livewire.dispatch('setDoctorId', { doctor_id: doctorFilter.value }); // para el livewire crear
                        Livewire.dispatch('setDoctorIdUpdate', { doctor_id: doctorFilter.value }); // para el livewire editar
                    });
                }

                calendar.render();

                var autoRefreshTimer;

                function refreshCalendar() {
                   
                    if (refreshButton) {
                        
                        refreshButton.classList.add('refreshing');
                    }
              
                    calendar.refetchEvents();

                    setTimeout(function () {
                        if (refreshButton) {
                            refreshButton.classList.remove('refreshing');
                        }
                    }, 500);

                    resetAutoRefreshTimer();
                }

                function resetAutoRefreshTimer() {
                    if (autoRefreshTimer) {
                        clearTimeout(autoRefreshTimer);
                    }
                    autoRefreshTimer = setTimeout(function () {
                        refreshCalendar();
                    }, 120000);
                }

                if (refreshButton) {
                    refreshButton.addEventListener('click', refreshCalendar);
                }

                setTimeout(function () {
                    var todayButton = document.querySelector('.fc-today-button');
                    if (todayButton) {
                        todayButton.addEventListener('click', function () {
                            setTimeout(function () {
                                if (autoRefreshOnNavigation) {
                                    calendar.refetchEvents();
                                    resetAutoRefreshTimer();
                                }
                            }, 100);
                        });
                    }
                }, 500);

                resetAutoRefreshTimer();

                if (span) {
                    span.onclick = function () {
                        modal.style.display = "none";
                    };
                }

                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                };

                function toggleAutoRefreshMode() {
                    autoRefreshOnNavigation = !autoRefreshOnNavigation;
                    console.log('Actualización en navegación: ' + (autoRefreshOnNavigation ? 'ACTIVADA' : 'DESACTIVADA'));
                    return autoRefreshOnNavigation;
                }
            });

        //MODAL CREAR

        // Al guardar correctamente
            Livewire.on('cita-creada', () => {
                
                const createModal = document.getElementById('createAppointmentModal');
                if (createModal) {
                    createModal.style.display = 'none';
                    createModal.classList.remove('show', 'active');
                }
                const appointmentModal = document.getElementById('appointmentModal');
                if (appointmentModal) {
                    appointmentModal.style.display = 'none';
                    appointmentModal.classList.remove('show', 'active');
                }
                Livewire.dispatch('reset-form');
                // Espera 1 segundo antes de refrescar solo los eventos del calendario
                                       setTimeout(function() {
                                          
                                            calendar.refetchEvents();
                                           
                                        }, 500);
            });

                                    // Actualiza el botón ASISTE cuando el servidor confirme el cambio
                                    Livewire.on('asiste-toggled', (payload) => {
                                        var btn = document.getElementById('asisteToggleBtn');
                                        if (!btn) return;
                                        var asiste = Number(payload.asiste || 0);
                                        if (asiste === 1) {
                                            btn.className = 'btn btn-success';
                                            btn.innerHTML = '<i class="bi bi-check-circle"></i> ASISTE (SI)';
                                        } else {
                                            btn.className = 'btn btn-danger';
                                            btn.innerHTML = '<i class="bi bi-x-circle"></i> ASISTE (NO)';
                                        }
                                        // Si quieres cerrar el modal después de togglear, puedes hacerlo aquí
                                        // document.getElementById('appointmentModal').style.display = 'none';
                                    });



 


            
        // Al dar clic en la X de cerrar
            document.getElementById('closeCreateModal').onclick = function() {
                
                document.getElementById('createAppointmentModal').style.display = "none";
                Livewire.dispatch('reset-form');
            // Espera 1 segundo antes de refrescar solo los eventos del calendario
                                        setTimeout(function() {
                                            if (calendar && typeof calendar.refetchEvents === 'function') {
                                                calendar.refetchEvents();
                                            }
                                        }, 500);
        
            };

        // MODAL EDITAR

        

    // Al guardar correctamente
    // Si quieres cerrar el modal editar al crear cita, descomenta la siguiente línea:
    Livewire.on('cita-modificada', () => {
         document.getElementById('editarAppointmentModal').style.display = 'none';
           Livewire.dispatch('reset-form-editar');
           // Espera 1 segundo antes de refrescar solo los eventos del calendario
                                        setTimeout(function() {
                                          
                                            calendar.refetchEvents();
                                           
                                        }, 500);
     });
            
        // Al dar clic en la X de cerrar
        document.getElementById('closeEditarModal').onclick = function() {
            document.getElementById('editarAppointmentModal').style.display = "none";
            Livewire.dispatch('reset-form-editar');
           
                                         
        };


 // Al dar clic en  cerrar del editar modal
        document.getElementById('closeEditarModal2').onclick = function() {
            document.getElementById('editarAppointmentModal').style.display = "none";
            Livewire.dispatch('reset-form-editar');
           
                                         
        };


         // Al dar clic en  cerrar del editar Crear
        document.getElementById('closeEditarModal3').onclick = function() {
            document.getElementById('createAppointmentModal').style.display = "none";
            Livewire.dispatch('reset-form');
           
                                         
        };



        </script>

<script>

    function getEstadoAgendaJS(estado) {
        const estados = {
            0: { label: 'Mandado', class: 'badge badge-warning' },
            1: { label: 'Mandando', class: 'badge badge-warning' },
            2: { label: 'Enviado', class: 'badge badge-dark' },
            3: { label: 'Entregado', class: 'badge badge-info' },
            4: { label: 'Leído', class: 'badge badge-success' },
            5: { label: 'Error', class: 'badge badge-danger' },
            6: { label: 'Contestado', class: 'badge badge-dark' },
            7: { label: 'En Espera', class: 'badge badge-light text-dark' },
            8: { label: 'N/A', class: 'badge badge-light text-dark' }
        };
 
        return estados[estado] || { label: 'Desconocido', class: 'badge badge-secondary' };
    }


    function getEstadoConfirmaJS(estado) {
        
        const estados = {
            0: { label: 'En Espera', class: 'badge badge-primary' },
            1: { label: 'Mandando', class: 'badge badge-warning' },
            2: { label: 'Mandado', class: 'badge badge-dark' },
            3: { label: 'Entregado', class: 'badge badge-info' },
            4: { label: 'Leído', class: 'badge badge-info' },
            5: { label: 'Error', class: 'badge badge-danger' },
            6: { label: 'Contestado', class: 'badge badge-success' },
            7: { label: 'Pendiente', class: 'badge badge-light text-dark' },
            8: { label: 'N/A', class: 'badge badge-light text-dark' }
        };

        return estados[estado] || { label: 'Desconocido', class: 'badge badge-secondary' };
    }
    


</script>
    
    @endsection

