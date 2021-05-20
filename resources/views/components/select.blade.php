<select {{ $attributes->merge(([
    'class' => $errors->has($attributes['name']) ? 'is-invalid form-control' : 'form-control' ,
    'id' => $attributes['name']
])) }}>
    {{ $slot }}
</select>
@error($attributes['name'])
<div class="invalid-feedback d-inline">
    {{ $message }}
</div>
@enderror