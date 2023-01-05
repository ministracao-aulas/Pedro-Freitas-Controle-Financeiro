@php
    $user = \Auth::user(); // TODO: fazer vir da controller
@endphp
<!DOCTYPE html>
<html lang="pt-br">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Hugo Vasconcelos">

        <title>@yield('title')</title>

        <!-- Custom fonts for this template-->
        <link href="{{URL::asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="{{URL::asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
        <link href="{{URL::asset('css/style.css')}}" rel="stylesheet">

        <link href="{{URL::asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">


        <!-- Bootstrap core JavaScript-->
        <script src="{{URL::asset('vendor/jquery/jquery.min.js')}}"></script>
        <script src="{{URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

         <link rel="shortcut icon" href="{{URL::asset('/favicon.ico')}}" type="image/x-icon">
    <link rel="icon" href="{{URL::asset('/favicon.ico')}}" type="image/x-icon">

    </head>

    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="navbar-nav bg-lilas sidebar sidebar-dark accordion" id="accordionSidebar">

                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin.index')}}">

                    <div class="sidebar-brand-text mx-3">Administrador</div>
                </a>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">



                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Cadastros
                </div>



                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-users"></i>
                        <span>Colaboradores</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">TIPO DE ACESSO:</h6>
                            <a class="collapse-item" href="{{route('cadastropag.index')}}">Cadastro</a>
                            <a class="collapse-item" href="">Baixa</a>
                        </div>
                    </div>
                </li>

                <!-- Nav Item - Utilities Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-home"></i>
                        <span>Pagamentos</span>
                    </a>
                    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Pagamentos:</h6>
                            <a class="collapse-item" href="{{route('pagfixo.index')}}">Pagamento Fixo</a>
                            <a class="collapse-item" href="">Pagamento Variavel</a>
                            <a class="collapse-item" href="">Extras</a>

                        </div>
                    </div>


                </li>

                <!-- Nav Item - Meses -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTree" aria-expanded="true" aria-controls="collapseTree">
                        <i class="fas fa-users"></i>
                        <span>Meses</span>
                    </a>
                    <div id="collapseTree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="">Janeiro</a>
                            <a class="collapse-item" href="">Fevereiro</a>
                            <a class="collapse-item" href="">Março</a>
                            <a class="collapse-item" href="">Abril</a>
                            <a class="collapse-item" href="">Maio</a>
                            <a class="collapse-item" href="">Junho</a>
                            <a class="collapse-item" href="">Julho</a>
                            <a class="collapse-item" href="">Agosto</a>
                            <a class="collapse-item" href="">Setembro</a>
                            <a class="collapse-item" href="">Outubro</a>
                            <a class="collapse-item" href="">Novembro</a>
                            <a class="collapse-item" href="">Dezembro</a>

                        </div>
                    </div>
                </li>



                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Consultas
                </div>



                <!-- Nav Item - Charts -->
                <li class="nav-item">
                    <a class="nav-link" href="{{route('calendario.index')}}">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>Calendario de Pagamentos</span></a>
                </li>



                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>

            </ul>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-lilas-top topbar mb-4 static-top shadow">

                        <!-- Sidebar Toggle (Topbar) -->
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>



                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">



                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-200 small">{{ $user->name }}</span>
                                    <img class="img-profile rounded-circle" src="{{URL::asset('img/perfil.png')}}">

                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#ModalPerfil">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-primary"></i>
                                        Editar Perfil
                                    </a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{route('logout')}}">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i>
                                        Sair
                                    </a>
                                </div>
                            </li>

                        </ul>

                    </nav>
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        @yield('content')


                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->



            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>




        <!--  Modal Perfil-->
        <div class="modal fade" id="ModalPerfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Perfil</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>



                    <form id="form-perfil" method="POST" action="{{route('admin.editar', $user->id)}}">
                    @csrf
                    @method('put');
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input value="{{$user->name}}" type="text" class="form-control" id="name" name="name" placeholder="Nome">
                                    </div>

                                    <div class="form-group">
                                        <label>CPF</label>
                                        <input value="{{$user->cpf}}" type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF">
                                    </div>

                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <input value="{{$user->email}}" type="email" class="form-control" id="email" name="email" placeholder="email">
                                    </div>

                                    <div class="form-group">
                                        <label>
                                            Senha
                                            <em class="text-muted">Deixe em branco se não quiser alterar a senha</em>
                                        </label>
                                        <input value="" type="password" class="form-control" id="text" name="password" placeholder="Senha">
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="modal-footer">

                            <button type="button" id="btn-fechar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" name="btn-salvar-perfil" id="btn-salvar-perfil" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>


        <!-- Core plugin JavaScript-->
        <script src="{{URL::asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{URL::asset('js/sb-admin-2.min.js')}}"></script>

        <!-- Page level plugins -->
        <script src="{{URL::asset('vendor/chart.js/Chart.min.js')}}"></script>

        <!-- Page level custom scripts -->
        <script src="{{URL::asset('js/demo/chart-area-demo.js')}}"></script>
        <script src="{{URL::asset('js/demo/chart-pie-demo.js')}}"></script>

        <!-- Page level plugins -->
        <script src="{{URL::asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{URL::asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

        <!-- Page level custom scripts -->
        <script src="{{ URL::asset('js/demo/datatables-demo.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
        <script src="{{ URL::asset('js/demo/mascara.js') }}"></script>


    </body>

</html>
