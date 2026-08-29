<?php 
include 'conexao.php';
header("Content-Type: application/json");

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
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

	case 'POST':
		// CREATE (Inserir)
	$dados = json_decode(file_get_contents("php://input"), true);
	$nome = $dados['nome'] ?? '';
	$email = $dados['email'] ?? '';

	if (!empty($nome) && !empty($email)) {
		$sql = "INSERT INTO usuarios (nome, email) VALUES ('$nome', '$email')";
		if ($conn->query($sql) === TRUE) {
			echo json_encode(["sucesso" => true, "mensagem" => "Usuário cadastrado com sucesso!"]);
		} else {
			echo json_encode(["sucesso" => false, "mensagem" => "Erro: " . $conn->error]);
		}
	}
	break;

	case 'PUT':
		// UPDATE (Atualizar)
	parse_str(file_get_contents("php://input"), $dadosPUT);
		// Se estiver enviando via JSON puro:
	$dados = json_decode(file_get_contents("php://input"), true);

	$id = $dados['id'] ?? 0;
	$nome = $dados['nome'] ?? '';
	$email = $dados['email'] ?? '';

	if ($id > 0 && !empty($nome) && !empty($email)) {
		$sql = "UPDATE usuarios SET nome = '$nome', email = '$email' WHERE id = $id";
		if ($conn->query($sql) === TRUE) {
			echo json_encode(["sucesso" => true, "mensagem" => "Usuário atualizado com sucesso!"]);
		} else {
			echo json_encode(["sucesso" => false, "mensagem" => "Erro ao atualizar: " . $conn->error]);
		}
	} else {
		echo json_encode(["sucesso" => false, "mensagem" => "Dados inválidos."]);
	}
	break;

	case 'DELETE':
    	// DELETE (Excluir)
	parse_str(file_get_contents("php://input"), $dados);
	$id = $_GET['id'] ?? 0;

	if ($id > 0) {
		$sql = "DELETE FROM usuarios WHERE id = $id";
		if ($conn->query($sql) === TRUE) {
			echo json_encode(["sucesso" => true, "mensagem" => "Usuário deletado com sucesso!"]);
		} else {
			echo json_encode(["sucesso" => false, "mensagem" => "Erro ao deletar: " . $conn->error]);
		}
	} else {
		echo json_encode(["sucesso" => false, "mensagem" => "ID inválido."]);
	}
	break;
}

$conn->close();

?>