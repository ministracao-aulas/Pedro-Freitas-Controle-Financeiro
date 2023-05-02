@props([
    'heading',
    'footer',
])


<div class="row">
    <div {{ $attributes->class(['col-sm-12', 'mb-4']) }}>
        <x-sb-amin-menu.blocks.card>
            @isset($heading)
                <x-slot:heading>
                    {{ $heading }}
                </x-slot>
            @else
                [WIP]
            @endisset

            <h3>Em breve algo legal aqui</h3>

            <h6 class="mb-0">
                Há algo em desenvolvimento para essa parte do projeto.
            </h6>

            <div>
                {{ $slot }}
            </div>

            @isset($footer)
                <x-slot:footer>
                    {{ $footer }}
                </x-slot>
            @endisset
        </x-sb-amin-menu.blocks.card>
    </div>
</div>
