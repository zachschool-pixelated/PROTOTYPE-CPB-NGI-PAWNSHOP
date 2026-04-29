@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800']) }}>
        <p class="font-medium text-sm text-green-800 dark:text-green-300">
            {{ $status }}
        </p>
    </div>
@endif
