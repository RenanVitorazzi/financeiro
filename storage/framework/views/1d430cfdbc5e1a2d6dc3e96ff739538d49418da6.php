<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $__env->yieldContent('title'); ?></title>
  <link rel="stylesheet" href="<?php echo e(asset('style.css')); ?>">
  
  <link rel="stylesheet" href="<?php echo e(asset('dataTable.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('navbar.css')); ?>">
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
<div class="page-wrapper chiller-theme">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
    <i class="fas fa-bars"></i>
  </a>
  
  <nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="<?php echo e(route('home')); ?>">
            Home
            
        </a>
        <div id="close-sidebar">
          <i class="fas fa-times"></i>
        </div>
      </div>
      
      <!-- sidebar-header  -->
      
      <!-- sidebar-search  -->
      <div class="sidebar-menu">
        <ul>
          
          <?php if(auth()->user()->is_admin): ?>        
          <li <?php if(route('fornecedores.index') == Request::url()): ?> class="ativo" <?php endif; ?>>
            <a href="<?php echo e(route('fornecedores.index')); ?>">
              <i class="fas fa-industry"></i>
              <span>Fornecedores</span>
            </a>
          </li>
          <li <?php if(route('parceiros.index') == Request::url()): ?> class="ativo" <?php endif; ?>>
            <a href="<?php echo e(route('parceiros.index')); ?>">
              
              <i class="fas fa-hands-helping"></i>
              <span>Parceiros</span>
            </a>
          </li>
          <li <?php if(route('representantes.index') == Request::url()): ?> class="ativo" <?php endif; ?>>
            <a href="<?php echo e(route('representantes.index')); ?>">
              <i class="fas fa-user-tie"></i>
              <span>Representantes</span>
            </a>
          </li>
          <?php endif; ?>
          <li <?php if(route('clientes.index') == Request::url()): ?> class="ativo" <?php endif; ?>>
            <a href="<?php echo e(route('clientes.index')); ?>">
              <i class="fas fa-users"></i>
              <span>Clientes</span>
            </a>
          </li>
          
          
          
          <li <?php if(route('estoque.index') == Request::url()): ?> class="ativo" <?php endif; ?>>
            <a href="<?php echo e(route('estoque.index')); ?>">
            <i class="fas fa-exchange-alt"></i>
              <span>Estoque</span>
            </a>
          </li>
          <?php if(auth()->user()->is_admin): ?>
          <li class="header-menu">
            <span>Financeiro</span>
          </li>
          <div class="sidebar-menu">
            <ul>
                <li <?php if(route('cheques.index') == Request::url()): ?> class="ativo" <?php endif; ?>>
                    <a href="<?php echo e(route('cheques.index')); ?>">
                      <i class="fas fa-wallet"></i>
                      <span>Carteira de cheques</span>
                    </a>
                </li>
                <li <?php if(route('troca_cheques.index') == Request::url()): ?> class="ativo" <?php endif; ?>>
                    <a href="<?php echo e(route('troca_cheques.index')); ?>">
                      <i class="fas fa-hand-holding-usd"></i>
                      <span>Troca de cheques</span>
                    </a>
                </li>
                <li <?php if(route('procura_cheque') == Request::url()): ?> class="ativo" <?php endif; ?>>
                    <a href="<?php echo e(route('procura_cheque')); ?>">
                      <i class="fas fa-search"></i>
                      <span>Procurar cheque</span>
                    </a>
                </li>
                <li <?php if(route('recebimentos.index') == Request::url()): ?> class="ativo" <?php endif; ?>>
                  <a href="<?php echo e(route('recebimentos.index')); ?>">
                  <i class="fas fa-exchange-alt"></i>
                    <span>Recebimentos</span>
                  </a>
                </li>
                <li <?php if(route('despesas.index') == Request::url()): ?> class="ativo" <?php endif; ?>>
                  <a href="<?php echo e(route('despesas.index')); ?>">
                    <i class="fas fa-money-bill"></i>
                    <span>Despesas</span>
                  </a>
                </li>
                <li <?php if(route('entrega_parcela.index') == Request::url()): ?> class="ativo" <?php endif; ?>>
                  <a href="<?php echo e(route('entrega_parcela.index')); ?>">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Entregar/Pegar cheques</span>
                  </a>
                </li>
                
                
            
            </ul>
        </div>
          
          <?php endif; ?>
          <?php if(auth()->user()->is_representante): ?>
            <li <?php if(route('venda.show', auth()->user()->is_representante) == Request::url()): ?> class="ativo" <?php endif; ?>>
                <a href="<?php echo e(route('venda.show', auth()->user()->is_representante)); ?>">
                <i class="fas fa-shopping-cart"></i>
                <span>Vendas</span>
                </a>
            </li>
            <li <?php if(route('conta_corrente_representante.show', auth()->user()->is_representante) == Request::url()): ?> class="ativo" <?php endif; ?>>
                <a href="<?php echo e(route('conta_corrente_representante.show', auth()->user()->is_representante)); ?>">
                <i class="fas fa-balance-scale"></i>
                <span>Conta Corrente</span>
                </a>
            </li>
            <li <?php if(route('cheques.index') == Request::url()): ?> class="ativo" <?php endif; ?>>
                <a href="<?php echo e(route('cheques.index')); ?>">
                <i class="fas fa-money-check-alt"></i>
                <span>Carteira de cheques</span>
                </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
      <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
    <div class="sidebar-footer">
      
      <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
        <i class="fa fa-power-off"></i>
      </a>
      <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-none" id="logout-form"><?php echo csrf_field(); ?></form>
    </div>
  </nav>
  <!-- sidebar-wrapper  -->
  <main class="page-content">
    <div class="card">
      <div class="card-body">
        <?php echo $__env->yieldContent('body'); ?>
      </div>
    </div>
  </main>
</body>
  <script src="<?php echo e(asset('js1/jquery.js')); ?>"></script>
  <script src="<?php echo e(asset('js1/popper.js')); ?>"></script>
  <script src="<?php echo e(asset('js1/bootstrap.js')); ?>"></script>
  <script src="<?php echo e(asset('js1/toastr.js')); ?>"></script>
  <script src="<?php echo e(asset('js1/alert.js')); ?>"></script>

  <link rel="stylesheet" href="<?php echo e(asset('fontawesome-free-5.15.3-web/css/all.css')); ?>">
  <script src="<?php echo e(asset('js1/confirmarExclusao.js')); ?>"></script>
  
  <!--DataTable-->
  <script src="<?php echo e(asset('js1/dataTable/datatables.min.js')); ?>"></script>
  
  <script src="<?php echo e(asset('js1/mask.min.js')); ?>"></script>
  
  
  
  
  
  
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
<?php echo $__env->yieldContent('script'); ?>

</html><?php /**PATH C:\Users\CAIXA\Desktop\financeiro\resources\views/layout.blade.php ENDPATH**/ ?>