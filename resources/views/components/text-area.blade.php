<textarea {{ $attributes->merge(([
    'class' => $errors->has($attributes['name']) ? 'is-invalid form-control' : 'form-control' , 
    'type' => 'text', 
    'id' => $attributes['name']
])) }}>
    {{ $slot }}
</textarea>
@error($attributes['name'])
<div class="invalid-feedback d-inline">
    {{ $message }}
</div>
@enderror