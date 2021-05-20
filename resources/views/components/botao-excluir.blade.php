<form method="POST" action="{{ $attributes['action'] }}" class="d-inline" onsubmit="confirmarExclusao(event, this)">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger" title="Excluir">
        <span class="fas fa-trash-alt"></span>
    </button>
</form>