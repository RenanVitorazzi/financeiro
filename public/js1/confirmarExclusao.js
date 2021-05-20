const swalBootstrap = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-danger mr-2',
      cancelButton: 'btn btn-dark'
    },
    buttonsStyling: false
})

function confirmarExclusao (e, element) {
    e.preventDefault()
    
    swalBootstrap.fire({
        icon: 'warning',
        title: 'Tem certeza de que deseja excluir o registro?',
        text: 'A ação não poderá ser desfeita!',
        showCancelButton: true,
        confirmButtonText: 'Excluir',
        cancelButtonText: 'Não, cancelar',
    }).then((result) => {
        if (result.isConfirmed) {       
            element.submit()
        }
    })
} 

function alertaErro (title, text) {
    Swal.fire({
        title: title,
        icon: 'error',
        text: text
    })
}

function erroRequisicao (jqXHR, textStatus, errorThrown) {
    console.error(jqXHR)
    console.error(textStatus)
    console.error(errorThrown)
    Swal.fire({
        title: 'ERRO ' + textStatus,
        icon: 'error'
    })
}