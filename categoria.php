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
    //insert
    if(isset($_POST['cadastrar']))
    {
        //ATRIBUINDO OS DADOS DOS TEXBOXES PRA UM VETOR
        $form['cd_categoria']=strip_tags(trim($_POST['cd_categoria']));
        $form['nm_categoria']= DBEscape(ucfirst(strtoLower(strip_tags(trim($_POST['nm_categoria'])))));                
        
        //verifica se não foi atribuido o valor vazio para o nome da categoria
        if(empty($form['nm_categoria']))
        {
            echo "<script>alert('Preencha o campo nome!');</script>";
        }
        //se conter algum nome, pode inserir.
        else
        {                                  
            //validação pra ver se já existe um categoria com o mesmo nome no banco
            $nome   = $form['nm_categoria'];
            $check  = DBRead('tb_categoria', "where nm_categoria = '{$nome}' and nm_categoria !='".$form['cd_categoria']."'");

            if($check)
            {
                echo "<script>alert('Esse nome de categoria já existe!');</script>";
            }                      
                             
            else 
            {               
                DBCreate('tb_categoria',$form);
                echo "<script>alert('Cadastro realizado com sucesso!');</script>";
            }
        }
    }          

        //delete
    if(isset($_POST['excluir']))
    {
        $form['cd_categoria'] = strip_tags(trim($_POST['cd_categoria']));

        

        if($_POST['cd_categoria'] == "")
        {
            echo "<script>alert('Preencha o campo número!');</script>";   
        }
        else
        {
            $id = $form['cd_categoria'];

            //faz uma checagem se o código digitado é diferente de algum código cadastrado no banco
            $check = DBRead('tb_categoria',"where cd_categoria = {$id}");
            //faz uma checagem se o código digitado é diferente de algum código cadastrado no banco
            $check2 = DBRead('tb_produto',"where cd_categoria = {$id}");
            if($check2)
            {
                echo "<script>alert('Essa categoria já pertence a um produto!');</script>";
            }
            elseif(!$check)
            {
                echo "<script>alert('Número inexistente!');</script>";
            }
            //se tudo der certo, exclui a categoria
            else
            {
                DBDelete ('tb_categoria', "cd_categoria = {$id}");
                echo "<script>alert('Exclusão feita com sucesso!');</script>";
            }
        }
    }            

    //UPDATE CATEGORIA
    if(isset($_POST['alterar'])){

        $form['cd_categoria'] = strip_tags(trim($_POST['cd_categoria']));
        $form['nm_categoria'] = DBEscape(ucfirst(strtoLower(strip_tags(trim($_POST['nm_categoria'])))));

        $nome = $form['nm_categoria'];
        
        //verifica se não foi atribuido o valor vazio para o nome da categoria
        if($form['cd_categoria'] == "Selecione uma categoria")
        {
            echo "<script>alert('Selecione uma categoria!');</script>";
        }
        else
        {
            if($form['nm_categoria'] == "")
            {
                echo "<script>alert('Preencha o campo nome para alterar!');</script>";
            }

            else
            {
                //verifica se o nome atualizado ja pertence a alguma categoria
                $check2 = DBRead('tb_categoria', "where nm_categoria = '{$nome}' and nm_categoria !='".$form['cd_categoria']."'");
                if($check2)
                {
                    echo "<script>alert('Esse nome pertence a outra categoria ou a categoria que deseja atualizar!');</script>";
                } 
                //senão, pode excluir a categoria
                else
                {
                    $id = $form['cd_categoria'];
                    DBUpdate('tb_categoria', $form, "cd_categoria = '{$id}'");
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
            <div class="content-wrapper hidden-sm">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Categoria
                        <small></small>
                        <!--Descrição caso queira-->
                    </h1>
                </section>
                <!-- Main content -->


                <!--  MODAL CADASTRAR  -->


                <button class="bg-red btn btn-primary margin" data-toggle="modal" data-target="#modalnewprod">Nova categoria</button>
                    <section class="modal fade" id="modalnewprod">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <header class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" arial-label="Fechar"><span arial-hidden="true">&times</span></button>
                                    <h4 class="modal-title">Cadastro de categoria</h4>
                                </header>
                                <div class="modal-body">
                                <form action="" method="POST">  
                                    <label><font>Número</font></label>
                                    <input type="text" class="form-control" name="cd_categoria" id="cd_categoria" 
                                    value=
                                    "<?php

                                            $cadastro = DBRead("tb_categoria");
                                             
                                            if($cadastro==0)
                                            {
                                                $cadastro = 1;
                                                echo $cadastro;
                                            }
                                            else
                                            {
                                            foreach ($cadastro as $cadastros);

                                            echo $cadastros['cd_categoria']+1;
                                            }      

                                    ?>" readonly="readonly">
                                    <label><font>Nome da categoria</font></label>
                                    <input type="text" class="form-control" name="nm_categoria" id="nm_categoria">
                                </div>
                                <footer class="modal-footer">              
                                        <input type="submit" value="Concluir" class="bg-red btn btn-primary" name="cadastrar">
                                    </form>  
                                </footer>                            
                            </div>
                        </div>
                    </section>
                    <!-- MODAL ATUALIZAR >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> -->

                    <?php
                        if($_SESSION["tipo"] == "Administrador")
                        {
                            echo  '<button class="bg-red btn btn-primary margin" data-toggle="modal" data-target="#modalAtualizar">Atualizar categoria</button>
                                        <section class="modal fade" id="modalAtualizar">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <header class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" arial-label="Fechar"><span arial-hidden="true">&times</span></button>
                                                        <h4 class="modal-title">Atualizar categoria</h4>
                                                    </header>
                                                    <div class="modal-body">
                                                    <form action="" method="POST">
                                                    <label><font>Escolha o código da categoria que deseja alterar:</font></label>
                                                        <option>
                                                            Selecione uma categoria
                                                        </option> 
                                                        <select class="form-control" name="cd_categoria" id="cd_categoria">
                                                        <option>
                                                            Selecione uma categoria
                                                        </option>';
                                                        ?>
                                                        <?php
                                                            $categoria = DBRead("tb_categoria");
                                                            if($categoria){
                                                                        foreach ($categoria as $categorias){
                                                        ?>       
                                                        <option value="<?php echo $categorias['cd_categoria'];?>">
                                                            <font><font>
                                                                <?php
                                                                  echo $categorias['cd_categoria'].' - '.$categorias['nm_categoria']; 
                                                                  
                                                                  }
                                                            }

                                                        ?>
                                                        <?php  
                                                        echo '</font></font>
                                                        </option>
                                                        </select>
                                                        <label><font>Escolha o novo nome da categoria:</font></label>
                                                        <input type="text" class="form-control" name="nm_categoria">
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
                    
                    <!--  MODAL EXCLUIR  -->

                    <?php
                        if($_SESSION["tipo"] == "Administrador")
                        {
                            echo '  <!--  data-target ="nome da modal" no data target inserir o id da modal (section)-->
                                    <button class="bg-red btn btn-primary margin" data-toggle="modal" data-target="#modalExcluir">Excluir Categoria</button>
                                        <!-- id="nome da modal" -->
                                        <section class="modal fade" id="modalExcluir">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <header class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" arial-label="Fechar"><span arial-hidden="true">&times</span></button>
                                                        <h4 class="modal-title">Excluir categoria</h4>
                                                    </header>
                                                    <div class="modal-body">
                                                        <form action="" method="POST">
                                                        <label><font>Número</font></label>
                                                        <input type="number" class="form-control" name="cd_categoria">
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
                                <h3 class="box-title">Registro de categorias</h3>
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
                                                <th class="sorting" tabindex="0" aria-controls="tb_fornecedor" rowspan="1" colspan="1" style="width: 180px;">Categoria</th>
                                            </tr>
                                        </tbody>
                                        <tbody>
                                            <?php

                                                $categoria = DBRead("tb_categoria", "order by cd_categoria");
                                                if(!$categoria)
                                                    echo 'Não há categorias cadastradas';

                                                    else{
                                                        foreach ($categoria as $categorias):

                                            ?>
                                            <tr role="row" class="active blue odd">
                                                <td>
                                            
                                                            <?php
                                                                    echo $categorias['cd_categoria'];   
                                                            ?>  
                                                </td>
                                                <td>
                                                            <?php
                                                                    echo $categorias['nm_categoria'];   
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
        <!-- AdminLTE App -->
        <script>
            
        </script>
        <script src="dist/js/app.min.js" type="text/javascript"></script>
        <!-- Optionally, you can add Slimscroll and FastClick plugins.
        Both of these plugins are recommended to enhance the user experience. Slimscroll
        is required when using the fixed layout. -->
    </body>
</html>
<?php
    }
?>