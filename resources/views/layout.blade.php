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

</head>
<body>
<div class="page-wrapper chiller-theme toggled">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
    <i class="fas fa-bars"></i>
  </a>
  <nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="#">dl metais</a>
        {{-- <div id="close-sidebar">
          <i class="fas fa-times"></i>
        </div> --}}
      </div>
      {{-- <div class="sidebar-header">
        <div class="user-pic">
          <img class="img-responsive img-rounded" src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg"
            alt="User picture">
        </div>
        <div class="user-info">
          <span class="user-name">Jhon
            <strong>Smith</strong>
          </span>
          <span class="user-role">Administrator</span>
          <span class="user-status">
            <i class="fa fa-circle"></i>
            <span>Online</span>
          </span>
        </div>
      </div> --}}
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
          <li class="header-menu">
            <span>General</span>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-tachometer-alt"></i>
              <span>Cadastros</span>
              {{-- <span class="badge badge-pill badge-warning">New</span> --}}
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="{{ route('fornecedores.index') }}">Fornecedores</a>
                </li>
                <li>
                  <a href="{{ route('representantes.index') }}">Representantes</a>
                </li>
                <li>
                  <a href="{{ route('clientes.index') }}">Clientes</a>
                </li>
                <li>
                  <a href="{{ route('parceiros.index') }}">Parceiros</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-shopping-cart"></i>
              <span>Fornecedores</span>
              {{-- <span class="badge badge-pill badge-danger">3</span> --}}
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Products</a>
                </li>
                <li>
                  <a href="#">Orders</a>
                </li>
                <li>
                  <a href="#">Credit cart</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="far fa-gem"></i>
              <span>Components</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">General</a>
                </li>
                <li>
                  <a href="#">Panels</a>
                </li>
                <li>
                  <a href="#">Tables</a>
                </li>
                <li>
                  <a href="#">Icons</a>
                </li>
                <li>
                  <a href="#">Forms</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-chart-line"></i>
              <span>Charts</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Pie chart</a>
                </li>
                <li>
                  <a href="#">Line chart</a>
                </li>
                <li>
                  <a href="#">Bar chart</a>
                </li>
                <li>
                  <a href="#">Histogram</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-globe"></i>
              <span>Maps</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Google maps</a>
                </li>
                <li>
                  <a href="#">Open street map</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="header-menu">
            <span>Extra</span>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-book"></i>
              <span>Documentation</span>
              {{-- <span class="badge badge-pill badge-primary">Beta</span> --}}
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-calendar"></i>
              <span>Calendar</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-folder"></i>
              <span>Examples</span>
            </a>
          </li>
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
      <a href="#">
        <i class="fa fa-power-off"></i>
      </a>
    </div>
  </nav>
  <!-- sidebar-wrapper  -->
  <main class="page-content">
    @yield('body')
  </main>
  <script src="{{ asset('js/jquery.js') }}"></script>
  <script src="{{ asset('js/bootstrap.js') }}"></script>
  {{-- <script src="{{ asset('js/dataTable.js') }}"></script> --}}

  <script src="https://kit.fontawesome.com/609d32acbf.js" crossorigin="anonymous"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  <!--DataTable-->
  <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/datatables.min.js"></script> --}}
 
<script>
jQuery(function ($) {

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

  // Disable search and ordering by default
  $.extend( $.fn.dataTable.defaults, {
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json"
    },
    dom: "<'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
    buttons: [ 
      {
        extend: 'excel',
        className: "btn-dark",
        text: 'Excel',
        exportOptions: {
          columns: [ 0, 1, 2, 3 ],
          trim: true,
          format: {
            body: function ( data, row, column, node ) {
              return $(node).text().trim();
            }
          }
        },
        customize: function(xlsx) {
          var sheet = xlsx.xl.worksheets['sheet1.xml'];
          $('row c', sheet).each( function () {
              $(this).attr( 's', '55' );
          });
        }
      },
      {
        extend: 'pdf',
        className: "btn-dark",
        exportOptions: {
          columns: [ 0, 1, 2, 3 ],
          format: {
            body: function ( data, row, column, node ) {
                data = data
                .replace(/<.*?>/g, "");
                return data;
            }
          },
          stripHtml:      true,
          stripNewlines:  true,
          decodeEntities: false,
          trim:           true,
        }, 
        customize : function(doc){
          var colCount = new Array();
          $('.table').find('tbody tr:first-child td').each(function(){
            if($(this).attr('colspan')){
              for(var i=1;i<=$(this).attr('colspan');$i++){
                  colCount.push('*');
              }
            }else{ colCount.push('*'); }
          });
          colCount.splice(-1,1)
          doc.content[1].table.widths = colCount;
        },
      },
      {
        extend: 'print',
        className: "btn-dark",
        text: 'Imprimir',
        exportOptions: {
          columns: [ 0, 1, 2, 3 ],
          stripHtml: false
        }
      }
    ]
  });

});
</script>
@stack('script')
</body>
</html>