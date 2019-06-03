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
    //INSERT FORNECEDOR
    if(isset($_POST['cadastrar'])){
        //ATRIBUINDO OS DADOS DOS TEXBOXES PRA UM VETOR
        $form['cd_fornecedor']=strip_tags(trim($_POST['cd_fornecedor']));
        $form['nm_fornecedor']= DBEscape(ucfirst(strtoLower(strip_tags(trim($_POST['nm_fornecedor'])))));
        $form['cd_cnpj']=strip_tags(trim($_POST['cd_cnpj']));
        $form['cd_telefone']=strip_tags(trim($_POST['cd_telefone']));  

        
        if( empty($form['cd_fornecedor']) || empty($form['nm_fornecedor']) || empty($form['cd_cnpj']) || empty($form['cd_telefone']))
        {
            echo "<script>alert('Preencha todos os campos que faltam!');</script>";
        }

        else
        {
            //validação pra ver se já existe um fornecedor com o mesmo nome no banco
            $id         = $form['cd_fornecedor'];
            $nome       = $form['nm_fornecedor'];
            $telefone   = $form['cd_telefone'];
            $cnpj       = $form['cd_cnpj'];
            $check      = DBRead('tb_fornecedor', "where nm_fornecedor = '{$nome}'");
            $check2     = DBRead('tb_fornecedor', "where cd_telefone = '{$telefone}'");
            $check3     = DBRead('tb_fornecedor', "where cd_cnpj = '{$cnpj}'");
            $check4     = DBRead('tb_fornecedor', "where cd_fornecedor = {$id}");

            //verifica se o nome do fornecedor ja existe no banco
            if($check4)
            {
                echo "<script>alert('Esse código de fornecedor já existe!');</script>";
            }
            else if($check)
            {
                echo "<script>alert('Esse nome de fornecedor já existe!');</script>";
            }

            //verifica se ja existe um fornecedor com o mesmo cnpj
            else if($check3)
            {
                echo "<script>alert('Esse CNPJ já pertence a outro fornecedor');</script>";
            }


            //verifica se o telefone já pertence a algum fornecedor
            else if($check2)
            {
                echo "<script>alert('Esse numero de telefone pertence a outro fornecedor!');</script>";
            } 
                             
            else
            {            
                DBCreate('tb_fornecedor', $form);
                echo "<script>alert('Cadastro realizado com sucesso!');</script>";
            }
        }

    }                
    //DELETE FORNECEDOR
    if(isset($_POST['excluir']))
    {
        
        $form['cd_fornecedor'] = strip_tags(trim($_POST['cd_fornecedor']));

        if($form['cd_fornecedor'] == "")
        {
            echo "<script>alert('Preencha o campo código!');</script>";
        }

        else
        {
            $id = $form['cd_fornecedor'];
            $check = DBRead('tb_fornecedor', "where cd_fornecedor = {$id}");
            if(!$check)
            {
                echo "<script>alert('Este código não pertence a nenhum fornecedor!');</script>";
            }
            else
                DBDelete ('tb_fornecedor', "cd_fornecedor = {$id}");
        }
    }             

    //UPDATE FORNECEDOR
    if(isset($_POST['alterar'])){

        $form['cd_fornecedor'] = strip_tags(trim($_POST['cd_fornecedor']));
        $form['nm_fornecedor'] = DBEscape(ucfirst(strtoLower(strip_tags(trim($_POST['nm_fornecedor'])))));
        $form['cd_telefone'] = strip_tags(trim($_POST['cd_telefone']));

        //validação pra ver se já existe um fornecedor com o mesmo nome ou telefone no banco
            $nome       = $form['nm_fornecedor'];
            $telefone   = $form['cd_telefone'];
            $check      = DBRead('tb_fornecedor', "where nm_fornecedor = '{$nome}' and cd_fornecedor != '".$form['cd_fornecedor']."'");
            $check2     = DBRead('tb_fornecedor', "where cd_telefone = '{$telefone}'and cd_fornecedor != '".$form['cd_fornecedor']."'");                                
            
        if($form['cd_fornecedor'] == "Selecione um fornecedor")
        {
            echo "<script>alert('Selecione um fornecedor!');</script>";
        }
        else
        {    
            if(empty($form['nm_fornecedor']) && empty($form['cd_telefone']))
            {
                echo "<script>alert('Preencha o campo telefone, nome ou os dois campos!');</script>";
            }

            else
            {
                //verifica se o nome já pertence a algum fornecedor
                if($check)
                {
                    echo "<script>alert('Esse nome de fornecedor já existe!');</script>";
                }

                //verifica se o telefone já pertence a algum fornecedor
                else if($form['cd_telefone'] != null && $check2)
                {
                    echo "<script>alert('Esse numero de telefone pertence a outro fornecedor!');</script>";
                }

                else if(empty($form['nm_fornecedor']))
                {
                    $data['cd_fornecedor'] = strip_tags(trim($_POST['cd_fornecedor']));
                    $data['cd_telefone']   = strip_tags(trim($_POST['cd_telefone']));
                    $id = $data['cd_fornecedor'];
                    DBUpdate('tb_fornecedor', $data, "cd_fornecedor = '{$id}'");
                    echo "<script>alert('Alteração feita com sucesso!');</script>";
                }

                else if(empty($form['cd_telefone']))
                {   
                    $data2['cd_fornecedor']   = strip_tags(trim($_POST['cd_fornecedor']));
                    $data2['nm_fornecedor']   = strip_tags(trim($_POST['nm_fornecedor']));
                    $id = $data2['cd_fornecedor'];
                    
                    DBUpdate('tb_fornecedor', $data2, "cd_fornecedor = '{$id}'");
                    echo "<script>alert('Alteração feita com sucesso!');</script>";
                }

                else 
                {               
                    $id = $form['cd_fornecedor'];
                    DBUpdate('tb_fornecedor', $form, "cd_fornecedor = '{$id}'");
                    echo "<script>alert('Alteração feita com sucesso!');</script>";
                }
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
        <div class="wrapper">
		 <!-- Content Wrapper. Contains page content -->
      
	  <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Fornecedor
            <small></small><!--Descrição caso queira-->
          </h1>
        </section>

        <!-- Main content -->

        <!-- MODAL INSERT FORNECEDOR >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> -->
			<button class="bg-red btn btn-primary margin" data-toggle="modal" data-target="#modalnewforn">Novo Fornecedor</button>
                    
                        <section class="modal fade" id="modalnewforn">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <header class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" arial-label="Fechar"><span arial-hidden="true">&times</span></button>
                                        <h4 class="modal-title">Cadastro de fornecedor</h4>
                                    </header>
                                    <div class="modal-body">
                                    <form action="" method="POST">
                                        <label><font>Número</font></label>
                                        <input type="number" class="form-control" name="cd_fornecedor" readonly="readonly"
                                        value="<?php

                                                $cadastro = DBRead("tb_fornecedor");
                                                 
                                                if($cadastro==0)
                                                {
                                                    $cadastro = 1;
                                                    echo $cadastro;
                                                }
                                                else
                                                {
                                                foreach ($cadastro as $cadastros);

                                                echo $cadastros['cd_fornecedor']+1;
                                                }      

                                        ?>">
                                        <label><font>Nome do fornecedor</font></label>
                                        <input type="text" class="form-control" name="nm_fornecedor">
                                        <label><font>CNPJ do fornecedor</font></label> 
                                        <input type="number" class="form-control" name="cd_cnpj" maxlength="14">
                                        <label><font>Telefone do fornecedor</font></label>
                                        <input type="number" class="form-control" name="cd_telefone" maxlength="10">
                                    </div>
                                    <footer class="modal-footer">              
                                        <input type="submit" class="bg-red btn btn-primary" value="Concluir" name="cadastrar">
                                    </footer>
                                </div>
                            </div>
                        </section>
                                    </form>

                    

                    <?php
                        if($_SESSION["tipo"] == "Administrador")
                        {
                            echo '
                                    <!-- MODAL ATUALIZAR >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>-->
                                    <button class="bg-red btn btn-primary margin" data-toggle="modal" data-target="#modalAtualizar">Atualizar fornecedor</button>
                                    <section class="modal fade" id="modalAtualizar">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <header class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" arial-label="Fechar"><span arial-hidden="true">&times</span></button>
                                                    <h4 class="modal-title">Atualizar fornecedor</h4>
                                                </header>
                                                <div class="modal-body">
                                                <label><font>Escolha o código do fornecedor que deseja alterar</font></label>
                                                    <form action="" method="POST">
                                                    <select class="form-control" name="cd_fornecedor" id="cd_fornecedor">
                                                    <option>
                                                        Selecione um fornecedor
                                                    </option>';
                                                    ?> 
                                                    <?php
                                                        $fornecedor = DBRead("tb_fornecedor");
                                                        if($fornecedor){
                                                                    foreach ($fornecedor as $fornecedores){
                                                    ?>       
                                                    <option value="<?php echo $fornecedores['cd_fornecedor'];?>">
                                                        <font><font>
                                                            <?php
                                                              echo $fornecedores['cd_fornecedor'].' - '.$fornecedores['nm_fornecedor']; 
                                                              
                                                              }
                                                        }

                                                    ?>  
                                                    <?php echo'</font></font>
                                                    </option>
                                                    </select>
                                                    <label><font>Escolha o novo nome do fornecedor</font></label>
                                                    <input type="text" class="form-control" name="nm_fornecedor">
                                                    <label><font>Alterar telefone(opcional)</font></label>
                                                    <input type="number" class="form-control" name="cd_telefone" id="cd_telefone" maxlength="10">
                                                </div>
                                                <footer class="modal-footer">
                                                        <input type="submit" class="bg-red btn btn-primary" value="Concluir" name="alterar">
                                                    </form> 
                                                </footer>
                                            </div>
                                        </div>
                                    </section>';
                        }       
                    ?>

                    <?php
                        if($_SESSION["tipo"] == "Administrador")
                        {
                            echo '<!-- MODAL EXCLUIR -->
                                    <button class="bg-red btn btn-primary margin" data-toggle="modal" data-target="#modalExcluir">Excluir Fornecedor</button>
                                    <!-- id="nome da modal" -->
                                    <section class="modal fade" id="modalExcluir">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <header class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" arial-label="Fechar"><span arial-hidden="true">&times</span></button>
                                                    <h4 class="modal-title">Excluir fornecedor</h4>
                                                </header>
                                                <div class="modal-body">
                                                    <form action="" method="POST">
                                                    <label><font>Número</font></label>
                                                    <input type="number" class="form-control" name="cd_fornecedor">
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
                                    <h3 class="box-title">Registro de fornecedores</h3>
                                 </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" style="overflow: auto;">
                                        <table id="tb_fornecedores" role="grid" aria-describedby="example1_info" class="table table-hover">
                                            <tbody>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="tb_fornecedor" rowspan="1" colspan="1" style="width: 180px;">Número</th>
                                                    <th class="sorting" tabindex="0" aria-controls="tb_fornecedor" rowspan="1" colspan="1" style="width: 180px;">Fornecedor</th>
                                                    <th class="sorting" tabindex="0" aria-controls="tb_fornecedor" rowspan="1" colspan="1" style="width: 180px;">CNPJ</th>
                                                    <th class="sorting" tabindex="0" aria-controls="tb_fornecedor" rowspan="1" colspan="1" style="width: 180px;">Telefone</th>
                                                </tr>
                                            </tbody>
                                            <tbody>
                                                <?php
                                                    $cd_fornecedor = DBRead("tb_fornecedor", "order by cd_fornecedor");
                                                    if(!$cd_fornecedor)
                                                        echo 'Não há fornecedores cadastrados';
                                                    else{
                                                        foreach ($cd_fornecedor as $cd_fornecedores):
                                                ?>  
                                                <tr role="row" class="active blue odd">
                                                    <td>     
                                                                <?php
                                                                        echo $cd_fornecedores['cd_fornecedor'];   
                                                                ?> 
                                                    </td>
                                                    <td>
                                                                <?php
                                                                        echo $cd_fornecedores['nm_fornecedor'];   
                                                                ?>  
                                                    </td>
                                                    <td>
                                                                <?php
                                                                        echo $cd_fornecedores['cd_cnpj'];   
                                                                ?>                    
                                                    </td>
                                                    <td>
                                                                <?php
                                                                        echo $cd_fornecedores['cd_telefone'];   
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
                        </section><!-- /.content -->
        			</div><!-- /.content-wrapper -->
        		</div><!-- /.content-wrapper -->
            </div>
		<!-- REQUIRED JS SCRIPTS -->
        <!-- jQuery 2.1.4 -->
        <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/app.min.js" type="text/javascript"></script>
        <!-- Optionally, you can add Slimscroll and FastClick plugins.
        Both of these plugins are recommended to enhance the user experience. Slimscroll
        is required when using the fixed layout. -->
    </body>
</html>
<?php
    }
?>