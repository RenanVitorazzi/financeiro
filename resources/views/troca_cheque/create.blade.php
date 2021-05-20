@extends('layout')
@section('title')
Carteira de cheques
@endsection
@section('body')
    <div class="container">
        <div class="d-flex justify-content-between">
            <h3>Carteira de cheques</h3>
        </div>
        <form action="{{ route('trocar') }}" id="formTrocaCheques">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <x-table id="tabelaCheques">
                <x-table-header>
                    <tr>
                        <th><input type="checkbox" id="selecionaTodos"></th>
                        <th>Cliente</th>
                        <th>Representante</th>
                        <th>Data</th>
                        <th>Valor</th>
                    </tr>
                </x-table-header>
                <tbody>
                    @forelse ($cheques as $cheque)
                        <tr>
                            <td>
                                <input type="checkbox" name="cheque_id[]" value="{{ $cheque->id }}">
                            </td>
                            <td>{{ $cheque->cliente }}</td>
                            <td>{{ $cheque->representante }}</td>
                            <td>{{ date('d/m/Y', strtotime($cheque->data_parcela)) }}</td>
                            <td>R$ {{ number_format($cheque->valor_parcela,2, ',', '.') }}</td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan=5>Nenhum cheque</td>
                    </tr>
                    @endforelse
                </tbody>
            </x-table>
            <div class="row">
                <div class="col-6">
                    <x-form-group type='date' name="data_troca" value="{{ date('Y-m-d')}}">Informe a data</x-form-group>
                </div>
                <div class="col-6">
                    <label for="parceiro_id">Informe o parceiro</label>
                    <x-select name="parceiro_id">
                        @foreach ($parceiros as $parceiro)
                            <option value="{{ $parceiro->id }} "> {{ $parceiro->pessoa->nome }} ({{ $parceiro->porcentagem_padrao }}%)</option>
                        @endforeach
                    </x-select>
                </div>
            </div>
            
            <button class="btn btn-success" id="trocarCheques" type="submit">
                Trocar <i class="ml-2 fas fa-money-bill-wave"></i>
            </button>
            
        </form>
    </div>
@endsection
@section('script')
<script>
    $("#tabelaCheques").dataTable();

    $("#selecionaTodos").click( (e) => {
        let status = $(e.target).prop("checked");
        $("input[name='cheque_id[]']").each( (index, element) => {
           $(element).prop("checked", status);
        });
    })

    $("#formTrocaCheques").submit( (event) => {
        event.preventDefault();

        let data = $("#data_troca").val()
        let parceiro_id = $("#parceiro_id").val()
        let qtdCheques = $("input[name='cheque_id[]']:checked").length

        // if (!data || !parceiro_id || qtdCheques === 0) {
        //     Swal.fire({
        //         title: 'Erro!',
        //         text: 'Informe no mínimo a data, o parceiro e um cheque',
        //         icon: 'error'
        //     })

        //     return
        // }

        trocaCheque()
    });

    function trocaCheque() {
        
        $.ajax({
            type: 'POST',
            url: "{{ route('trocar') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $("#formTrocaCheques").serialize(),
            dataType: 'json',
            beforeSend: () => {
                Swal.showLoading()
            },
            success: (response) => {
                console.log(response)
                return
                Swal.fire({
                    title: 'Sucesso!',          
                    icon: 'success'
                }).then((result) => {
                    // document.location.reload(true)
                })
            },
            error: (jqXHR, textStatus, errorThrown) => {
                
                var response = JSON.parse(jqXHR.responseText)
                var errorString = ''
                $.each( response.errors, function( key, value) {
                    errorString += '<div>' + value + '</div>'
                });
               
                Swal.fire({
                    title: 'Erro',
                    icon: 'error',
                    html: errorString
                })
            }
        });
    }

</script>
@endsection