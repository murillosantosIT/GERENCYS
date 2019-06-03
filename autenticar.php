<?php 
	require 'system/config.php';
  require 'system/database.php';	
?>
<hmtl>
<head>
	<title>Autenticação de usuário</title>
	<script type="text/javascript">
		function loginsuccessfully()
		{
			setTimeout("window.location='produto.php'", 500);
		}
		function loginfailed()
		{
			setTimeout("window.location='index.php'", 500);
		}
	</script>
	<meta charset = "UTF-8">
</head>
<body>

<?php
  	$usuario = $_POST['usuario'];
  	$senha = $_POST['senha'];

  	$checar = DBRead('tb_usuario', "where nm_usuario = '{$usuario}' and cd_senha = '{$senha}'");	

  	if($checar > 0)
  	{	
  		session_start();
  		$_SESSION['usuario']=$_POST['usuario'];
  		$_SESSION['senha']=$_POST['senha'];

  		foreach ($checar as $checando) 
  		{
		  	$_SESSION['foto']=$checando['ft_usuario'];
		  	$_SESSION['tipo']=$checando['tp_usuario'];
	  	}
  		echo "<script>alert('Login realizado com sucesso! Aguarde um instante');</script>";
  		echo "<script>loginsuccessfully();</script>";
  	}
  	else
  	{
  		echo "<script>alert('Usuário ou senha incorreto! Aguarde para tentar novamente');</script>";
  		echo "<script>loginfailed();</script>";
  	}
?>

</body>
</html>