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
    if(isset($_POST['cadastrar']))
    {
        //cadastro da tabela entrada
        $form['cd_entrada'] = strip_tags(trim($_POST['cd_entrada']));
        $form['cd_nf'] = strip_tags(trim($_POST['cd_nf']));
        $form['cd_produto'] = strip_tags(trim($_POST['cd_produto']));
        $form['dt_entrada'] = strip_tags(trim($_POST['dt_entrada']));
        $form['qt_volume'] = strip_tags(trim($_POST['qt_volume']));  
        $form['nm_volume'] = DBEscape(ucfirst(strtoLower(strip_tags(trim($_POST['nm_volume'])))));
        $form['qt_recebido'] = strip_tags(trim($_POST['qt_recebido']));
        $form['ds_local'] = DBEscape(ucfirst(strtoLower(strip_tags(trim($_POST['ds_local'])))));
        $form['nm_usuario'] = $_SESSION['usuario'];
        //cadastro da tabela estoque
        $controle['qt_volume'] = strip_tags(trim($_POST['qt_volume']));
        $controle['qt_produto'] = strip_tags(trim($_POST['qt_recebido']));
        $controle['ds_local'] = DBEscape(ucfirst(strtoLower(strip_tags(trim($_POST['ds_local'])))));
        $controle['dt_entrada'] = strip_tags(trim($_POST['dt_entrada']));
        $controle['cd_produto'] = strip_tags(trim($_POST['cd_produto']));

        //valida se todos os campos estão preenchidos
        if(empty($form['ds_local']) || empty($form['qt_volume']) || empty($form['qt_recebido']) || empty($form['nm_volume']) || empty($form['cd_nf']) || $form['cd_produto']=="Selecione um produto")
        {
            echo "<script>alert('Preencha todos os campos que faltam!');</script>";
        }
        //valida se a quantidade recebida na entrada é inferior a 1
        else if($form['qt_recebido'] < 1)
        {
            echo "<script>alert('Digite um valor válido para quantidade recebida!');</script>";
        }
        //se estiver tudo em ordem, cadastra.
        else
        {
            echo "<script>alert('Entrada realizada com sucesso!');</script>";
            DBCreate("estoque_material", $controle);
            DBCreate("tb_entrada", $form);
        }
        
    }

    //DELETE ENTRADA(APENAS ADMINISTRADOR)
    if(isset($_POST['excluir']))
    {
        
        $form['cd_entrada'] = strip_tags(trim($_POST['cd_entrada']));

        if($form['cd_entrada'] == "")
        {
            echo "<script>alert('Preencha o campo número!');</script>";
        }

        else
        {
            $id = $form['cd_entrada'];
            $check = DBRead('tb_entrada', "where cd_entrada = {$id}");
            if(!$check)
            {
                echo "<script>alert('Este número não pertence a nenhuma entrada!');</script>";
            }
            else
            {
                DBDelete ('tb_entrada', "cd_entrada = {$id}");
                echo "<script>alert('Saída excluida com sucesso!');</script>";
                echo "<script>alert('Atenção, essa exclusão não afetará nada na movimentação, porém o registro dessa entrada será excluído permanentemente!');</script>";
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
                    <h1>Entrada
                        <small></small>
                        <!--Descrição caso queira-->
                    </h1>
                </section>
                <!-- Main content -->
               <!-- Modal da entrada-->
                    <button class="bg-red btn btn-primary margin" data-toggle="modal" data-target="#modalnewentrada">Entrada de produto</button>
                        <section class="modal fade" id="modalnewentrada">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <header class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" arial-label="Fechar"><span arial-hidden="true">&times</span></button>
                                        <h4 class="modal-title">Entrada de produto</h4>
                                    </header>
                                    <div class="modal-body">
                                        <form action="" method="POST">
                                        <label><font>Número</font></label>
                                        <input type="text" class="form-control" name="cd_entrada" 
                                        value="<?php

                                                $cadastro = DBRead("tb_entrada");
                                                 
                                                if($cadastro==0)
                                                {
                                                    $cadastro = 1;
                                                    echo $cadastro;
                                                }
                                                else
                                                {
                                                foreach ($cadastro as $cadastros);

                                                echo $cadastros['cd_entrada']+1;
                                                }      

                                        ?>" readonly="readonly">
                                        <label><font>Número da nota fiscal</font></label>
                                        <input type="number" class="form-control"name="cd_nf" id="cd_nf">
                                        <label><font>Nome do produto</font></label>
                                        <select class="form-control" name="cd_produto" id="cd_produto">
                                            <option>
                                                Selecione um produto
                                            </option> 
                                            <?php
                                                /*//conexao com o banco
                                                $link = @mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die(mysqli_connect_error());
                                                //atribui a query a uma variavel
                                                $sql = "SELECT * FROM tb_produto AS p left JOIN tb_entrada AS e
                                                            ON e.cd_produto = p.cd_produto 
                                                            left join tb_fornecedor as f
                                                            on p.cd_fornecedor = f.cd_fornecedor
                                                            left join tb_categoria as c
                                                            on p.cd_categoria = c.cd_categoria";
                                                //executa a query e atribui a uma variavel
                                                $produto = mysqli_query($link, $sql) or die(mysqli_error($link));*/
                
                                                $produto = DBRead("tb_produto 
                                                                    inner JOIN tb_fornecedor
                                                                        on tb_produto.cd_fornecedor = tb_fornecedor.cd_fornecedor
                                                                            inner JOIN tb_categoria
                                                                                on tb_produto.cd_categoria = tb_categoria.cd_categoria"); 
                                                if($produto){
                                                    foreach ($produto as $produtos){
                                            ?>       
                                            <option value="<?php echo $produtos['cd_produto'];?>">
                                                <font><font>
                                                    
                                                    <?php
                                                        echo $produtos['cd_produto'].' - '.$produtos['nm_produto'].' '.$produtos['nm_fornecedor'].' - '.$produtos['nm_categoria']; 
                                                    }
                                                }
                                                    ?>
                                             
                                            </font></font></option>
                                        </select>
										<label><font>Local de armazenagem</font></label>
										<input type="text" class="form-control" name="ds_local">
										<label><font>Data de entrada</font></label>
										<input type="text" class="form-control" name="dt_entrada" maxlength="10" 
                                        value="<?php date_default_timezone_set('America/Sao_Paulo'); echo date('d/m/Y'); ?>" readonly="readonly">
										<label><font>Qt. de produtos recebidos</font></label>
										<input type="number" class="form-control" name="qt_recebido">
										<label><font>Qt. volume<font></label>
										<input type="number" class="form-control" name="qt_volume">
										<label><font>Tipo de volume</font></label>
										<input type="text" class="form-control"name="nm_volume">
                                    </div>
                                    <footer class="modal-footer">              
                                        <input type="submit" class="bg-red btn btn-primary" value="Concluir" name="cadastrar">
                                    </footer>
                                </div>
                            </div>
                        </section>
                        </form>

                <!-- Modal da nr -->
                        <!--  data-target ="nome da modal" no data target inserir o id da modal (section)-->
                    <button class="bg-red btn btn-primary margin" data-toggle="modal" data-target="#modalnr">Imprimir NR</button>
                    <!-- id="nome da modal" -->
                    <section class="modal fade" id="modalnr">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <header class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" arial-label="Fechar"><span arial-hidden="true">&times</span></button>
                                    <h4 class="modal-title">Imprimir NR</h4>
                                </header>
                                <div class="modal-body">
                                    <form action="nr.php" method="POST">
                                    <label><font>Número da entrada</font></label>
                                    <input type="number" class="form-control" name="cd_entrada_nr">
                                </div>
                                <footer class="modal-footer">              
                                        <input class="btn bg-red" type="submit" value="Imprimir" name="nr" id="nr"> 
                                    </form>  
                                </footer>
                            </div>
                        </div>       
                    </section>

                    <!-- Modal da etiqueta -->
                        <!--  data-target ="nome da modal" no data target inserir o id da modal (section)-->
                    <button class="bg-red btn btn-primary margin" data-toggle="modal" data-target="#modaletiqueta">Imprimir etiqueta</button>
                    <!-- id="nome da modal" -->
                    <section class="modal fade" id="modaletiqueta">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <header class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" arial-label="Fechar"><span arial-hidden="true">&times</span></button>
                                    <h4 class="modal-title">Imprimir etiqueta</h4>
                                </header>
                                <div class="modal-body">
                                    <form action="etiqueta.php" method="POST">           
                                    <label><font>Número da entrada</font></label>
                                    <input type="number" class="form-control" name="cd_entrada_etiqueta">
                                </div>
                                <footer class="modal-footer">   
                                        <input class="btn bg-red" type="submit" value="Imprimir" name="etiqueta" id="etiqueta"> 
                                    </form>  
                                </footer>
                            </div>
                        </div>                       
                    </section>

                <?php
                    if($_SESSION["tipo"] == "Administrador")
                    {
                        echo '<!-- MODAL EXCLUIR -->
                                <button class="bg-red btn btn-primary margin" data-toggle="modal" data-target="#modalExcluir">Excluir entrada</button>
                                <!-- id="nome da modal" -->
                                <section class="modal fade" id="modalExcluir">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <header class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" arial-label="Fechar"><span arial-hidden="true">&times</span></button>
                                                <h4 class="modal-title">Excluir entrada</h4>
                                            </header>
                                            <div class="modal-body">
                                                <label><font>Número da saída</font></label>
                                                <form action="" method="POST">    
                                                <input type="number" class="form-control" name="cd_entrada">
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
                            <h3 class="box-title">Registro de entrada de produtos</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                        </div>
                        <div class="row">
                            <div class="col-sm-12" style="overflow: auto;">
                                <table id="tb_produtos" role="grid" aria-describedby="example1_info" class="table table-condensed table-hover">
                                    <tbody>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">Número</th>
                                            <th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">NF</th>
											<th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">Produto</th>
                                            <th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">Cat.produto</th>
											<th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">Fornecedor</th>
											<th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">CNPJ.fornecedor</th>
											<th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">Local</th>
											<th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">Dt.recebida</th>
											<th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">Qt.produtos</th>
											<th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">Qt.volumes</th>
											<th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">Tp.volume</th>
                                            <th class="sorting" tabindex="0" aria-controls="tb_entrada" rowspan="1" colspan="1" style="width: 180px;">Recebedor</th>
                                    <tbody>

                                        <?php

                                            $entrada = DBRead("tb_entrada AS e inner JOIN tb_produto AS p
                                                            ON e.cd_produto = p.cd_produto 
                                                            inner join tb_fornecedor as f
                                                            on p.cd_fornecedor = f.cd_fornecedor
                                                            inner join tb_categoria as c
                                                            on p.cd_categoria = c.cd_categoria", "order by cd_entrada");
                                            if(!$entrada)
                                                echo 'Não há entrada de produtos.';

                                            else
                                            {
                                                foreach($entrada as $entradas):

                                        ?>
                                        <tr role="row" class="active blue odd">
                                            <td class="active">
                                                <?php
                                                    echo $entradas['cd_entrada'];
                                                ?>
                                            </td>
                                            <td class="active">
                                                <?php
                                                    echo $entradas['cd_nf'];
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
                                                    echo $entradas['cd_cnpj'];
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
											<td class="active">
                                                <?php
                                                    echo $entradas['qt_recebido'];
                                                ?>
                                            </td>
											<td class="active">
                                                <?php
                                                    echo $entradas['qt_volume'];
                                                ?>
                                            </td>
											<td class="active">
                                                <?php
                                                    echo $entradas['nm_volume'];
                                                ?>
                                            </td>
                                            <td class="active">
                                                <?php
                                                    echo $entradas['nm_usuario'];
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                            endforeach; }
                                        ?>
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
        <!-- Script para mascara de data ISSO TUDO É TENTATIVA QUE DEU RUIM
        <script language="JavaScript" type="text/javascript">
           function mascaraData(campoData){
                      var data = campoData.value;
                      if (data.length == 2){
                          data = data + '/';
                          document.forms[0].data.value = data;
              return true;              
                      }
                      if (data.length == 5){
                          data = data + '/';
                          document.forms[0].data.value = data;
                          return true;
                      }
         }
        </script>

        <!-- script de mascaras
        <script src="/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
        <script src="plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
        <script src="plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>

        <!-- scripts relacionado a mascaras 
        <script type="text/javascript">
          $(function () {
            //Datemask dd/mm/yyyy
            $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            //Datemask2 mm/dd/yyyy
            $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
            //Money Euro
            $("[data-mask]").inputmask();

            //Date range picker
            $('#reservation').daterangepicker();
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
            //Date range as a button
            $('#daterange-btn').daterangepicker(
                    {
                      ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                        'Last 7 Days': [moment().subtract('days', 6), moment()],
                        'Last 30 Days': [moment().subtract('days', 29), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                      },
                      startDate: moment().subtract('days', 29),
                      endDate: moment()
                    },
            function (start, end) {
              $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
            );

            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
              checkboxClass: 'icheckbox_minimal-blue',
              radioClass: 'iradio_minimal-blue'
            });
            //Red color scheme for iCheck
            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
              checkboxClass: 'icheckbox_minimal-red',
              radioClass: 'iradio_minimal-red'
            });
            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
              checkboxClass: 'icheckbox_flat-green',
              radioClass: 'iradio_flat-green'
            });

            //Colorpicker
            $(".my-colorpicker1").colorpicker();
            //color picker with addon
            $(".my-colorpicker2").colorpicker();

            //Timepicker
            $(".timepicker").timepicker({
              showInputs: false
            });
          });
        </script> -->
        <script src="dist/js/app.min.js" type="text/javascript"></script>
        <!-- Optionally, you can add Slimscroll and FastClick plugins.
        Both of these plugins are recommended to enhance the user experience. Slimscroll
        is required when using the fixed layout. -->
    </body>

</html>
<?php
    }
?>