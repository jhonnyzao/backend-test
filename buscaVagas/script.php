<?php 
	include 'Busca.php';

	$json = file_get_contents("../vagas.json");
	$data = json_decode($json, true);

	if(!empty($_GET['texto']))
		$texto = $_GET['texto'];
	else
		$texto = "";

	if(!empty($_GET['cidade']))
		$cidade = $_GET['cidade'];
	else
		$cidade = "";

	if(!empty($_GET['ord']))
		$ord = $_GET['ord'];
	else
		$ord = "";

	$resultado = Busca::buscaVagas($data, $texto, $cidade, $ord);
	$resultado = json_encode($resultado, JSON_PRETTY_PRINT);
