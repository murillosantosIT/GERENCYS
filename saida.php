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
<?php
    //CADASTRAR SAIDAS
    if(isset($_POST['cadastrar']))
    {

        //verifica se o código do produto é nulo (ou seja, se não existem entradas (produtos no estoque)). Se for, não permite as operações a seguir e mostra
        // uma mensagem no else
        if(isset($_POST['cd_prod_estoque']))
        {


        //ATRIBUINDO OS DADOS DOS TEXBOXES PRA UM VETOR
            $form['cd_saida']   =strip_tags(trim($_POST['cd_saida']));
            $form['cd_prod_estoque'] =strip_tags(trim($_POST['cd_prod_estoque']));
            $form['nm_cliente']   = DBEscape(ucfirst(strtoLower(strip_tags(trim($_POST['nm_cliente'])))));   
            $form['dt_saida']   =strip_tags(trim($_POST['dt_saida']));                         
            $form['qt_saida']   =strip_tags(trim($_POST['qt_saida']));    
            $form['cd_pedido']  =strip_tags(trim($_POST['cd_pedido'])); 
            $form['nm_usuario'] = $_SESSION['usuario'];

            $form_estoque['cd_prod_estoque'] = strip_tags(trim($_POST['cd_prod_estoque']));
            //atribui o código do produto a uma variavel
            $id = $form_estoque['cd_prod_estoque'];
            //pega o valor do produto antigo e atribui a um array
            $teste =  DBRead('estoque_material', "where cd_prod_estoque = '{$id}'", 'qt_produto');

            //verifica se há algum campo vazio
            if(empty($form['qt_saida']) || empty($form['cd_pedido']) || empty($form['nm_cliente']) || $form['cd_prod_estoque']=="Selecione um produto em estoque")
            {
                echo "<script>alert('Preencha todos os campos que faltam!');</script>";
            }
            
            //se não houver campos vazios, efetua o resto das verificações
            else
            {
                //foreach usado para percorrer e capturar valores na tebela estoque_material
                foreach ($teste as $testes);
                //verifica se já existe cadastro de estoque do produto
                $estoque = DBRead('estoque_material', "where cd_prod_estoque = '{$id}'");

                //se não existir cadastro, não permite a saída e avisa
                if(!$estoque)
                { 
                    echo "<script>alert('Não existe esse produto no estoque!');</script>";
                }

                else
                {
                    //se ja existir, atualize

                    //pega a quantidade da saida
                    $qt_prod_saida  = $form['qt_saida'];
                    
                    //pega a quantidade que esta no estoque, antiga
                    $qt_prod_antigo = $testes['qt_produto'];
                    //faz o calculo para definir o valor atual                    

                    $qt_prod_atual['qt_produto'] = (double)$qt_prod_antigo-(double)$qt_prod_saida;


                    if($qt_prod_atual['qt_produto'] < 0)
                    {
                        echo "<script>alert('Impossível a saída de mais produtos do que há no estoque ou a retirada de produtos com quantidade igual a zero no estoque!');</script>";
                    }    
                    else
                    {
                        DBCreate('tb_saida', $form);
                        //atualiza a quantidade de produto no estoque ja existente
                        DBUpdate('estoque_material', $qt_prod_atual, "cd_prod_estoque = '{$id}'");
                        echo "<script>alert('Saída realizada com sucesso!');</script>"; 
                    }
                }
            }
        }

        else
        {
            echo "<script>alert('Não há produtos no estoque!');</script>";  
        }

                                       
    }
    //DELETE SAÍDA(APENAS ADMINISTRADOR)
    if(isset($_POST['excluir']))
    {
        
        $form['cd_saida'] = strip_tags(trim($_POST['cd_saida']));

        if($form['cd_saida'] == "")
        {
            echo "<script>alert('Preencha o campo número!');</script>";
        }

        else
        {
            $id = $form['cd_saida'];
            $check = DBRead('tb_saida', "where cd_saida = {$id}");
            if(!$check)
            {
                echo "<script>alert('Este número não pertence a nenhuma saída!');</script>";
            }
            else
            {
                DBDelete ('tb_saida', "cd_saida = {$id}");
                echo "<script>alert('Saída excluida com sucesso!');</script>";
                echo "<script>alert('Atenção, essa exclusão não afetará nada na movimentação, porém o registro dessa saída será excluído permanentemente!');</script>";
            }
        }
    }                 
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
            <aside class="main-sidebar" style="position: fixed; max-height: 100%; 
        overflow: auto;">
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
                    <h1>Saída
                        <small></small>
                        <!--Descrição caso queira-->
                    </h1>
                </section>
                <!-- Main content -->
                <!--MODAL CADASTRAR SAIDA-->
                <button class="bg-red btn btn-primary margin" data-toggle="modal" data-target="#modalnewprod">Saída de produto</button>           
                    <section class="modal fade" id="modalnewprod">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <header class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" arial-label="Fechar"><span arial-hidden="true">&times</span></button>
                                    <h4 class="modal-title">Saída de produto</h4>
                                </header>
                                <div class="modal-body">
                                    <form method="POST" action="">

                                    <label><font>Número</font></label>
                                    <input type="text" class="form-control" name="cd_saida" id="cd_saida" readonly="readonly"
                                    value=
                                        "<?php

                                                $cadastro = DBRead("tb_saida");
                                                 
                                                if(!$cadastro)
                                                {
                                                    $cadastro = 1;
                                                    echo $cadastro;
                                                }
                                                else
                                                {
                                                foreach ($cadastro as $cadastros);

                                                echo $cadastros['cd_saida']+1;
                                                }      

                                        ?>"
                                    >
                                    <label><font>Nome do produto em estoque</font></label>
                                    <select class="form-control" name="cd_prod_estoque" id="cd_prod_estoque">
                                        <option>
                                            Selecione um produto em estoque
                                        </option> 
                                        <?php
                                            $produto = DBRead("estoque_material
                                                                inner join tb_produto
                                                                    on estoque_material.cd_produto = tb_produto.cd_produto
                                                                        inner join tb_fornecedor
                                                                            on tb_produto.cd_fornecedor = tb_fornecedor.cd_fornecedor
                                                                                inner join tb_categoria
                                                                                    on tb_produto.cd_categoria = tb_categoria.cd_categoria");
                                            if(count($produto)){
                                                        foreach ($produto as $produtos){
                                        ?>       
                                        <option value="<?php echo $produtos['cd_prod_estoque'];?>">
                                            <font><font>
                                                <?php
                                                        echo $produtos['cd_prod_estoque'];
                                                        echo ' - ';
                                                        echo $produtos['nm_produto'];
                                                        echo ' '.$produtos['nm_fornecedor'];
                                                        echo ' - ';
                                                        echo $produtos['nm_categoria'];
                                                        echo ' - ';
                                                        echo $produtos['dt_entrada'];
                                                        echo ' - ';
                                                        echo ' ('.$produtos['qt_produto'].')';                                                       
                                                ?>  
                                            </font></font>
                                        </option>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                    <label><font>Qt. saída de produtos</font></label>
                                    <input type="number" class="form-control" name="qt_saida" id="qt_saida">
                                    <label><font>Data de saída</font></label>
                                    <input type="text" class="form-control" name="dt_saida" id="dt_saida" maxlength="10" 
                                        value="<?php date_default_timezone_set('America/Sao_Paulo'); echo date('d/m/Y'); ?>" readonly="readonly">
                                    <label><font>Número do pedido</font></label>
                                    <input type="number" class="form-control" name="cd_pedido" id="cd_pedido">
                                    <label><font>Nome do cliente</font></label>
                                    <input type="text" class="form-control" name="nm_cliente" id="nm_cliente">
                                </div>
                                <footer class="modal-footer">              
                                    <input type="submit" class="bg-red btn btn-primary" value="Concluir" name="cadastrar" id="cadastrar">
                                </form>
                                </footer>
                            </div>
                        </div>
                    </section>
                    <!--  data-target ="nome da modal" no data target inserir o id da modal (section)-->
                    <button class="bg-red btn btn-primary margin" data-toggle="modal" data-target="#modalnr">Imprimir RM</button>
                    <!-- id="nome da modal" -->
                    <section class="modal fade" id="modalnr">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <header class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" arial-label="Fechar"><span arial-hidden="true">&times</span></button>
                                    <h4 class="modal-title">Imprimir RM</h4>
                                </header>
                                <div class="modal-body">
                                    <form action="rm.php" method="POST">
                                    <label><font>Número da saída</font></label>
                                    <input type="number" class="form-control" name="cd_saida_rm">
                                </div>
                                <footer class="modal-footer">
                                    
                                        <input class="btn bg-red" type="submit" value="Imprimir" name="rm" id="rm"> 
                                    </form>  
                                </footer>
                            </div>
                        </div>                        
                    </section>

                    <?php
                        if($_SESSION["tipo"] == "Administrador")
                        {
                            echo '<!-- MODAL EXCLUIR -->
                                    <button class="bg-red btn btn-primary margin" data-toggle="modal" data-target="#modalExcluir">Excluir saída</button>
                                    <!-- id="nome da modal" -->
                                    <section class="modal fade" id="modalExcluir">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <header class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" arial-label="Fechar"><span arial-hidden="true">&times</span></button>
                                                    <h4 class="modal-title">Excluir saída</h4>
                                                </header>
                                                <div class="modal-body">
                                                    <label><font>Número da saída</font></label>
                                                    <form action="" method="POST">    
                                                    <input type="number" class="form-control" name="cd_saida">
                                                </div>
                                                <footer class="modal-footer"> 
                                                             
                                                        <input type="submit" class="bg-red btn btn-primary" value="Concluir" name="excluir">
                                                    </form>
                                                </footer>
                                            </div>
                                        </div>     
                                    </section>';
                        }
                    ?>

                    <section class="content">
                        <!--conteudo aquiiii-->
                        <div class="box box-danger">
                            <div class="box-header">
                                <h3 class="box-title">Registro de saída de produtos</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-12" style="overflow: auto;">
                                    <table id="tb_produtos" role="grid" aria-describedby="example1_info" class="table table-condensed table-hover">
                                        <tbody>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="tb_fornecedor" rowspan="1" colspan="1" style="width: 180px;">Número</th>
                                                <th class="sorting" tabindex="0" aria-controls="tb_fornecedor" rowspan="1" colspan="1" style="width: 180px;">Nome do produto</th>
                                                <th class="sorting" tabindex="0" aria-controls="tb_fornecedor" rowspan="1" colspan="1" style="width: 180px;">Data de saída</th>
                                                <th class="sorting" tabindex="0" aria-controls="tb_fornecedor" rowspan="1" colspan="1" style="width: 180px;">Qt. saída de produtos</th>
                                                <th class="sorting" tabindex="0" aria-controls="tb_fornecedor" rowspan="1" colspan="1" style="width: 180px;">Código do pedido</th>
                                                <th class="sorting" tabindex="0" aria-controls="tb_fornecedor" rowspan="1" colspan="1" style="width: 180px;">Cliente</th>
                                                <th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">Separador</th>
                                        <tbody>
                                            <?php
                                                    $saida = DBRead("tb_saida 
                                                                        inner join estoque_material
                                                                            on estoque_material.cd_prod_estoque = tb_saida.cd_prod_estoque
                                                                                inner join tb_produto
                                                                                    on estoque_material.cd_produto = tb_produto.cd_produto", "order by cd_saida");

                                                    if(!$saida)
                                                        echo 'Não há saídas';
                                                    else{
                                                                foreach ($saida as $saidas):     
                                                ?>  
                                            <tr role="row">
                                                <td class="active">
                                                    <?php 
                                                            echo $saidas['cd_saida'];
                                                    ?>
                                                </td>
                                                <td class="active">
                                                    <?php
                                                            echo $saidas['cd_prod_estoque'].' - '.$saidas['nm_produto'];
                                                    ?>
                                                </td>
                                                <td class="active">
                                                    <?php
                                                            echo $saidas['dt_saida'];
                                                    ?>
                                                </td>
                                                <td class="active">
                                                    <?php
                                                            echo $saidas['qt_saida'];
                                                    ?>
                                                </td>
                                                <td class="active">
                                                    <?php
                                                            echo $saidas['cd_pedido'];
                                                    ?>
                                                </td>
                                                <td class="active">
                                                    <?php
                                                            echo $saidas['nm_cliente'];
                                                    ?>
                                                </td>
                                                <td class="active">
                                                    <?php
                                                            echo $saidas['nm_usuario'];
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; } ?>
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