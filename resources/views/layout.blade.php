<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{ asset('style.css')}}">
  
  <link rel="stylesheet" href="{{ asset('dataTable.css')}}">
  <link rel="stylesheet" href="{{ asset('navbar.css')}}">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>
<body>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" id="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true" id="modal2">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" id="modal-header2">
                <h5 class="modal-title" id="modal-title2"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body2"></div>
            <div class="modal-footer" id="modal-footer2">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<div class="page-wrapper chiller-theme toggled">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
    <i class="fas fa-bars"></i>
  </a>
  
  <nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="{{ route('home') }}">
            Home
            {{-- <img src="{{ asset('dl_logo.png') }}"></img> --}}
        </a>
        <div id="close-sidebar">
          <i class="fas fa-times"></i>
        </div>
      </div>
      {{--
      <div class="sidebar-header">
        <div class="user-pic">
          <img class="img-responsive img-rounded" src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg"
            alt="User picture">
        </div> 
        <div class="user-info">
          <span class="user-name"><b>{{ auth()->user()->name }}</b></span>
          <span class="user-role">{{ auth()->user()->is_admin ? 'Administrador' : 'Representante' }}</span>
        </div>
      </div> 
      --}}
      <!-- sidebar-header  -->
      {{-- <div class="sidebar-search">
        <div>
          <div class="input-group">
            <input type="text" class="form-control search-menu" placeholder="Search...">
            <div class="input-group-append">
              <span class="input-group-text">
                <i class="fa fa-search" aria-hidden="true"></i>
              </span>
            </div>
          </div>
        </div>
      </div> --}}
      <!-- sidebar-search  -->
      <div class="sidebar-menu">
        <ul>
          {{-- <li class="header-menu">
            <span>General</span>
          </li> --}}
          @if(auth()->user()->is_admin)        
          <li @if(route('fornecedores.index') == Request::url()) class="ativo" @endif>
            <a href="{{ route('fornecedores.index') }}">
              <i class="fas fa-industry"></i>
              <span>Fornecedores</span>
            </a>
          </li>
          <li @if(route('parceiros.index') == Request::url()) class="ativo" @endif>
            <a href="{{ route('parceiros.index') }}">
              {{-- <i class="fas fa-handshake"></i> --}}
              <i class="fas fa-hands-helping"></i>
              <span>Parceiros</span>
            </a>
          </li>
          <li @if(route('representantes.index') == Request::url()) class="ativo" @endif>
            <a href="{{ route('representantes.index') }}">
              <i class="fas fa-user-tie"></i>
              <span>Representantes</span>
            </a>
          </li>
          @endif
          <li @if(route('clientes.index') == Request::url()) class="ativo" @endif>
            <a href="{{ route('clientes.index') }}">
              <i class="fas fa-users"></i>
              <span>Clientes</span>
            </a>
          </li>
          
          {{--
          <li @if(route('ops.index') == Request::url()) class="ativo" @endif>
            <a href="{{ route('ops.index') }}">
              <i class="fas fa-comment-dollar"></i>
              <span>Ordens de pagamento</span>
            </a>
          </li>
          --}}
          
          <li @if(route('estoque.index') == Request::url()) class="ativo" @endif>
            <a href="{{ route('estoque.index') }}">
            <i class="fas fa-exchange-alt"></i>
              <span>Estoque</span>
            </a>
          </li>
          @if(auth()->user()->is_admin)
          <li class="header-menu">
            <span>Financeiro</span>
          </li>
          <div class="sidebar-menu">
            <ul>
                <li @if(route('cheques.index') == Request::url()) class="ativo" @endif>
                    <a href="{{ route('cheques.index') }}">
                      <i class="fas fa-wallet"></i>
                      <span>Carteira de cheques</span>
                    </a>
                </li>
                <li @if(route('troca_cheques.index') == Request::url()) class="ativo" @endif>
                    <a href="{{ route('troca_cheques.index') }}">
                      <i class="fas fa-hand-holding-usd"></i>
                      <span>Troca de cheques</span>
                    </a>
                </li>
                <li @if(route('procura_cheque') == Request::url()) class="ativo" @endif>
                    <a href="{{ route('procura_cheque') }}">
                      <i class="fas fa-search"></i>
                      <span>Procurar cheque</span>
                    </a>
                </li>
                <li @if(route('recebimentos.index') == Request::url()) class="ativo" @endif>
                  <a href="{{ route('recebimentos.index') }}">
                  <i class="fas fa-exchange-alt"></i>
                    <span>Recebimentos</span>
                  </a>
                </li>
                <li @if(route('despesas.index') == Request::url()) class="ativo" @endif>
                  <a href="{{ route('despesas.index') }}">
                    <i class="fas fa-money-bill"></i>
                    <span>Despesas</span>
                  </a>
                </li>
                <li @if(route('entrega_parcela.index') == Request::url()) class="ativo" @endif>
                  <a href="{{ route('entrega_parcela.index') }}">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Entregar/Pegar cheques</span>
                  </a>
                </li>
                {{-- <li @if(route('adiamentos.index') == Request::url()) class="ativo" @endif>
                    <a href="{{ route('adiamentos.index') }}">
                      <i class="fas fa-clock"></i>
                      <span>Prorrogações</span>
                    </a>
                </li> --}}
                {{-- <li @if(route('devolvidos.index') == Request::url()) class="ativo" @endif>
                    <a href="{{ route('devolvidos.index') }}">
                      <i class="fas fa-undo-alt"></i>
                      <span>Devolvidos</span>
                    </a>
                </li> --}}
            
            </ul>
        </div>
          {{-- <li class="sidebar-dropdown">
                <a href="#">
                <i class="fas fa-dollar-sign"></i>
                <span>Financeiro</span>
                </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="{{ route('cheques.index') }}">Carteira de cheques</a>
                </li>
                <li>
                  <a href="{{ route('troca_cheques.index') }}">Troca de cheques</a>
                </li>
                <li>
                  <a href="{{ route('procura_cheque') }}">Procurar cheque</a>
                </li>
                <li>
                  <a href="{{ route('adiamentos.index') }}">Prorrogações</a>
                </li>
                <li>
                    <a href="{{ route('devolvidos.index') }}">Devolvidos</a>
                </li>
              </ul>
            </div>
          </li> --}}
          @endif
          @if(auth()->user()->is_representante)
            <li @if(route('venda.show', auth()->user()->is_representante) == Request::url()) class="ativo" @endif>
                <a href="{{ route('venda.show', auth()->user()->is_representante) }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Vendas</span>
                </a>
            </li>
            <li @if(route('conta_corrente_representante.show', auth()->user()->is_representante) == Request::url()) class="ativo" @endif>
                <a href="{{ route('conta_corrente_representante.show', auth()->user()->is_representante) }}">
                <i class="fas fa-balance-scale"></i>
                <span>Conta Corrente</span>
                </a>
            </li>
            <li @if(route('cheques.index') == Request::url()) class="ativo" @endif>
                <a href="{{ route('cheques.index') }}">
                <i class="fas fa-money-check-alt"></i>
                <span>Carteira de cheques</span>
                </a>
            </li>
          @endif
        </ul>
      </div>
      <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
    <div class="sidebar-footer">
      {{-- <a href="#">
        <i class="fa fa-bell"></i>
        <span class="badge badge-pill badge-warning notification">3</span>
      </a>
      <a href="#">
        <i class="fa fa-envelope"></i>
        <span class="badge badge-pill badge-success notification">7</span>
      </a>
      <a href="#">
        <i class="fa fa-cog"></i>
        <span class="badge-sonar"></span>
      </a> --}}
      <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
        <i class="fa fa-power-off"></i>
      </a>
      <form action="{{ route('logout') }}" method="POST" class="d-none" id="logout-form">@csrf</form>
    </div>
  </nav>
  <!-- sidebar-wrapper  -->
  <main class="page-content">
    <div class="card">
      <div class="card-body">
        @yield('body')
      </div>
    </div>
  </main>
