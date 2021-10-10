<?php
session_start();
if(empty($_SESSION['id'])){
  $_SESSION['msg'] = "<div class='alert alert-danger'>Área restrita!</div>";
  header("Location:/gestlog/pages/home.php");  
}elseif ( isset( $_SESSION["sessiontime"] ) ) { 
      if ($_SESSION["sessiontime"] < time() ) { 
        header("Location:/gestlog/pages/tela_bloqueio.php");               
        //Redireciona para login
      } else {
        //Seta mais tempo 60 segundos
        $_SESSION["sessiontime"] = time() + 150;
      }
} else { 
  session_unset();
  //Redireciona para login
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" http-equiv="pragma"content="no-cache">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>GEst Log | Cadastrar</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
       <!-- icone-->
  <link rel="sortcut icon" href="../img/icon.png" type="image/x-icon">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="../bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- Adicionando JQuery busca cep-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>

    <!-- Adicionando Javascript -->
    <script type="text/javascript" >

        $(document).ready(function() {

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");
                $("#ibge").val("");
            }
            
            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");
                        $("#ibge").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#rua").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                                $("#ibge").val(dados.ibge);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });
      //fim do busca cep
    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="inicio.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>G</b>Lg</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Gest</b> Log</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="../dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="../dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="../dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="../dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Create a nice theme
                        <small class="pull-right">40%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">40% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Some task I need to do
                        <small class="pull-right">60%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Make beautiful transitions
                        <small class="pull-right">80%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">80% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['nome'];?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  Alexander Pierce - Web Developer
                  <small>Member since Nov. 2012</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="bloqueio.php" class="btn btn-default btn-flat">Bloquear</a>
                </div>
                <div class="pull-right">
                  <a href="../php/sair.php" class="btn btn-default btn-flat">Sair</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Bem-Vindo <?php echo $_SESSION['nome'];?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Procurar...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU PRINCIPAL</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-cart"></i>
            <span>Vendas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <!--neste menu -->
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Vendedores</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Dia</a></li>
          </ul>
        </li>
        <li>
          <a href="pages/widgets.html">
            <i class="fa fa-th"></i> <span>Estoque</span>
          </a>
        </li>
        <li>
          <a href="calendario.php">
            <i class="fa fa-calendar"></i> <span>Calendário</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
          </a>
        </li>
        <li>
          <a href="email/email.php">
            <i class="fa fa-envelope"></i> <span>Caixa de E-Mail</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-bar-chart"></i>
            <span>Balanço</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> Matéria Prima</a></li>
            <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Produzido</a></li>
            <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Vendido</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-leanpub"></i> <span>Portfólio</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> Matéria-Prima</a></li>
            <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Produto</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Financeiro</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Ativos</a></li>
            <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Passivos</a></li>
          </ul>
        </li>
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Cadastro</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="cadastro_fun.php"><i class="fa fa-circle-o"></i> Funcionário</a></li>
            <li><a href="cadastro_cli.php"><i class="fa fa-circle-o"></i> Cliente</a></li>
            <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Revendedor</a></li>
            <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Receita</a></li>
          </ul>
        </li>
        <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentação</span></a></li>
        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Cadastro
        <small>Cliente</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
         <li class="active">Cadastro/Cliente</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Main row -->
      <div class="row">
        <section class="col-lg-12">
          <!-- Aqui Inicia-->
         <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#dados_pessoais" aria-controls="home" data-toggle="tab">Dados Pessoais</a></li>
            <li><a href="#profissao" aria-controls="profissao" data-toggle="tab">Dados Profissionais</a></li>
          </ul>
          <!--conteudo abas-->
          <div class="tab-content">
            <!--conteudo aba dados pessoais-->
            <div role="tabpanel" class="tab-pane active" id="dados_pessoais">
              <div style="padding-top:10px;">
                <form action="" method="POST">
                  <!--matricula-->
                  <div class="form-group row">
                    <label class="col-md-1">Matricula:</label>
                    <div class="col-md-2">
                      <input type="text-red" value="" name="matricula" disabled/>
                    </div>
                  </div>

                  <!--nome-->
                  <div class="row">
                    <h4 class="col-md-4">Nome</h4>
                  </div>

                  <div class="form-group row">
                    <label class="col-md-1">Nome:</label>  
                      <div class="col-md-5">
                        <input type="text" name="nome" class="form-control input-md" required autofocus />
                      </div>
                    <label class="col-md-1">Nome Fantasia:</label>  
                      <div class="col-md-5">
                        <input type="text" name="fantasia" class="form-control input-md"/>
                      </div>  
                  </div>
                  <div class="form-group row">
                    <label class="col-md-1">Tipo:</label>  
                    <div class="col-md-4">
                      <select class="form-control select2" style="width: 50%;" name="tipo" required>
                        <option value="pessoa fisica">Pessoa Física</option>
                        <option value="pessoa juridica">Pessoa Juridica</option>
                      </select>
                    </div>
                  </div>
                  <!--filiação-->

                  <!--documentos-->
                  <div class="row">
                    <h4 class="col-md-4">Documentação</h4>
                  </div>

                  <div class="form-group row">
                    <label class="col-md-1">CNPJ:</label>  
                    <div class="col-md-2">
                      <input name="cpf" placeholder="Apenas números" class="form-control input-md" required type="text" maxlength="11" pattern="[0-9]+$"/>
                    </div>  
                    <label class="col-md-1">Identidade:</label>  
                    <div class="col-md-3">
                      <input name="identidade" placeholder="Apenas números" class="form-control input-md" required type="text" maxlength="20" pattern="[0-9]+$"/>
                    </div>
                    <label class="col-md-1">Orgão Emissor:</label>  
                    <div class="col-md-1">
                      <input name="ident_emissor" class="form-control input-md" required type="text"/>
                    </div>
                    <label class="col-md-1">UF:</label>  
                    <div class="col-md-2">
                      <select class="form-control select2" style="width: 50%;" name="ident_uf" required>
                        <option selected="selected" value="1">AC</option>
                        <option value="2">AL</option>
                        <option value="3">AM</option>
                        <option value="4">AP</option>
                        <option value="5">BA</option>
                        <option value="6">CE</option>
                        <option value="7">DF</option>
                        <option value="8">ES</option>
                        <option value="9">GO</option>
                        <option value="10">MA</option>
                        <option value="11">MG</option>
                        <option value="12">MS</option>
                        <option value="13">MT</option>
                        <option value="14">PA</option>
                        <option value="15">PB</option>
                        <option value="16">PE</option>
                        <option value="17">PI</option>
                        <option value="18">PR</option>
                        <option value="19">RJ</option>
                        <option value="20">RN</option>
                        <option value="21">RO</option>
                        <option value="22">RR</option>
                        <option value="23">RS</option>
                        <option value="24">SC</option>
                        <option value="25">SE</option>
                        <option value="26">SP</option>
                        <option value="27">TO</option>
                      </select>
                      <!--<input name="uf" placeholder="Sel" class="form-control input-md" required type="text"/>-->
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-1">Nascimento:</label>  
                    <div class="col-md-2">
                      <input name="datanas" placeholder="DD/MM/AAAA" class="form-control input-md" required type="date" OnKeyPress="formatar('##/##/####', this)" onBlur="showhide()"/>
                    </div>
                    <label class="col-md-2">Carterira de Trabalho:</label>
                    <div class="col-md-2">
                      <input class="form-control" type="text" name="cart_trabalho" required/>
                    </div>
                    <label class="col-md-1">Orgão Emissor:</label>
                    <div class="col-md-1">
                      <input class="form-control input-md" type="text" name="cart_emissor" required/>
                    </div>
                    <label class="col-md-1">UF:</label>  
                    <div class="col-md-2">
                      <select class="form-control select2" style="width: 50%;" name="cart_uf" required>
                        <option selected="selected" value="1">AC</option>
                        <option value="2">AL</option>
                        <option value="3">AM</option>
                        <option value="4">AP</option>
                        <option value="5">BA</option>
                        <option value="6">CE</option>
                        <option value="7">DF</option>
                        <option value="8">ES</option>
                        <option value="9">GO</option>
                        <option value="10">MA</option>
                        <option value="11">MG</option>
                        <option value="12">MS</option>
                        <option value="13">MT</option>
                        <option value="14">PA</option>
                        <option value="15">PB</option>
                        <option value="16">PE</option>
                        <option value="17">PI</option>
                        <option value="18">PR</option>
                        <option value="19">RJ</option>
                        <option value="20">RN</option>
                        <option value="21">RO</option>
                        <option value="22">RR</option>
                        <option value="23">RS</option>
                        <option value="24">SC</option>
                        <option value="25">SE</option>
                        <option value="26">SP</option>
                        <option value="27">TO</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-1">Titulo Eleitoral:</label>
                    <div class="col-md-2">
                      <input name="titulo" placeholder="Apenas números" class="form-control input-md" required type="text" maxlength="20" pattern="[0-9]+$"/>
                    </div>
                    <label class="col-md-1">Reservista:</label>
                    <div class="col-md-3">
                      <input name="reservista" placeholder="Apenas números" class="form-control input-md" required type="text" maxlength="20" pattern="[0-9]+$"/>
                    </div>
                    <label class="col-md-1">Pis-PASEP:</label>
                    <div class="col-md-3">
                      <input name="pis" placeholder="Apenas números" class="form-control input-md" required type="text" maxlength="20" pattern="[0-9]+$"/>
                    </div>
                  </div>

                  <div class="row">
                    <h4 class="col-md-4">Endereço</h4>
                  </div>
                <form method="get" action=".">
                  <div class="form-group row">
                    <form action="" method="POST">
                      <label class="col-md-1">CEP:</label>
                      <div class="col-md-2">
                        <input name="cep" id="cep" type="text" maxlength="9" pattern="[0-9]+$"/>  
                      </div>
                    </form>
                  </div>
                  <div class="form-group row">  
                    <label class="col-md-1">Rua:</label>
                    <div class="col-md-5">
                      <input name="rua" id="rua" class="form-control" required type="text"/>
                    </div>

                    <label class="col-md-1">Nº:</label>
                    <div class="col-md-2">  
                      <input name="numero" class="form-control" required  type="text"/>
                    </div>
                    
                    <label class="col-md-1">Complemento:</label>
                    <div class="col-md-2">  
                      <input name="complemento" class="form-control" required  type="text"/>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-1">Bairro:</label>
                      <div class="col-md-2">
                        <input name="bairro" id="bairro" class="form-control" required type="text"/>
                      </div>    
                    
                    <label class="col-md-1">Cidade:</label>
                      <div class="col-md-2">
                        <input name="cidade" id="cidade" class="form-control" required type="text"/>
                      </div>
                  
                    <label class="col-md-1">Estado:</label>
                      <div class="col-md-2">
                        <input name="uf" id="uf" class="form-control" required type="text"/>
                      </div>
                  </div>
                </form>
                  <div class="row">
                    <h4 class="col-md-4">Dados</h4>
                  </div>

                  <div class="form-group row">
                    <label class="col-md-1">Foto:</label>
                    <div class="col-md-3">
                      <input type="file" name="foto" class="" />
                    </div>
                    
                    <label class="col-md-1">Email:</label>
                    <div class="col-md-4">
                      <input type="text" name="email" class="form-control"/>
                    </div>

                    <label class="col-md-1">Sexo:</label>
                    <div class="col-md-2">
                      <select class="form-control select2" style="width: 100%" name="sexo" required>
                        <option selected="selected" value="1">MASCULINO</option>
                        <option value="2">FEMININO</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-md-1">Telefone 1:</label>
                    <div class="col-md-1">
                      <input name="tele1" class="form-control" placeholder="XX XXXXX-XXXX" requered type="text" maxlength="13" pattern="\[0-9]{2}\ [0-9]{4,6}-[0-9]{3,4}$" OnKeyPress="formatar('## #####-####', this)"/>
                    </div>
                    <label class="col-md-1">Telefone 2:</label>
                    <div class="col-md-1">
                      <input name="tele2" class="form-control" placeholder="XX XXXXX-XXXX" type="text" maxlength="13" pattern="\[0-9]{2}\ [0-9]{4,6}-[0-9]{3,4}$" OnKeyPress="formatar('## #####-####', this)"/>
                    </div>

                    <label class="col-md-1">Estado Civil:</label>
                    <div class="col-md-1">
                      <select required name="estado_civil" class="form-control">
                          <option value=""></option>
                        <option value="Solteiro(a)">Solteiro(a)</option>
                        <option value="Casado(a)">Casado(a)</option>
                        <option value="Divorciado(a)">Divorciado(a)</option>
                        <option value="Viuvo(a)">Viuvo(a)</option>
                      </select>
                    </div>

                    <label class="col-md-1">Escolaridade:</label>
                      <div class="col-md-2">
                        <select required name="escolaridade" class="form-control">
                        <option value=""></option>
                          <option value="Analfabeto">Analfabeto</option>
                          <option value="Fundamental Incompleto">Fundamental Incompleto</option>
                          <option value="Fundamental Completo">Fundamental Completo</option>
                          <option value="Médio Incompleto">Médio Incompleto</option>
                          <option value="Médio Completo">Médio Completo</option>
                          <option value="Superior Incompleto">Superior Incompleto</option>
                          <option value="Superior Completo">Superior Completo</option>
                        </select>
                      </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-md-1">Filhos:</label>
                    <div class="col-md-3">
                      <div class="input-group">
                        <span class="input-group-addon">     
                          <label class="radio-inline" for="radios-0">
                        <input type="radio" name="filhos" id="filhos" value="nao" onclick="desabilita('filhos_qtd')" required>
                        Não
                      </label> 
                      <label class="radio-inline" for="radios-1">
                        <input type="radio" name="filhos" id="filhos" value="sim" onclick="habilita('filhos_qtd')">
                        Sim
                      </label>
                        </span>
                        <input id="filhos_qtd" name="filhos_qtd" class="form-control" type="text" placeholder="Quantos?" pattern="[0-9]+$" >
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-6">
                      <button type="submit" class="btn btn-success" name="cadastrar">Cadastrar</button>
                      <button type="reset" class="btn btn-danger" name="cancelar">Cancelar</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!--conteudo aba endereço-->
            <div role="tabpanel" class="tab-pane" id="profissao">
              <div style="padding-top:20px;">
                <form action="" method="POST">
                  <div class="form-group row">  
                    <label class="col-md-1">Função:</label>
                    <div class="col-md-4">
                      <select class="form-control select2" style="width: 100%;" name="profissao" required>
                        <option selected="selected" value="1">AC</option>
                        <option value="2">AL</option>
                        <option value="3">AM</option>
                        <option value="4">AP</option>
                      </select>
                    </div>

                    <label class="col-md-1">Nivél:</label>
                    <div class="col-md-2">
                      <select class="form-control select2" style="width: 100%;" name="salario" required>
                        <option selected="selected" value="1">AC</option>
                        <option value="2">AL</option>
                        <option value="3">AM</option>
                        <option value="4">AP</option>
                      </select>
                    </div>
                    <label class="col-md-1">Horário:</label>
                    <div class="col-md-3">
                      <select class="form-control select2" style="width: 100%;" name="escala" required>
                        <option selected="selected" value="1">AC</option>
                        <option value="2">AL</option>
                        <option value="3">AM</option>
                        <option value="4">AP</option>
                      </select>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </section>
      </div>
      <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2018-2019 <a href="#">Heavy Studio</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
 <aside class="control-sidebar control-sidebar-dark">
    <!-- Skin -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <ul class="control-sidebar-menu"></ul>
      </div>
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="../bower_components/raphael/raphael.min.js"></script>
<script src="../bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="../bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="../bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../bower_components/moment/min/moment.min.js"></script>
<script src="../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
</body>
</html>
