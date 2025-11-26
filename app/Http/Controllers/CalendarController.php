<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Appointment;
use App\Models\Doctor; 


class CalendarController extends Controller
{
     /**
     * Provide class.
     */
    private $provider = Appointment::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'calendario.';

    /**
     * View path.
     */
    private $view_path = 'calendario.';

    /**
     * Parameter name.
     */
    private $parameter_name = 'calendar';

    /**
     * Title of this crud.
     */
    private $title = 'Calendario';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'Calendarios';

    /**
     * Auth checker function for the crud.
     */
    private function authChecker()
    {
        $this->ownerAndStaffOnly();
    }


public function index(Request $request)
{
 
        $this->authChecker();
    
        $company = auth()->user()->company ?? null;

        $companyLabels = [
            'label_contact_name_full' => $company?->getConfig('label_contact_name_full', 'NOMBRE DEL PACIENTE'),
            'label_contact_name_singular' => $company?->getConfig('label_contact_name_singular', 'PACIENTE'),
            'label_contact_name_plural' => $company?->getConfig('label_contact_name_plural', 'PACIENTES'),
            'label_responsable_name_full' => $company?->getConfig('label_responsable_name_full', 'NOMBRE DEL DOCTOR'),
            'label_responsable_name_singular' => $company?->getConfig('label_responsable_name_singular', 'DOCTOR'),
            'label_responsable_name_plural' => $company?->getConfig('label_responsable_name_plural', 'DOCTORES'),
        ];
 
    return view($this->view_path . 'index', [
       
        'setup' => [
            'title'          => $this->titlePlural,
            'iscontent'      => true,
 
             
            'item_names'     => $this->titlePlural,
            'webroute_path'  => $this->webroute_path,
            'fields'         => [],
            'custom_table'   => false,
            // 'parameter_name' => $this->parameter_name,
            // 'parameters'     => $request->query->count() !== 0,      
        ],
             'doctors' => Doctor::orderBy('name')->get(),
            'companyLabels'=> $companyLabels,
    ]);
}


public function getAppointments(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $doctorId = $request->input('doctor_id');

        $query = Appointment::with('contact')
            ->whereBetween('fecha', [$start, $end]);

        if ($doctorId) {
            $query->where('doctor_id', $doctorId);
        }
        
        $doctor_name= Doctor::where('id', $doctorId)->value('name');

        $appointments = $query->get();

        $events = [];

        foreach ($appointments as $appointment) {
            $color = $this->getStatusColor($appointment->status_id,$appointment->contact->expediente,$appointment->tipocita);

            $scheduledAt = \Modules\Wpbox\Models\Message::where('cita_id', $appointment->id)
                ->where('es_cita_confirma', 1)
                ->value('scchuduled_at');
            if ($scheduledAt === null) {
                $scheduledAt = '';
            }
              $tipocita= $appointment->tipocita;

            $tipocitaText = '';

            switch ($tipocita) {
                case 1:
                    $tipocitaText = 'NORMAL';
                    break;
                case 2:
                    $tipocitaText = 'VACUNA ALERGOIDE';
                    break;
                case 3:
                    $tipocitaText = 'VACUNA ACUOSA';
                    break;
                case 4:
                    $tipocitaText = 'ORAL';
                    break;
                default:
                    $tipocitaText = 'DESCONOCIDO'; // Opcional: manejar valores no esperados
                    break;
            }

            $events[] = [
                'id' => $appointment->id,
                'title' => $appointment->contact->name . ' - ' . $appointment->note,
                'start' => $appointment->fecha . 'T' . $appointment->hora,
                'end' => $appointment->fecha . 'T' . $appointment->horafin,
                'color' => $color,
                'extendedProps' => [
                    'contact_name' => $appointment->contact->name,
                    'contact_phone' => $appointment->contact->phone,
                    'note' => $appointment->note,
                    'asiste' => $appointment->asiste,
                    'status_id' => $appointment->status_id,
                    'whatscita_agenda'=>$appointment->whatscita_agenda,
                    'whatscita_confirma'=>$appointment->whatscita_confirma,
                    'whatscita_cancela'=>$appointment->whatscita_cancela,
                    'whatscita_ok'=>$appointment->whatscita_ok,
                    'scheduledAt' => $scheduledAt,
                    'doctor_name'=>$doctor_name,
                    'tipocitaText' => $tipocitaText,
                    'tipocita' => $tipocita,
                ]
            ];
        }

        return response()->json($events);
    }