</body>
  <script src="{{ asset('js1/jquery.js') }}"></script>
  <script src="{{ asset('js1/popper.js') }}"></script>
  <script src="{{ asset('js1/bootstrap.js') }}"></script>
  <script src="{{ asset('js1/toastr.js') }}"></script>
  <script src="{{ asset('js1/alert.js') }}"></script>

  <link rel="stylesheet" href="{{ asset('fontawesome-free-5.15.3-web/css/all.css') }}">
  <script src="{{ asset('js1/confirmarExclusao.js') }}"></script>
  
  <!--DataTable-->
  <script src="{{ asset('js1/dataTable/datatables.min.js') }}"></script>
  {{-- <script src="{{ asset('js1/dataTable/pdfmake.min.js') }}"></script>
  <script src="{{ asset('js1/dataTable/pdfmake_fonts.min.js') }}"></script>
  <script src="{{ asset('js1/dataTable/pdf_zip.min.js') }}"></script>
   --}}
  <script src="{{ asset('js1/mask.min.js') }}"></script>
  
  {{-- <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script> --}}
  {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script> --}}
  {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script> --}}
  {{-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/datatables.min.js"></script>  --}}
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script> --}}
<script>
toastr.options = {
    "progressBar": true,
    "closeButton": true,
}

$(function() {

  $(".sidebar-dropdown > a").click(function() {
    $(".sidebar-submenu").slideUp(200);
    if ($(this).parent().hasClass("active")) {
      $(".sidebar-dropdown").removeClass("active");
      $(this).parent().removeClass("active");
    } else {
      $(".sidebar-dropdown").removeClass("active");
      $(this).next(".sidebar-submenu").slideDown(200);
      $(this).parent().addClass("active");
    }
  });

  $("#close-sidebar").click(function() {
    $(".page-wrapper").removeClass("toggled");
  });
  $("#show-sidebar").click(function() {
    $(".page-wrapper").addClass("toggled");
  });

//   Disable search and ordering by default
  $.extend( $.fn.dataTable.defaults, {
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json"
    },
    dom: "<'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
    buttons: [
        'print', 'excel', 'pdf'
    ],
  });

});
</script>
@yield('script')

</html>