<table {{ $attributes->merge(([
    'class' => 'table text-center table-light',
])) }}>
   {{ $slot }}
</table>