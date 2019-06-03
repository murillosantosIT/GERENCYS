<?php
    require 'system/config.php';
    require 'system/database.php';
?>
<?php
    //inicia uma sessão
    session_start();
    //se não estiver logado, redireciona para o login
    if(!isset($_SESSION["usuario"]) || !isset($_SESSION["senha"]))
    {
        header("Location: index.php");
        exit;   
    } 
    //senão, exibe tudo e faz tudo a seguir.
    else
    {

?>
<!DOCTYPE html>

<html>
    
    <head>
        <meta charset="UTF-8">
        <title>GerenCYS</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
        name="viewport">
        <!-- Bootstrap 3.3.4 -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"
        rel="stylesheet" type="text/css">
        <!-- Ionicons -->
        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"
        rel="stylesheet" type="text/css">
        <!-- Theme style -->
        <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css">
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter page.
        However, you can choose any other skin. Make sure you apply the skin class
        to the body tag so the changes take effect. -->
        <link href="dist/css/skins/skin-red.min.css" rel="stylesheet" type="text/css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media
        queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file://
        -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    
    <body class="skin-red fixed sidebar-mini">
        <div class="wrapper">
            <!-- Main Header -->
            <header class="main-header fixed">
                <!-- Logo -->
                <a href="#" class="logo">
				<!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-mini"><b>G</b>CYS</span>
		  
				<!-- logo for regular state and mobile devices -->
				<span class="logo-lg"><b>Geren</b>CYS</span>
			</a>
                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">

						<span class="sr-only">Toggle navigation</span>

					</a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account Menu -->
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

									<!-- The user image in the navbar-->

									<img src="<?php echo $_SESSION["foto"];?>" class="user-image" alt="User Image">

									<!-- hidden-xs hides the username on small devices so only the image appears. -->

									<span class="hidden-xs"><?php echo $_SESSION["usuario"];?></span>

								</a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <img src="<?php echo $_SESSION["foto"];?>" class="img-circle" alt="User Image">
                                        <p><?php echo $_SESSION["usuario"];?>
                                            <small><?php echo $_SESSION["tipo"];?></small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-right">
                                            <a href="logout.php"><button class="btn bg-red btn-block">Sair</button></a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar" style="position: fixed; max-height: 100%; overflow: auto;">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo $_SESSION["foto"];?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $_SESSION["usuario"];?></p>
                            <!-- Status -->
                            <a><i class="fa fa-circle text-success"></i><?php echo $_SESSION["tipo"];?></a>
                        </div>
                    </div>
                    <!-- search form (Optional) -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <span class="input-group-btn-red"></span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- Sidebar Menu -->
                    <ul class="sidebar-menu">
                        <li class="header">Cadastro</li>
                        <!-- Optionally, you can add icons to the links -->
                        <li>
                            <a href="produto.php"><i class="fa  fa-bicycle"></i> <span>Produto</span></a>
                        </li>
                        <li>
                            <a href="fornecedor.php"><i class="fa fa-truck"></i> <span>Fornecedor</span></a>
                        </li>
                        <li>
                            <a href="categoria.php"><i class="fa fa-sitemap"></i> <span>Categoria</span></a>
                        </li>
                        <li class="header">Gerenciamento</li>
                        <li>
                            <a href="entrada.php"><span>Entrada</span></a>
                        </li>
                        <li>
                            <a href="saida.php"><span>Saída</span></a>
                        </li>
                        <li>
                            <a href="controle.php"><span>Movimentação</span></a>
                        </li>
                        <li>
                            <a href="pedido.php"><span>Pedidos de compra</span></a>
                        </li>
                    </ul>
                    <!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper hidden-sm">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Movimentação
                        <small></small>
                        <!--Descrição caso queira-->
                    </h1>
                </section>
                <!-- Main content -->
                <!-- Modal de relatório -->
                        <!--  data-target ="nome da modal" no data target inserir o id da modal (section)-->
<form method="POST" action="relatorio.php">
                    <input type="submit" class="bg-red btn btn-primary margin" value="Imprimir relatório" name="relatorio" id="relatorio">
</form>
                <!-- FALAR COM O VITOR <?php
                /*if($_SESSION["tipo"] == "Administrador")
                {
                    echo '<!-- MODAL EXCLUIR -->
                            <button class="bg-red btn btn-primary margin" data-toggle="modal" data-target="#modalExcluir">Excluir produto em estoque</button>
                            <!-- id="nome da modal" -->
                            <section class="modal fade" id="modalExcluir">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <header class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" arial-label="Fechar"><span arial-hidden="true">&times</span></button>
                                            <h4 class="modal-title">Excluir produto em estoque</h4>
                                        </header>
                                        <div class="modal-body">
                                            <label><font>Número do produto em estoque</font></label>
                                            <form action="" method="POST">    
                                            <input type="number" class="form-control" name="cd_prod_estoque">
                                        </div>
                                        <footer class="modal-footer"> 
                                                     
                                                <input type="submit" class="bg-red btn btn-primary" value="Concluir" name="excluir">
                                            </form>
                                        </footer>
                                    </div>
                                </div>     
                            </section>';
                    }*/
                ?> -->

                <section class="content">
                    <!--conteudo aquiiii-->
                    <div class="box box-danger">
                        <div class="box-header">
                            <h3 class="box-title">Registro de movimentações de produtos no estoque</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                        </div>
                        <div class="row">
                            <div class="col-sm-12" style="overflow: auto;">
                                <table id="tb_produtos" role="grid" aria-describedby="example1_info" class="table table-condensed table-hover">
                                    <tbody>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">Núm. produto</th>
                                            <th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">Produto</th>
                                            <th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">Cat.produto</th>
                                            <th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">Fornecedor</th>
                                            <th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">Qt.produtos</th>
											<th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">Ds. local</th>                                        
                                            <th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">Dt. entrada</th>
                                    <tbody>
                                        <tr role="row" class="active blue odd">
                                           <?php

                                            $entrada = DBRead("estoque_material 
                                                                inner join tb_produto
                                                                    on estoque_material.cd_produto = tb_produto.cd_produto
                                                                        inner join tb_categoria
                                                                            on tb_produto.cd_categoria = tb_categoria.cd_categoria
                                                                                inner join tb_fornecedor
                                                                                    on tb_produto.cd_fornecedor = tb_fornecedor.cd_fornecedor", "order by cd_prod_estoque");
                                            if(!$entrada)
                                                echo 'Não há entrada de produtos.';

                                            else
                                            {
                                                foreach($entrada as $entradas):

                                        ?>
                                        <tr role="row" class="active blue odd">
                                            <td class="active">
                                                <?php
                                                    echo $entradas['cd_prod_estoque'];
                                                ?>
                                            </td>
                                            <td class="active">
                                                <?php
                                                    echo $entradas['nm_produto'];
                                                ?>
                                            </td>
                                            <td class="active">
                                                <?php
                                                    echo $entradas['nm_categoria'];
                                                ?>
                                            </td>
                                            <td class="active">
                                                <?php
                                                    echo $entradas['nm_fornecedor'];
                                                ?>
                                            </td>
                                            <td class="active">
                                                <?php
                                                    echo $entradas['qt_produto'];
                                                ?>
                                            </td>
                                            <td class="active">
                                                <?php
                                                    echo $entradas['ds_local'];
                                                ?>
                                            </td>
                                            <td class="active">
                                                <?php
                                                    echo $entradas['dt_entrada'];
                                                ?>
                                            </td>
                                        <?php endforeach; } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.content-wrapper -->
        <!-- REQUIRED JS SCRIPTS -->
        <!-- jQuery 2.1.4 -->
        <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="dist/js/app.min.js" type="text/javascript"></script>
        <!-- Optionally, you can add Slimscroll and FastClick plugins.
        Both of these plugins are recommended to enhance the user experience. Slimscroll
        is required when using the fixed layout. -->
    </body>
</html>
<?php
    }
?>