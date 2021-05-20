@extends('layout')
@section('title')
Carteira de cheques
@endsection
@section('body')
<div class="container">
      <div class="d-flex justify-content-between">
            <h3>Carteira de cheques</h3>
      </div>
      <x-table id="tabelaCheques">
            <x-table-header>
                  <tr>
                        <th>Parceiro</th>
                        <th>Data da troca</th>
                        <th>Valor bruto</th>
                        <th>Juros</th>
                        <th>Valor líquido</th>
                        <th>Ações</th>
                  </tr>
            </x-table-header>
            <tbody>
                  @forelse ($trocas as $troca)
                  <tr>
                        <td>{{ $troca->parceiro->pessoa->nome }}</td>
                        <td>{{ date('d/m/Y', strtotime($troca->data_troca)) }}</td>
                        <td>R$ {{ number_format($troca->valor_bruto, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($troca->valor_juros, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($troca->valor_liquido, 2, ',', '.') }}</td>
                        <td>
                              <a class="btn btn-primary" href="{{ route('troca_cheques.show', $troca->id) }}"><i class="fas fa-eye"></i></a>
                              <a class="btn btn-secondary" target="_blank" href="{{ route('pdf_troca', $troca->id) }}"><i class="fas fa-print"></i></a>
                        </td>
                  </tr>
                  @empty
                  <tr>
                        <td colspan=6>Nenhum cheque</td>
                  </tr>
                  @endforelse
            </tbody>
      </x-table>
      {{ $trocas->links() }}
</div>
@endsection
@section('script')
<script>

</script>
@endsection