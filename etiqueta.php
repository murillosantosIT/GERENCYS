<html>
	<head>
		<title>Etiqueta</title>
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

				if(strip_tags(trim($_POST['cd_entrada_etiqueta'])) == null)
        		{
        			echo "<script>
                			alert('Impossível acessar essa página sem um número de entrada!');
                			window.location='saida.php';
                		</script>";
        		}
        		else
        		{
        			$id = strip_tags(trim($_POST['cd_entrada_etiqueta']));
				    //faz uma checagem se o código digitado é diferente de algum código cadastrado no banco
	        		$check2 = DBRead('tb_entrada',"where cd_entrada = {$id}");
        		}

			    if(!$check2)
           		{
                	echo "<script>
                			alert('Número inexistente!');
                			window.location='entrada.php';
                		</script>";
            	}

            	else
            	{
            			
			    //captura o valor digitado pelo usuário, no caso, o código do produto em estoque
			    $etiqueta = strip_tags(trim($_POST['cd_entrada_etiqueta']));

			    //varialvel para pegar os valores das tabelas produto, fornecedor etc... de acordo com a entrada.
			    $mostrar = DBRead("tb_produto 
				    					inner join tb_entrada
	                                		on tb_entrada.cd_produto = tb_produto.cd_produto
	                                            inner join tb_categoria
	                                                on tb_produto.cd_categoria = tb_categoria.cd_categoria
	                                                    inner join tb_fornecedor
	                                                        on tb_produto.cd_fornecedor = tb_fornecedor.cd_fornecedor", "where cd_entrada = $etiqueta");

			    //Capturar todas as informações e mostra-las através desse foreach
			    foreach ($mostrar as $mostrando) 
			    {
			    	for($i = 1; $i<=$mostrando['qt_volume']; $i++)
			    	{
						echo '
						<!--essa div com esse código css serve para quebrar a pagina quando alguma etiqueta sair quebrada, ou seja, para que caiba todas as etiquetas inteiras de maneira que também economize papel.-->
						<div style="page-break-inside: avoid">
							<table class="table table-bordered">
								<tr>
									<td colspan="3" align="center"><img src="dist/img/credit/mastercard.png" align="left"/>Etiqueta</td>
								</tr>

								<tr>
									<td>Número da NR</td>
									<td>'.$mostrando['cd_entrada']; echo '</td>
								<tr>
									<td>Data de entrada</td>
									<td>'.$mostrando['dt_entrada']; echo '</td>
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
									<td>Recebedor</td>
									<td>'.$mostrando['nm_usuario']; echo'</td>
								</tr>
								<tr>
									<td colspan="2">Ass. recebedor</td>
								</tr>
								<tr>
									<td>Fornecedor</td>
									<td>'.$mostrando['nm_fornecedor']; echo '</td>
								</tr>	
								<tr>
									<td>Local de armazenagem</td>
									<td>'.$mostrando['ds_local']; echo '</td>
								</tr>
								<tr>
									<td colspan="2" >Obs.</td>
								</tr>
							</table>
							<hr size="1" style="border:1px dashed;">						
						</div>
								';
					}
				}
						echo '
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