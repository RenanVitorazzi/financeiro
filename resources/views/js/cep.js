$(function() {
    function alertaErroRequisicao (jqXHR, textStatus, errorThrown) {
        console.error(jqXHR)
        console.error(textStatus)
        console.error(errorThrown)
        Swal.fire({
            title: 'ERRO DE CONEXÃO' + textStatus,
            icon: 'error'
        })
    }
    
    function alertaErroIndicacao (text) {
        Swal.fire({
            title: text,
            icon: 'error'
        })
    }
    
    $("#cep").change( async (e) => {
        let cep = e.target.value;
        let cepTratado = cep.match(/[0-9]+/g).join("");
    
        if (cepTratado.length !== 8) {
            alertaErroIndicacao('CEP INVÁLIDO! INFORME UM CEP COM 8 DÍGITOS!');
            return;
        }
    
        let response = await $.ajax({
            type: 'GET',
            url: `https://viacep.com.br/ws/${cepTratado}/json/`,
            dataType: 'json',
            async: 'false',
            beforeSend: () => {
                swal.showLoading()
            },
            error: (jqXHR, textStatus, errorThrown) => {
                alertaErroRequisicao(jqXHR, textStatus, errorThrown)
            }
        });
    
        $("input:disabled, select:disabled").each((index, element) => {
            $(element).attr("disabled", false);
        })
    
        $("#logradouro").val(response.logradouro)
        $("#bairro").val(response.bairro)
        $("#estado").val(response.uf)
        await popularMunicipios();
        $("#municipio").val(response.localidade)
        
    })
    
    $("#estado").change( () => {
        popularMunicipios();
    })
    
    async function popularMunicipios() {
        $("#municipio").html("<option></option>")

        let response = await $.ajax({
            type: 'GET',
            url: `https://servicodados.ibge.gov.br/api/v1/localidades/estados/${$("#estado").val()}/municipios`,
            async: 'false',
            beforeSend: () => {
                swal.showLoading();
            },
            error: (jqXHR, textStatus, errorThrown) => {
                alertaErroRequisicao(jqXHR, textStatus, errorThrown)
            }
        });

        response.forEach(element => {
            let nomeMunicipio = element.nome;
            $("#municipio").append(`
                <option value='${nomeMunicipio}'>${nomeMunicipio}</option>
            `)
        })
        swal.close();
    }

    $("#tipoCadastro").change( () => {
        $("#cpfGroup").toggle();
        $("#cnpjGroup").toggle();
    })

    $( "#cpf" ).keypress(function() {
        $(this).mask('000.000.000-00');
    });

    $( "#celular" ).keypress(function() {
        $(this).mask('(00)00000-0000');
    });

    $( "#telefone" ).keypress(function() {
        $(this).mask('(00)0000-0000');
    });

    $( "#cep" ).keypress(function() {
        $(this).mask('00000-000');
    });

    $( "#cnpj" ).keypress(function() {
        $(this).mask('00.000.000/0000-00');
    });
});

