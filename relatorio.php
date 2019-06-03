<html>
    <head>
        <title>Relatorio</title>
        <meta charset="UTF-8"/>
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
    </head>
        <body>
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
                
                //varialvel para pegar os valores das tabelas produto, fornecedor etc... de acordo com a entrada.
                $mostrar = DBRead("estoque_material 
                                       inner join tb_produto
                                            on estoque_material.cd_produto = tb_produto.cd_produto
                                                        inner join tb_categoria
                                                            on tb_produto.cd_categoria = tb_categoria.cd_categoria
                                                                inner join tb_fornecedor
                                                                    on tb_produto.cd_fornecedor = tb_fornecedor.cd_fornecedor", "order by cd_prod_estoque");

                //Capturar todas as informações e mostra-las através desse foreach
                if($mostrar==null)
                {
                    echo "<script>
                                alert('Não há produtos em estoque!');
                                window.location='controle.php';
                            </script>";
                }
                elseif($mostrar!=null)
                {    
                        echo '
                        <!--essa div com esse código css serve para quebrar a pagina quando alguma etiqueta sair quebrada, ou seja, para que caiba todas as etiquetas inteiras de maneira que também economize papel.-->
                        <div style="page-break-inside: avoid">
                            <table class="table table-bordered">
                                <tr>
                                    <td colspan="3" align="center"><img src="dist/img/credit/mastercard.png" align="left"/>Relatório de movimentação no estoque</td>
                                </tr>';
                        foreach ($mostrar as $mostrando) 
                        {        
                                echo '
                            <div style="page-break-inside: avoid">
                                <table class="table table-bordered">
                                <tr>
                                    <td>Número do produto em estoque</td>
                                    <td>'.$mostrando['cd_prod_estoque']; echo '</td>
                                </tr>
                                
                                <tr>
                                    <td>Produto</td>
                                    <td>'.$mostrando['nm_produto']; echo '</td>
                                </tr>
                                
                                <tr>
                                    <td>Categoria</td>
                                    <td>'.$mostrando['nm_categoria']; echo '</td>
                                </tr>
                                
                                <tr>
                                    <td>Fornecedor</td>
                                    <td>'.$mostrando['nm_fornecedor']; echo '</td>
                                </tr>

                                <tr>
                                    <td>Qt. total de produtos</td>
                                    <td>'.$mostrando['qt_produto']; echo '</td>
                                </tr>
                                
                                <tr>
                                    <td>Local de armazenagem</td>
                                    <td>'.$mostrando['ds_local']; echo '</td>
                                </tr>
                                
                                <tr>
                                    <td>Data de entrada</td>
                                    <td>'.$mostrando['dt_entrada']; echo '</td>
                                </tr>
                            </table>                       
                        </div>
                                ';
                        }
                        echo '
                                <hr size="1" style="border:1px dashed;"> 
                                <input type="button" class="btn bg-black" name="imprimir" value="Imprimir" onclick="window.print();">        
                                <input type="submit" class="btn bg-black" value="Voltar" name="voltar" onclick="history.back();">
                              ';
                }
            ?>
        </body>
</html>
<?php
    }
?>