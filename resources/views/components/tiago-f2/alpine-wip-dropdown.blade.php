<!-- tiago-f2/alpine-wip-dropdown.blade.php -->
@php
    $icon ??= '';
@endphp

<div x-data="dropdown('{{ $icon }}')">
    <button
        @click="toggle"
        {{ $attributes->merge(['class' => 'btn btn-md btn-info']) }}>
        <i class="fas {{ $icon }}"></i>
        {{ $label }}
    </button>
    <div x-show="open">
        {{ $slot }}
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dropdown', (icon) => ({
                open: false,
                toggle() {
                    this.open = !this.open
                },
                icon: icon
            }))
        })
    </script>
@endpush

{{--
    Usage:

    <x-tiago-f2.alpine-wip-dropdown label="Toggle Content" icon="fa-bars" x-data="{ foo: 'bar' }" class="btn-outline-danger text-white">
        <p>Content goes here</p>
    </x-tiago-f2.alpine-wip-dropdown>
--}}
