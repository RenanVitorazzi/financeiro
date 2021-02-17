<input {{ $attributes->merge(([
    'class' => 'form-control', 
    'type' => 'text', 
    'id' => $attributes['name']
])) }} >