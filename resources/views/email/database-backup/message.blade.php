<x-mail::panel>
<div class="button button-{{ $success ? 'success' : 'danger'  }}">
    {{ $success ? 'Backup gerado com sucesso' : 'Falha ao gerar o backup' }}
</div>
</x-mail::panel>

@if ($success && $filePath)
<strong>Segue anexo uma cópia do banco</strong>
@endif

<x-mail::panel>
    E-mail enviado em {{ date('c') }}
</x-mail::panel>
