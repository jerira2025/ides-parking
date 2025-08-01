<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-12">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/ico" />

  <title>Gentelella Alela!</title>

  <!-- Bootstrap -->
  <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

  <!-- NProgress -->
  <link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">

  <!-- iCheck -->
  <link href="{{ asset('vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">

  <!-- Bootstrap Progressbar -->
  <link href="{{ asset('vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">

  <!-- JQVMap -->
  <link href="{{ asset('vendors/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet" />

  <!-- Daterangepicker -->
  <link href="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="{{ asset('build/css/custom.min.css') }}" rel="stylesheet">

  <link href="{{asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">



  <!-- Datatables -->
  <link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">

  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><i class="fa fa-tint"></i> <span>Parqueadero!</span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Usuario"
                class="img-circle profile_img" />
            </div>
            <div class="profile_info">
              <span>Bienvenido</span>
              <h2>{{ Auth::user()->name}}</h2>
            </div>
          </div>

          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>General</h3>
              @include('layouts.navigation') <!-- Aquí se carga la barra de navegación -->
            </div>

          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
          </div>
          <nav class="nav navbar-nav">
            <ul class=" navbar-right">
              @auth
              <li class="nav-item dropdown">
                <a class="dropdown-toggle info-number" href="#" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-bell-o"></i>
                  @php $count = auth()->user()->unreadNotifications->count(); @endphp
                  @if($count > 0)
                  <span class="badge bg-red">{{ $count }}</span>
                  @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-right list-unstyled msg_list" role="menu">
                  @forelse(auth()->user()->unreadNotifications as $notification)
                  <li class="nav-item">
                    <a class="dropdown-item">
                      <span class="image">
                        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Usuario" />
                      </span>
                      <span>
                        <span>{{ Auth::user()->name }}</span>
                        <span class="time">{{ $notification->created_at->diffForHumans() }}</span>
                      </span>
                      <span class="message">
                        {{ $notification->data['mensaje'] ?? 'Nueva notificación' }}
                      </span>
                    </a>
                  </li>
                  @empty
                  <li class="nav-item text-center text-muted py-2">Sin notificaciones</li>
                  @endforelse
                  <li class="nav-item text-center">
                    <form method="POST" action="{{ route('notificaciones.leer') }}">
                      @csrf
                      <button class="btn btn-sm btn-primary w-100">Marcar como leídas</button>
                    </form>
                  </li>
                </ul>
              </li>
              @endauth
              <li class="nav-item dropdown open" style="padding-left: 15px;">
                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown"
                  data-toggle="dropdown" aria-expanded="false">
                  <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Usuario">{{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="javascript:;"> Profile</a>
                  <a class="dropdown-item" href="javascript:;">
                    <span class="badge bg-red pull-right">50%</span>
                    <span>Settings</span>
                  </a>
                  <a class="dropdown-item" href="javascript:;">Help</a>
                  <a class="dropdown-item" href="#"
                    onclick="event.preventDefault();  document.getElementById('logout-form').submit();"><i
                      class="fa fa-sign-out pull-right"></i><span>Salir</span></a>

                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </li>

              {{--<li role="presentation" class="nav-item dropdown open">
                <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown"
                  aria-expanded="false">
                  <i class="fa fa-envelope-o"></i>
                  <span class="badge bg-green">6</span>
                </a>
                <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                  <li class="nav-item">
                    <a class="dropdown-item">
                      <span class="image">
                        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Usuario" />
                      </span>
                      <span>
                        <span>{{ Auth::user()->name}}</span>
                        <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="dropdown-item">
                      <span class="image">
                        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Usuario" />
                      </span>
                      <span>
                        <span>{{ Auth::user()->name}}</span>
                        <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="dropdown-item">
                      <span class="image">
                        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Usuario" />
                      </span>
                      <span>
                        <span>{{ Auth::user()->name}}</span>
                        <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="dropdown-item">
                      <span class="image">
                        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Usuario" />
                      </span>
                      <span>
                        <span>{{ Auth::user()->name}}</span>
                        <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <div class="text-center">
                      <a class="dropdown-item">
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                      </a>
                    </div>
                  </li>
                </ul>
              </li>--}}
            </ul>
          </nav>
        </div>
      </div>

      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">
        <!-- top tiles -->
        <div class="row" style="display: inline-block;">
          @yield('content')
        </div>
      </div>
      <!-- /page content -->

      <!-- footer content -->
      <footer>
        <div class="pull-right">
          Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
        </div>
        <div class="clearfix"></div>
      </footer>
      <!-- /footer content -->
    </div>
  </div>
  <!-- jQuery -->
  <script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>

  <!-- Bootstrap -->
  <script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

  <!-- FastClick -->
  <script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}"></script>

  <!-- NProgress -->
  <script src="{{ asset('vendors/nprogress/nprogress.js') }}"></script>

  <!-- Chart.js -->
  <script src="{{ asset('vendors/Chart.js/dist/Chart.min.js') }}"></script>

  <!-- gauge.js (si lo usas) -->
  <script src="{{ asset('vendors/gauge.js/dist/gauge.min.js') }}"></script>

  <!-- Bootstrap Progressbar -->
  <script src="{{ asset('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>

  <!-- iCheck -->
  <script src="{{ asset('vendors/iCheck/icheck.min.js') }}"></script>

  <!-- Skycons (íconos animados de clima, si los usas) -->
  <script src="{{ asset('vendors/skycons/skycons.js') }}"></script>

  <!-- Flot Charts (solo si los necesitas) -->
  <script src="{{ asset('vendors/Flot/jquery.flot.js') }}"></script>
  <script src="{{ asset('vendors/Flot/jquery.flot.pie.js') }}"></script>
  <script src="{{ asset('vendors/Flot/jquery.flot.time.js') }}"></script>
  <script src="{{ asset('vendors/Flot/jquery.flot.stack.js') }}"></script>
  <script src="{{ asset('vendors/Flot/jquery.flot.resize.js') }}"></script>
  <script src="{{ asset('vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
  <script src="{{ asset('vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
  <script src="{{ asset('vendors/flot.curvedlines/curvedLines.js') }}"></script>


  <!-- Flot Plugins -->
  <script src="{{ asset('vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
  <script src="{{ asset('vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
  <script src="{{ asset('vendors/flot.curvedlines/curvedLines.js') }}"></script>

  <!-- DateJS -->
  <script src="{{ asset('vendors/DateJS/build/date.js') }}"></script>

  <!-- JQVMap -->
  <script src="{{ asset('vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
  <script src="{{ asset('vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
  <script src="{{ asset('vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>

  <!-- Bootstrap Daterangepicker -->
  <script src="{{ asset('vendors/moment/min/moment.min.js') }}"></script>
  <script src="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

  <!-- Custom Theme Scripts -->
  <script src="{{ asset('build/js/custom.min.js') }}"></script>

  <script src="{{asset('vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
  <script src="{{asset('vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
  <script src="{{asset('vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
  <script src="{{asset('vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
  <script src="{{asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
  <script src="{{asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
  <script src="{{asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
  <script src="{{asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
  <script src="{{asset('vendors/jszip/dist/jszip.min.js')}}"></script>
  <script src="{{asset('vendors/pdfmake/build/pdfmake.min.js')}}"></script>
  <script src="{{asset('vendors/pdfmake/build/vfs_fonts.js')}}"></script>


  <script src="{{asset('vendors/switchery/dist/switchery.min.js')}}"></script>
  <!-- sweet alert -->

  <script src="{{asset('vendors/sweetalert/sweetalert.min.js')}}"></script>


  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#datatable-buttons').DataTable({
        responsive: true,
        language: {
          url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json'
        }
      });
    });
  </script>



</body>

</html>