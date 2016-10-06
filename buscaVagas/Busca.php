<?php 
class Busca{
	/*
	Recebe: obrigatoriamente o array com o conteudo do json e as 3 variaveis possiveis do get, mesmo que vazias
	Retorna: array com as buscas solicitadas
	*/
	static function buscaVagas($data, $texto, $cidade, $ord){
		$temp_result = [];

		//percorre o array com o conteudo do json todo, uma unica vez por requisicao
		foreach ($data['docs'] as $vaga){
			//verifica se ha texto (buscado no titulo e na descricao) na requisicao
			if(!empty($texto)){
				$titulo = strpos(strtolower($vaga['title']), strtolower($texto));
				$descricao = strpos(strtolower($vaga['description']), strtolower($texto));
			}
			//verifica se ha cidade buscada na requisicao
			if (!empty($cidade)){
				//percorre o array interno que armazena a lista de cidades em que a vaga esta disponvel
				foreach ($vaga['cidade'] as $key => $value){
					$aux = strpos(strtolower($value), strtolower($cidade));
					//define a composicao do array de retorno de acordo com as variaveis presentes na requisicao
					if (empty($texto)){
						if ($aux !== false){
							array_push($temp_result, $vaga);
						}
					} else{
						if (($titulo !== false || $descricao !== false) && $aux !== false){
							array_push($temp_result, $vaga);
						}
					}
				}
			} else{
				if (!empty($texto)){
					if ($titulo !== false || $descricao !== false){
						array_push($temp_result, $vaga);
					}
				}
			}
		}
		//ordena o resultado final se houver necessidade
		$temp_result = self::ordena($temp_result, $ord);
		return $temp_result;
	}

	/*
	Recebe: obrigatoriamente array e variavel que determina o tipo de ordenacao, mesmo que vazia
	Retorna: array ordenado ou nao, de acordo com a variavel
	*/
	static function ordena($data, $ord){
		switch ($ord) {
			case 'asc':
				usort($data, function($a, $b) {
				   return $a['salario'] - $b['salario'];
				});
				return $data;
				break;
			case 'desc':
				usort($data, function($a, $b) {
				   return $b['salario'] - $a['salario'];
				});
				return $data;
				break;
			//se a variavel ord nao tiver como conteudo a string 'asc' ou 'desc', a funcao devolve o array intacto	
			default:
				return $data;
				break;
		}
	}
}