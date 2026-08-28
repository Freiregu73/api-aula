<?php 
include 'conexao.php';
header("Content-Type: application/json");

$metodo = $_SERVER['REQUEST_METHOD'];

switch (metodo) {
	case 'GET':
		// READ (Listar todos ou um usuario especifico)
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$sql = "SELECT * FROM usuarios WHERE id = $id";
			$resultado = $conn->query($sql);
			echo json_encode($resultado->fetch_assoc());
		} else {
			$sql= "SELECT * FROM usuarios";
			$resultado = $conn->query($sql);
			$usuarios = [];
			while ($row = $resultado->fetch_assoc()) {
				$usuarios[] = $row;
			}
			echo json_encode($usuarios);
		}
		break;
	
	default:
		// code...
		break;
}

 ?>