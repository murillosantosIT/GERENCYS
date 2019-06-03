<html>
	<head>
		<title>NR</title>
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

				if(strip_tags(trim($_POST['cd_entrada_nr'])) == null)
        		{
        			echo "<script>
                			alert('Impossível acessar essa página sem um número de entrada!');
                			window.location='entrada.php';
                		</script>";
        		}
        		else
        		{
        			$id = strip_tags(trim($_POST['cd_entrada_nr']));
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

        		//captura o valor digitado pelo usuário, no caso, o código da nr
		   		$entrada = strip_tags(trim($_POST['cd_entrada_nr']));
				
			    //varialvel para pegar os valores das tabelas produto, fornecedor etc... de acordo com a entrada.
			    $mostrar = DBRead("tb_entrada AS e inner JOIN tb_produto AS p
			            ON e.cd_produto = p.cd_produto 
			            inner join tb_fornecedor as f
			            on p.cd_fornecedor = f.cd_fornecedor
			            inner join tb_categoria as c
			            on p.cd_categoria = c.cd_categoria","where cd_entrada = $entrada");

			    //Capturar todas as informações e mostra-las através desse foreach
			    foreach ($mostrar as $mostrando) 
			    {
					echo '
						<table class="table table-bordered">
							<tr>
								<td colspan="3" align="center"><img src="dist/img/credit/mastercard.png" align="left"/>Nota de recebimento</td>
							</tr>

							<tr>
								<td>Número da entrada</td>
								<td>'.$mostrando['cd_entrada']; echo '</td>
							</tr>
							<tr>
								<td>Número da nota fiscal</td>
								<td>'.$mostrando['cd_nf']; echo '</td>
							</tr>
							<tr>
								<td>Data da entrada</td>
								<td>'.$mostrando['dt_entrada']; echo '</td>
							</tr>
							<tr>
								<td>Número do produto</td>
								<td>'.$mostrando['cd_produto']; echo '</td>
							</tr>						
							<tr>
								<td>Nome do produto</td>
								<td>'.$mostrando['nm_produto']; echo '</td>
							</tr>
							<tr>
								<td>Número da categoria do produto</td>
								<td>'.$mostrando['cd_categoria']; echo '</td>
							</tr>
							<tr>
								<td>Nome da categoria do produto</td>
								<td>'.$mostrando['nm_categoria']; echo '</td>
							</tr>						
							<tr>
								<td>Número do fornecedor</td>
								<td>'.$mostrando['cd_fornecedor']; echo '</td>
							</tr>						
							<tr>
								<td>Nome do fornecedor</td>
								<td>'.$mostrando['nm_fornecedor']; echo '</td>
							</tr>
							<tr>
								<td>Local de armazenagem</td>
								<td>'.$mostrando['ds_local']; echo'</td>
							</tr>				
							<tr>
								<td>Recebedor</td>
								<td>'.$mostrando['nm_usuario']; echo'</td>
							</tr>
							<tr>
								<td colspan="2">Ass. recebedor</td>
							</tr>
							<tr>
								<td>Quantidade recebida</td>
								<td>'.$mostrando['qt_recebido']; echo '</td>
							</tr>

							<tr>
								<td>Quantidade de volumes</td>
								<td>'.$mostrando['qt_volume']; echo'</td>
							</tr>

							<tr>
								<td>Tipo de volume</td>
								<td>'.$mostrando['nm_volume']; echo'</td>
							</tr>
							
							<tr>
								<td colspan="2" >Obs.</td>
							</tr>
						</table>
							';

						echo '	<hr size="1" style="border:1px dashed;">
								<input type="button" class="btn bg-black" name="imprimir" value="Imprimir" onclick="window.print();">		 
								<input type="submit" class="btn bg-black" value="Voltar" name="voltar" onclick="history.back();">
							  ';
				}
			}
			?>
		</body>
</html>
<?php
	}
?>