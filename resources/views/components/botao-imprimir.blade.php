<a {{ $attributes->merge(([
    'class' => 'btn btn-dark',
    'href' => $attributes['href'],
    'title' => 'Imprimir'
])) }} target="_blank">Imprimir <span class="fas fa-print"></span></a>