<a {{ $attributes->merge(([
        'class' => 'btn btn-dark',
        'href' => $attributes['href'],
        'title' => 'Editar'
    ])) }}>
    <i class='fas fa-pencil-alt'></i>
</a>