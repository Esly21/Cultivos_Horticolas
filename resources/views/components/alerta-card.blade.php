@props(['alerta'])

@php
    $config = [
        'critical' => [
            'icon' => 'siren',
            'iconColor' => 'text-red-600',
            'bgColor' => 'bg-red-50 border-red-200',
            'badgeColor' => 'bg-red-100 text-red-800',
            'badgeText' => 'Crítica',
        ],
        'warning' => [
            'icon' => 'alert-triangle',
            'iconColor' => 'text-yellow-600',
            'bgColor' => 'bg-yellow-50 border-yellow-200',
            'badgeColor' => 'bg-yellow-100 text-yellow-800',
            'badgeText' => 'Advertencia',
        ],
        'info' => [
            'icon' => 'info',
            'iconColor' => 'text-blue-600',
            'bgColor' => 'bg-blue-50 border-blue-200',
            'badgeColor' => 'bg-blue-100 text-blue-800',
            'badgeText' => 'Informativa',
        ],
    ][$alerta->severidad] ?? [
        'icon' => 'bell',
        'iconColor' => 'text-gray-600',
        'bgColor' => 'bg-gray-50 border-gray-200',
        'badgeColor' => 'bg-gray-100 text-gray-800',
        'badgeText' => 'General',
    ];
@endphp

<div class="p-4 border-l-4 rounded-r-lg flex items-start gap-4 transition-all hover:shadow-md {{ $config['bgColor'] }}">
    <i data-lucide="{{ $config['icon'] }}" class="w-6 h-6 flex-shrink-0 mt-1 {{ $config['iconColor'] }}"></i>
    <div class="flex-1">
        <p class="text-gray-800 font-medium mb-2">{{ $alerta->mensaje }}</p>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i data-lucide="clock" class="w-4 h-4"></i>
                <span>{{ $alerta->fecha->format('d/m/Y H:i') }}</span>
            </div>
            <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $config['badgeColor'] }}">
                {{ $config['badgeText'] }}
            </span>
        </div>
    </div>
</div>