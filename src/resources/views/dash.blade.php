<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/icon.png?v=2.2.2')}}" />
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png?v=2.2.2')}}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        MobSystem
    </title>
    <meta name="description" content="Empresa especializada em soluções mobile, aplicativos sob medida para o seu negócio" />
    <meta name="keywords" content="MobSystem" />
    <meta name="author" content="MobSystem" />
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no" name="viewport" />

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />

    <!-- CSS Files -->
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('css/planos-card.css?v=2.2.7')}}" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/new-age.css?v=2.2.2')}}" rel="stylesheet" />
    <link href="{{ asset('css/paper-kit.css?v=2.2.4')}}" rel="stylesheet" />

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="{{ asset('device-mockups/device-mockups.min.css?v=2.2.2')}}" />

    <link rel="stylesheet" href="{{ asset('vendor/simple-line-icons/css/simple-line-icons.css?v=2.2.2')}}" />
    <!--     Fonts and icons     -->
    <!-- <script type="module" src="{{ asset('js/dist/app.js') }}"></script> -->
</head>

<body class="landing-page sidebar-collapse" id="home">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-transparent" color-on-scroll="100">
        <div class="container">
            <div class="navbar-translate">
                <a class="navbar-brand" href="https://www.mobsystem.com.br" rel="tooltip" title="MobSystem" data-placement="bottom">
                    <img height="60" src="{{ asset('images/logo_app_loja.png')}}" />
                </a>
                <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="#home" class="nav-link js-scroll-trigger">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#features" class="nav-link js-scroll-trigger">Produto</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="#planos" class="nav-link js-scroll-trigger"> Planos</a>
                    </li> -->

                    <li class="nav-item">
                        <a href="#contato" class="nav-link js-scroll-trigger">
                            Contato</a>
                    </li>
                    <!-- <li class="nav-item social-item" style="width: 25px;">
                        <a class="nav-link" rel="tooltip" title="Like us on Facebook" data-placement="bottom" href="#">
                            <i class="fa fa-facebook-square"></i>
                            <p class="d-lg-none">Facebook</p>
                        </a>
                    </li>
                    <li class="nav-item social-item" style="width: 25px;">
                        <a class="nav-link rede-social" rel="tooltip" title="Follow us on Instagram"
                            data-placement="bottom" href="#">
                            <i class="fa fa-instagram"></i>
                            <p class="d-lg-none">Instagram</p>
                        </a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="page-header" data-parallax="false" style="background-image: url('{{asset("images/img_part02.png")}}')">
        <!-- <img class="banner-background" src="{{asset("images/img_part02.png")}}"/> -->
        <div class="container">
            <div class="container">
                <div class="row text-home text-center text-md-left">
                    <div class="col-12  col-lg-6">
                        <h1 class="m-0">Conheça o MobAPP</h1>
                        <h3 class="m-0">MobAPP é um aplicativo de E-commerce sob medida para sua loja com 100% de mobilidade para o seu negócio.</h3>
                        <br />
                        <a href="#contato" class="nav-link js-scroll-trigger text-center">
                            <button type="button" class="btn btn-outline-neutral btn-round">
                                Quero Testar
                            </button>
                        </a>

                    </div>
                    <div class="col-12  col-lg-6">
                        <img class="banner-home" src="{{asset("images/img_part01.png?v=2.2.3")}}" />
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="main">
        <div class="section text-center">
            <section class="features" id="features">
                <div class="container">
                    <div class="section-heading text-center">
                        <h2>Preços exclusivos de lançamento</h2>
                        <p class="text-muted">
                            Solicite uma consultoria e comece a vender agora!!!
                        </p>
                        <hr />
                    </div>
                    <div class="row">
                        <div class="col-lg-4 my-auto">
                            <div class="device-container">
                                <div class="device-mockup mobile_mockup">
                                    <div class="device">
                                        <div class="screen">
                                            <!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
                                            <!-- <img src="{{ asset('images/tela_app.jpeg')}}" class="img-fluid" alt="" />-->
                                        </div>
                                        <div class="button">
                                            <!-- You can hook the "home button" to some JavaScript events or just remove it -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 my-auto">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="feature-item">
                                            <i class="icon-basket-loaded text-item-feature"></i>
                                            <h3>Vendas Online</h3>
                                            <p class="text-muted">
                                                Disponibilize a opção de compra
                                                online para os seus clientes
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="feature-item">
                                            <i class="icon-screen-smartphone text-item-feature"></i>
                                            <h3>App Exclusivo</h3>
                                            <p class="text-muted">
                                                Aplicativo com designer elegante personalizado para a sua empresa
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="feature-item">
                                            <i class="icon-credit-card text-item-feature"></i>
                                            <h3>Cartão de Crédito</h3>
                                            <p class="text-muted">
                                                Deixe seus clientes pagarem com
                                                cartão de crédito.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="feature-item">
                                            <i class="icon-map text-item-feature"></i>
                                            <h3>Entregas</h3>
                                            <p class="text-muted">
                                                Gerencie seus pedidos e entregas
                                                notificando seus clientes a cada
                                                passo.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        </div>

        <!-- <div class="section section-dark text-center" id="planos">
            <div class="container">
                <h2 class="title">Conheça nossos planos</h2>

                <div class="bgCards w-100">
                    <div class="row">
                        <div class="col-12 col-lg-4 text-right">
                            <div class="card">
                                <div class="cardHeader">
                                    <div class="plan-type">
                                        MobAPP
                                    </div>
                                    <div class="tease-type">
                                        Pague apenas o aplicativo.
                                    </div>
                                </div>
                                <div class="cardBody">
                                    <div class="plan-price">
                                        R$ 1.000,00<span></span>
                                    </div>
                                    <ul>
                                        <li> <i class="icon-action-redo text-item-check"></i> Venda</li>
                                        <li> <i class="icon-action-redo text-item-check"></i> Pagamento com cartão de
                                            crédito</li>
                                        <li> <i class="icon-action-redo text-item-check"></i> Sistema de notificações
                                        </li>
                                        <li> <i class="icon-action-redo text-item-check"></i> Gerenciamento de estoque
                                        </li>
                                        <li> <i class="icon-action-redo text-item-check"></i> Gerenciamento de produtos
                                        </li>
                                        <li> <i class="icon-action-redo text-item-check"></i> Acompanhamento e
                                            gerenciamento de pedidos em tempo real</li>
                                        <li> <i class="icon-action-redo text-item-check"></i> Módulo admin incluso
                                            direto no app</li>
                                            <li class=""> <i class="icon-close text-danger"></i> Suporte e atualização</li>
                                    </ul>
                                </div>
                                <div class="cardFooter text-center">
                                    <a href="#contato" class="nav-link js-scroll-trigger">
                                        <button class="btn-block">
                                            Contrate Agora
                                        </button>
                                    </a>
                                    <!- <span>*Todos os nossos planos podem ser negociados, entre em contato conosco e envie
                                        sua proposta</span> ->
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 text-right">
                            <div class="card">
                                <div class="cardHeader">
                                    <div class="plan-type">
                                        MENSALIDADE
                                    </div>
                                    <div class="tease-type">
                                        Pague um valor fixo independente de suas vendas.
                                    </div>
                                </div>
                                <div class="cardBody">
                                    <div class="plan-price">
                                        R$ 79,99<span>/mês</span>
                                    </div>
                                    <ul>
                                        <li> <i class="icon-action-redo text-item-check"></i> Venda</li>
                                        <li> <i class="icon-action-redo text-item-check"></i> Pagamento com cartão de
                                            crédito</li>
                                        <li> <i class="icon-action-redo text-item-check"></i> Sistema de notificações
                                        </li>
                                        <li> <i class="icon-action-redo text-item-check"></i> Gerenciamento de estoque
                                        </li>
                                        <li> <i class="icon-action-redo text-item-check"></i> Gerenciamento de produtos
                                        </li>
                                        <li> <i class="icon-action-redo text-item-check"></i> Acompanhamento e
                                            gerenciamento de pedidos em tempo real</li>
                                        <li> <i class="icon-action-redo text-item-check"></i> Módulo admin incluso
                                            direto no app</li>
                                            <li> <i class="icon-action-redo text-item-check"></i> Suporte e atualização</li>
                                    </ul>
                                </div>
                                <div class="cardFooter text-center">
                                    <a href="#contato" class="nav-link js-scroll-trigger">
                                        <button class="btn-block">
                                            Contrate Agora
                                        </button>
                                    </a>
                                    <!- <span>*Todos os nossos planos podem ser negociados, entre em contato conosco e envie
                                        sua proposta</span> ->
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 text-left">
                            <div class="card">
                                <div class="cardHeader">
                                    <div class="plan-type">
                                        PORCENTAGEM
                                    </div>
                                    <div class="tease-type">
                                        Pague apenas quando vender
                                    </div>
                                </div>
                                <div class="cardBody">
                                    <div class="plan-price">
                                        TAXA 5%<span>/por pedido</span>
                                    </div>
                                    <ul>
                                        <li> <i class="icon-action-redo text-item-check"></i> Venda</li>
                                        <li> <i class="icon-action-redo text-item-check"></i> Pagamento com cartão de
                                            crédito</li>
                                        <li> <i class="icon-action-redo text-item-check"></i> Sistema de notificações
                                        </li>
                                        <li> <i class="icon-action-redo text-item-check"></i> Gerenciamento de estoque
                                        </li>
                                        <li> <i class="icon-action-redo text-item-check"></i> Gerenciamento de produtos
                                        </li>
                                        <li> <i class="icon-action-redo text-item-check"></i> Acompanhamento e
                                            gerenciamento de pedidos em tempo real</li>
                                        <li> <i class="icon-action-redo text-item-check"></i> Módulo admin incluso
                                            direto no app</li>
                                            <li> <i class="icon-action-redo text-item-check"></i> Suporte e atualização</li>
                                    </ul>
                                </div>
                                <div class="cardFooter text-center">
                                    <a href="#contato" class="nav-link js-scroll-trigger">
                                        <button class="btn-block">
                                            Contrate Agora
                                        </button>
                                    </a>
                                    <!- <span>*Todos os nossos planos podem ser negociados, entre em contato conosco e envie
                                        sua proposta</span> ->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div> -->
        <div class="section landing-section" id="contato">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 ml-auto mr-auto">
                        <h2 class="text-center">
                            Não perca mais tempo, entre em contato conosco e alavanque suas vendas com o MobApp!!!
                        </h2>
                        <form class="contact-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Nome</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="icon-user"></i>
                                            </span>
                                        </div>
                                        <input id="nome" required type="text" class="form-control" placeholder="Nome" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Celular</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class=" icon-call-out"></i>
                                            </span>
                                        </div>
                                        <input required id="telefone" type="text" class="form-control" placeholder="(99) 99999-9999" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Email</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class=" icon-envelope"></i>
                                            </span>
                                        </div>
                                        <input id="email" required type="text" class="form-control" placeholder="Email" />
                                    </div>
                                </div>
                            </div>
                            <label>Mensagem</label>
                            <textarea id="mensagem" required class="form-control" rows="4" placeholder="Fale um pouco sobre o seu negócio ou idéia e entraremos em contato."></textarea>
                            <div class="row">
                                <div class="col-12 ml-auto mr-auto div-btn-send-mail">
                                    <button onclick="sendMenssageSite(); return false;" class="btn btn-lg btn-fill btn-send-mail">
                                        Enviar mensagem
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="container">
            <p>&copy; MobSytem 2020. All Rights Reserved.</p>
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="#">Whatsapp (84) 99695-1014</a>
                </li>
                <li class="list-inline-item">
                    <a href="#">E-mail admin@mobsystem.com.br</a>
                </li>
                <!-- <li class="list-inline-item">
                  <a href="#">FAQ</a>
                </li> -->
            </ul>
        </div>
    </footer>
    <a href="https://api.whatsapp.com/send?1=pt_BR&amp;phone=5584996951014" class="whatsapp-float" target="_blank">
        <!-- <i class="fab fa-whatsapp whatsapp-btn-float" aria-hidden="true"></i> -->
        <img height="63" src="{{ asset('images/icon-whats.png')}} " />
    </a>

    <!--   Core JS Files   -->
    <script src="{{ asset('js/core/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/core/popper.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/core/bootstrap.min.js')}}" type="text/javascript"></script>
    <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="{{ asset('js/plugins/bootstrap-switch.js')}}"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="{{ asset('js/plugins/nouislider.min.js')}}" type="text/javascript"></script>
    <!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
    <script src="{{ asset('js/plugins/moment.min.js')}}"></script>
    <script src="{{ asset('js/plugins/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <!-- Control Center for Paper Kit: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('js/paper-kit.js?v=2.2.2')}}" type="text/javascript"></script>
    <!-- Plugin JavaScript -->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>


    <!-- Custom scripts for this template -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="http://localhost:8000/js/vanillaMasker/vanilla-masker.js?v=2.2.2"></script>
    <script src="{{ asset('js/new-age.js?v=2.2.2')}}"></script>
    <script src="{{ asset('js/landpage.js?v=2.2.3')}}"></script>
</body>

</html>
