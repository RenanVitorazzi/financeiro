$(function() {
    $("#cep").change( async (e) => {
        let cep = e.target.value;
        let cepTratado = cep.match(/[0-9]+/g).join("");

        if (cepTratado.length !== 8) {
            alertaErro('CEP inválido!', 'Informe um CEP com 8 dígitos');
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
                erroRequisicao(jqXHR, textStatus, errorThrown)
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
                erroRequisicao(jqXHR, textStatus, errorThrown)
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

    $("#tipoCadastro").on('change', () => {
        $("#cpfGroup").toggle();
        $("#cnpjGroup").toggle();
    })

    $("#cpf").on('keypress', (event) => {
        $(event.target).mask('000.000.000-00');
    });

    $("#celular").on('keypress', (event) => {
        $(event.target).mask('(00)00000-0000');
    });

    $("#telefone").on('keypress', (event) => {
        $(event.target).mask('(00)0000-0000');
    });

    $("#celular2").on('keypress', (event) => {
        $(event.target).mask('(00)00000-0000');
    });

    $("#telefone2").on('keypress', (event) => {
        $(event.target).mask('(00)0000-0000');
    });

    $("#cep").on('keypress', (event) => {
        $(event.target).mask('00000-000');
    });

    $("#cnpj").on('keypress', (event) => {
        $(event.target).mask('00.000.000/0000-00');
    });
});

