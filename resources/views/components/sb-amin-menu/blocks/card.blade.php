@props([
    'heading',
    'footer',
])

<div {{ $attributes->class(['card', 'shadow', 'mb-4']) }}>
    <div class="card-header py-3">
        <h6
            @isset($heading)
            {{ $heading->attributes->class(['m-0', 'font-weight-bold', 'text-primary']) }}
            @endisset
        >
            {{ $heading ?? '' }}
        </h6>
    </div>

    <div class="card-body">
        <div>
            {{ $slot }}
        </div>
    </div>

    @isset($footer)
    <div class="card-footer">
            <div {{ $footer->attributes->class(['text-primary mb-3']) }}>
                {{ $footer }}
            </div>
    </div>
    @endisset
</div>