    /**
     * Toggle the 'asiste' flag for an appointment (AJAX endpoint).
     * FUNCION PARA CAMBIAR EL STATUS SI FUE O NO EL PACIENTE A LA CITA
     */
    public function toggleAsiste(Request $request)
    {
        $id = $request->input('id');

        if (!$id) {
            return response()->json(['error' => 'ID de cita no proporcionado'], 422);
        }

        $appointment = Appointment::find($id);
        if (!$appointment) {
            return response()->json(['error' => 'Cita no encontrada'], 404);
        }

        $appointment->asiste = $appointment->asiste ? 0 : 1;
        $appointment->save();

        return response()->json(['id' => $appointment->id, 'asiste' => (int) $appointment->asiste]);
    }
    
/**
 * Obtiene el color para un estado, con una condición especial para "PRIMERA VEZ".
 *
 * @param int $statusId El ID del estado.
 * @param string|null $expediente El número de expediente (opcional).
 * @return string El código de color hexadecimal.
 */
private function getStatusColor($statusId, $expediente = null, $tipocita)
{
    

    // 1. Lógica nueva: Si NO es cita normal (tipos 2, 3, 4)
    // El color depende exclusivamente del tipo de cita, ignorando el status.
    if ($tipocita != 1) {
        switch ($tipocita) {
            case 2: return '#8166b3ff'; 
            case 3: return '#fb00cd70'; 
            case 4: return '#4cbbb6b8';
            default: return '#fcfc04ff'; // Gris default por seguridad
        }
    }

    // 2. Lógica original (Solo se ejecuta si tipocita == 1)
    
    // Condición especial: Si es "PRIMERA VEZ" y el status es 1 (Pendiente/Agendada)
    if ($statusId == 1 && $expediente === 'PRIMERA VEZ') {
        return '#f4c93cff'; // Amarillo
    }
    // Switch original basado en el estatus de la cita
    switch ($statusId) {
        case 1: return '#196cf3d9'; // Azul
        case 2: return '#10B981';   // Verde (Atendido)
        case 3: return '#EF4444';   // Rojo (Cancelado)
        default: return '#fcfc04ff';  // Gris
    }
    
}



       public function events(Request $request)
    {
        $start = Carbon::parse($request->query('start'));
        $end = Carbon::parse($request->query('end'));

        $appointments = Appointment::with('contact')
            ->whereBetween('fecha', [$start->toDateString(), $end->toDateString()])
            ->get();

        $events = $appointments->map(function ($appointment) {
            $color = match ($appointment->status_id) {
                1 => 'blue',
                2 => 'green',
                3 => 'red',
                default => 'gray',
            };

            $startDateTime = Carbon::parse($appointment->fecha . ' ' . $appointment->hora);
            $endDateTime = Carbon::parse($appointment->fecha . ' ' . $appointment->horafin);

            // Ignorar eventos con hora final menor a hora inicial
            if ($endDateTime->lessThan($startDateTime)) {
                return null;
            }

            return [
                'id' => $appointment->id,
                'title' => mb_convert_encoding($appointment->contact->name, 'UTF-8') . ' (' . $appointment->contact->phone . ')' . ($appointment->note ? ' - ' . $appointment->note : ''),
                'start' => $startDateTime->toIso8601String(),
                'end' => $endDateTime->toIso8601String(),
                'backgroundColor' => $color,
                'borderColor' => $color,
                
            ];
        })->filter()->toArray();

        return response()->json($events);
    }

 
}
