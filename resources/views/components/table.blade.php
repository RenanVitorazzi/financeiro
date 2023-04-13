<table {{ $attributes->merge(([
    'class' => 'table text-center table-striped table-light table-responsive-sm table-responsive-md',
])) }}>
   {{ $slot }}
</table>