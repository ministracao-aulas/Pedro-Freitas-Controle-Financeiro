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
    {{-- <link href="{{ URL::asset('vendor/fontawesome-free/5.10.2/css/all.min.css') }}" rel="stylesheet" type="text/css"> --}}
    <link href="{{ URL::asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ URL::asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    {{-- <link href="{{ URL::asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> --}}

    <!-- Bootstrap core JavaScript-->
    <script src="{{ URL::asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <link rel="shortcut icon" href="{{ URL::asset('/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ URL::asset('/favicon.ico') }}" type="image/x-icon">

    @vite([
        'resources/css/app.css',
        'resources/css/blocks/custom-tooltip.scss',
        'resources/js/app.js',
        'resources/js/customization.js',
    ])

    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">

    @include('_includes.global-app-data')

    @yield('before_head_end')

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body id="page-top" x-data="pageData" class="sidebar-toggled">

    <div class="d-none" x-data="{}"></div>

    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('layouts.sb-admin-2._includes.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div
                    class="container-fluid content-container"
                    data-element-name="content-container"
                    x-data="contentData"
                >
                    @include('_includes.error-messages')

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

                <form id="form-perfil" method="POST" action="{{ route('admin.usuarios.edit', $user->id) }}">
                    @csrf
                    @method('put');
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input value="{{ $user->name }}" type="text" class="form-control" id="name"
                                        name="name" placeholder="Nome">
                                </div>

                                <div class="form-group">
                                    <label>CPF</label>
                                    <input value="{{ $user->cpf }}" type="text" class="form-control" id="cpf"
                                        name="cpf" placeholder="CPF">
                                </div>

                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input value="{{ $user->email }}" type="email" class="form-control" id="email"
                                        name="email" placeholder="email">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Senha
                                        <em class="text-muted">Deixe em branco se não quiser alterar a senha</em>
                                    </label>
                                    <input value="" type="password" class="form-control" id="text" name="password"
                                        placeholder="Senha">
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
    <script src="{{ URL::asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    {{-- <script src="{{ URL::asset('js/sb-admin-2.min.js') }}"></script> --}}

    <!-- Page level plugins -->
    <!-- <script src="{{ URL::asset('vendor/chart.js/Chart.min.js') }}"></script> -->

    <!-- Page level custom scripts -->
    <!-- <script src="{{ URL::asset('js/demo/chart-area-demo.js') }}"></script> -->
    <!-- <script src="{{ URL::asset('js/demo/chart-pie-demo.js') }}"></script> -->

    <!-- Page level plugins -->
    {{-- <script src="{{ URL::asset('vendor/datatables/jquery.dataTables.min.js') }}"></script> --}}
    {{-- <script src="{{ URL::asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}

    <!-- Page level custom scripts -->
    {{-- <!-- <script src="{{ URL::asset('js/demo/datatables-demo.js') }}"></script> --> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    <!-- <script src="{{ URL::asset('js/demo/mascara.js') }}"></script> -->

    <script src="{{ asset('js/libs/tiagof2/DotObject/dot-object.js') }}"></script>
    <!-- BEGIN TypeChecker and data-actions -->
    <!-- TypeChecker must be loaded before data-actions -->
    <script src="{{ asset('js/libs/tiagof2/TypeChecker/TypeChecker.js') }}"></script>
    <script src="{{ asset('js/libs/tiagof2/data-actions/data-actions.js') }}"></script>
    <!-- END TypeChecker and data-actions -->

    <script src="{{ asset('js/search/search.js') }}"></script>
    @hasSection ('alpine_page_data')
        @yield('alpine_page_data')
    @else
    <script>
        window.initialAlpineContentData = {};
    </script>
    @endif

    <script>
        window.__preferenceCallStatic = (staticMethod, ...params) => {
            if (
                !staticMethod ||
                (staticMethod?.constructor?.name != 'String') ||
                !window.__preferences ||
                !('callStatic' in window.__preferences)
            ) {
                console.log('Error on "staticMethod"', staticMethod);
                return;

            }

            return window.__preferences.callStatic(staticMethod, ...params);
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('pageData', () => {
                return {
                    sidebarIsOpen: (__preferences.callStatic('getSidebarMode', 'expand') == 'expand'),

                    toggleSidebar() {
                        __preferences.callStatic('toggleSidebarMode');
                    },
                }
            });

            window.initialAlpineContentData = window.initialAlpineContentData || {};
            Alpine.data('contentData', () => (window.initialAlpineContentData));
        })
    </script>
    @yield('before_body_end')
</body>

</html>
