{{-- Título de la campaña --}}
<div class="row mb-4">
    <div class="col-12 text-center">
     
     
    </div>
</div>

{{-- Cuadros estadísticos --}}
<div class="row mb-4">
    @if (!$item->is_bot && !$item->is_api)

        {{-- Card 1: Información de la campaña --}}
<div class="col-xl-4 col-md-6">
    <div class="card card-stats equal-height">
        <div class="card-body d-flex flex-column justify-content-between" style="min-height: 160px;">
            <div class="row align-items-start flex-nowrap">
                <div class="col pr-0" style="min-width:0;">
                    <h5 class="card-title text-uppercase text-muted mb-0">{{ __('Campaña') }} {{ $item->type->name ?? 'Sin tipo' }}</h5>
                    <span class="h5 font-weight-bold mb-2 d-block text-truncate" style="max-width: 180px;">
                        {{ $item->name }}
                    </span>
                    {{-- Separación después del nombre --}}
                    @if($item->grupos && $item->grupos->count())
                        <div class="mb-2">
                            <span class="text-muted" style="font-size: 0.95em;">{{ __('Grupos mandados:') }}</span>
                            <span class="badge badge-green badge-group-wrap">
                                {{ implode(', ', $item->grupos->pluck('name')->values()->all()) }}
                            </span>
                        </div>
                    @endif
                    {{-- Separación antes de la fecha --}}
                    <div class="mt-2">
                        <span class="campaign-date">
                            @if ($item->timestamp_for_delivery > now())
                                {{ __('Programada para') }}: {{ $item->timestamp_for_delivery }}
                            @else
                                {{ __('Fecha de envío') }}: {{ $item->timestamp_for_delivery ? $item->timestamp_for_delivery : $item->created_at }}
                            @endif
                        </span>
                    </div>
                </div>
                <div class="col-auto pl-2">
                    <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                        <i class="ni ni-bullet-list-67"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

       
{{-- Card 2: Mensajes mandados, Enviados, Entregados, Leídos y Contestados --}}
<div class="col-xl-4 col-md-6">
    <div class="card card-stats equal-height">
        <div class="card-body d-flex flex-column" style="min-height: 160px;">
            <div class="row align-items-start mb-1">
                <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-1">{{ __('Mensajes y Estados') }}</h5>
                </div>
                <div class="col-auto">
                    <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow" style="font-size:1.3rem;">
                        <i class="ni ni-chart-bar-32"></i>
                    </div>
                </div>
            </div>
            <table class="table table-sm mb-0" style="width:100%;">
                <tbody>
                    <tr>
                        <td class="text-left" style="width:45%;">{{ __('Contactos') }}</td>
                        <td class="text-center" style="width:25%;"><strong>{{ $item->send_to }}</strong></td>
                        <td class="text-right" style="width:30%;"></td>
                    </tr>

                    <tr>
                        <td class="text-left" style="width:45%;">{{ __('En cola') }}</td>
                        <td class="text-center" style="width:25%;"><strong>{{ $item->sending_to }}</strong></td>
                        <td class="text-right" style="width:30%;"></td>
                    </tr>

                    <tr>
                        <td class="text-left">{{ __('Enviados') }}</td>
                        <td class="text-center"><strong>{{ $item->sended_to }}</strong></td>
                        <td class="text-right text-muted">
                            {{ $item->send_to > 0 ? round(($item->sended_to / max($item->send_to,1)) * 100, 2) : '0' }}%
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left">{{ __('Entregados') }}</td>
                        <td class="text-center"><strong>{{ $item->delivered_to }}</strong></td>
                        <td class="text-right text-muted">
                            {{ $item->sended_to > 0 ? round(($item->delivered_to / max($item->sended_to,1)) * 100, 2) : '0' }}%
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left">{{ __('Leídos') }}</td>
                        <td class="text-center"><strong>{{ $item->read_by }}</strong></td>
                        <td class="text-right text-muted">
                            {{ $item->delivered_to > 0 ? round(($item->read_by / max($item->delivered_to,1)) * 100, 2) : '0' }}%
                        </td>
                    </tr>

                    <tr>
                        <td class="text-left">{{ __('Errores') }}</td>
                        <td class="text-center"><strong>{{ $item->con_error }}</strong></td>
                        <td class="text-right text-muted">
                            {{ $item->send_to > 0 ? round(($item->con_error / max($item->send_to,1)) * 100, 2) : '0' }}%
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left">{{ __('Contestados') }}</td>
                        <td class="text-center"><strong>{{ $item->contestado_por }}</strong></td>
                        <td class="text-right text-muted">
                            {{ $item->send_to > 0 ? round(($item->contestado_por / max($item->send_to,1)) * 100, 2) : '0' }}%
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Card 3: Respuestas distintas y su conteo --}}
<div class="col-xl-4 col-md-12">
    <div class="card card-stats equal-height">
        <div class="card-body align-top">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-1">{{ __('Respuestas') }}</h5>
                    @php
                        $respuestas = \Modules\Wpbox\Models\Message::where('campaign_id', $item->id)
                            ->whereNotNull('respuesta')
                            ->where('respuesta', '!=', '')
                            ->select('respuesta', DB::raw('count(*) as total'))
                            ->groupBy('respuesta')
                            ->orderByDesc('total')
                            ->get();
                        $totalRespuestas = $respuestas->sum('total');
                    @endphp
                    <span class="h2 font-weight-bold mb-1 d-block">
                        {{ $item->send_to > 0 ? round(($totalRespuestas / max($item->send_to,1)) * 100, 2) : '0' }}%
                    </span>
                </div>
                <div class="col-auto">
                    <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow" style="font-size:1.3rem;">
                        <i class="ni ni-chat-round"></i>
                    </div>
                </div>
            </div>
            <div class="mb-1 text-sm">
                <span class="text mr-2">{{ $totalRespuestas }}</span>
                <span class="text-nowrap">{{ __('Respuestas registradas') }}</span>
            </div>
            <ul class="list-unstyled mb-0 mt-0">
                @forelse($respuestas as $respuesta)
                    <li class="mb-1">
                        <span class="badge badge-green">{{ $respuesta->respuesta }}:</span>
                        <span class="font-weight-bold">{{ $respuesta->total }}</span>
                    </li>
                @empty
                    <span class="text-muted">{{ __('Sin respuestas registradas') }}</span>
                @endforelse
            </ul>
        </div>
    </div>
</div>
{{-- fin Card 3: Respuestas distintas y su conteo --}}
{{-- Paginación --}}


    @endif
</div>