<?php 
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sistema";

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
	die(json_encode(["sucesso" => false, "mensagem" => "Erro de conexão: " . $conn ->connect_error ]));
}
$conn->set_charset("utf8");
 ?>