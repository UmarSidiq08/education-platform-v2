@props(['size' => 'default', 'position' => 'absolute'])

@php
$sizeClasses = [
    'small' => 'h-4 w-4 text-xs',
    'default' => 'h-5 w-5 text-xs',
    'large' => 'h-6 w-6 text-sm'
];

$positionClasses = [
    'absolute' => 'absolute -top-2 -right-2',
    'relative' => 'relative ml-2',
    'floating' => 'absolute -top-2 -right-2'
];
@endphp

<span {{ $attributes->merge(['class' => 'bg-red-500 text-white rounded-full flex items-center justify-center font-bold animate-pulse ' . $sizeClasses[$size] . ' ' . $positionClasses[$position]]) }} 
      style="display: none;" 
      data-chat-badge>
    <span data-chat-count>0</span>
</span>
