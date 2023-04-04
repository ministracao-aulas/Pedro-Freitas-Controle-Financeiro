<button
    type="{{ $type ?? 'button' }}" class="{{ $btnClass ?? $class ?? 'd-none d-sm-inline-block btn btn-sm tf-shadow-sm-hover' }}"

    @if($actionName ?? null)
        data-action-name="{{ $actionName ?? null }}"
        data-action-type="trigger"
    @endif

    @if($actionEventName ?? $actionName ?? null)
        data-action-event-name="{{ $actionEventName ?? null }}"
    @endif

    @if($actionObjectContainer ?? null)
        data-action-object-container="{{ $actionObjectContainer ?? null }}"
    @endif

    @if($actionInfoType ?? null)
        data-action-info-type="{{ $actionInfoType ?? null }}"
    @endif

    @if($actionInfo ?? null)
        data-action-info="{{ $actionInfo ?? null }}"
    @endif

    @if($title ?? null)
        title="{{ $title ?? null }}"
    @endif
>

    {{ $slot }}
    @if ($icon ?? null)
    <i class="{{
            implode(' ', [
                $iconType ?? 'fas',
                'fa-' . ($icon ?? ''),
                'fa-' . ($iconSize ?? 'lg'),
                $iconClass ?? null,
            ])
        }}"
    ></i>
    @endif
</button>
