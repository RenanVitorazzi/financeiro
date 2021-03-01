<form method="POST" action="{{ $attributes['action'] }}" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger" title="Excluir">
        <span class="fas fa-trash-alt"></span>
    </button>
</form>