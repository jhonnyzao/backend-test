<?php 
use PHPUnit_Framework_TestCase as PHPUnit;
require_once 'buscaVagas/Busca.php';

class BuscaTest extends PHPUnit{
	private $json;
	private $data;
	private $instancia; 

	protected function setUp(){
		$this->json = file_get_contents("vagas.json");
		$this->data = json_decode($this->json, true);
		$this->instancia = new Busca();
	}

    public function testBuscaVazia(){
		$a = $this->instancia->buscaVagas($this->data, '', '', '');
		$this->assertEmpty($a);
    }

    public function testBuscaTexto(){
		$a = $this->instancia->buscaVagas($this->data, 'Repositor', '', '');
		$b = $this->instancia->buscaVagas($this->data, 'processos/produtos', '', '');
		$c = $this->instancia->buscaVagas($this->data, 'Pacote office', '', '');
		$d = $this->instancia->buscaVagas($this->data, 'a4s678dhashjd-==djsaj~/;/.}[[´\|1=-+0', '', '');
		$e = $this->instancia->buscaVagas($this->data, '?><script>window.alert("oie");</script><?php', '', '');
		$f = $this->instancia->buscaVagas($this->data, 'Pacote office', '', 'asc');
		$g = $this->instancia->buscaVagas($this->data, 'Pacote office', '', 'desc');
		$h = $this->instancia->buscaVagas($this->data, 'Pacote office', '', 'jgdgs127ydasyy');

		foreach ($a as $resultado) {
			$titledescription = $resultado['title'] . $resultado['description'];
			$verificador = "Repositor";
			$this->assertContains(strtolower($verificador), strtolower($titledescription));
		}

		foreach ($b as $resultado) {
			$titledescription = $resultado['title'] . $resultado['description'];
			$verificador = "processos/produtos";
			$this->assertContains(strtolower($verificador), strtolower($titledescription));
		}

		foreach ($c as $resultado) {
			$titledescription = $resultado['title'] . $resultado['description'];
			$verificador = "Pacote office";
			$this->assertContains(strtolower($verificador), strtolower($titledescription));
		}

		foreach ($d as $resultado) {
			$titledescription = $resultado['title'] . $resultado['description'];
			$verificador = "a4s678dhashjd-==djsaj~/;/.}[[´\|1=-+0";
			$this->assertNotContains(strtolower($verificador), strtolower($titledescription));
		}

		foreach ($e as $resultado) {
			$titledescription = $resultado['title'] . $resultado['description'];
			$verificador = '?><script>window.alert("oie");</script><?php';
			$this->assertNotContains(strtolower($verificador), strtolower($titledescription));
		}

		foreach ($f as $resultado) {
			$titledescription = $resultado['title'] . $resultado['description'];
			$verificador = "Pacote office";
			$this->assertContains(strtolower($verificador), strtolower($titledescription));
		}

		foreach ($f as $resultado) {
			$titledescription = $resultado['title'] . $resultado['description'];
			$verificador = "Pacote office";
			$this->assertContains(strtolower($verificador), strtolower($titledescription));
		}

		foreach ($g as $resultado) {
			$titledescription = $resultado['title'] . $resultado['description'];
			$verificador = "Pacote office";
			$this->assertContains(strtolower($verificador), strtolower($titledescription));
		}
    }

    public function testBuscaCidade(){
    	$a = $this->instancia->buscaVagas($this->data, '', 'Porto Alegre', '');
    	$b = $this->instancia->buscaVagas($this->data, '', 'Toronto', '');

		foreach ($a as $resultado) {
			foreach ($resultado['cidade'] as $key => $value) {
				$verificador = "Porto Alegre";
				$this->assertContains(strtolower($verificador), strtolower($value));
			}
		}

		foreach ($b as $resultado) {
			foreach ($resultado['cidade'] as $key => $value) {
				$verificador = "Toronto";
				$this->assertNotContains(strtolower($verificador), strtolower($value));
			}
		}
    }

    public function testBuscaTextoECidade(){
    	$a = $this->instancia->buscaVagas($this->data, 'Caixa', 'Penha', '');
    	$b = $this->instancia->buscaVagas($this->data, 'Caixa', 'Penha', 'asc');
    	$c = $this->instancia->buscaVagas($this->data, 'Caixa', 'Penha', 'ydquwhdg44422/~.');
    	$d = $this->instancia->buscaVagas($this->data, 'Desenvolvedor', 'Penha', '');
    	$e = $this->instancia->buscaVagas($this->data, 'Caixa', 'Penha', '');

    	foreach ($a as $resultado) {
			$titledescription = $resultado['title'] . $resultado['description'];
			$verificador = "Caixa";
			$this->assertContains(strtolower($verificador), strtolower($titledescription));
			foreach ($resultado['cidade'] as $key => $value) {
				$verificador = "Penha";
				$this->assertContains(strtolower($verificador), strtolower($value));
			}
		}

		foreach ($b as $resultado) {
			$titledescription = $resultado['title'] . $resultado['description'];
			$verificador = "Caixa";
			$this->assertContains(strtolower($verificador), strtolower($titledescription));
			foreach ($resultado['cidade'] as $key => $value) {
				$verificador = "Penha";
				$this->assertContains(strtolower($verificador), strtolower($value));
			}
		}

		foreach ($c as $resultado) {
			$titledescription = $resultado['title'] . $resultado['description'];
			$verificador = "Desenvolvedor";
			$this->assertNotContains(strtolower($verificador), strtolower($titledescription));
			foreach ($resultado['cidade'] as $key => $value) {
				$verificador = "Penha";
				$this->assertContains(strtolower($verificador), strtolower($value));
			}
		}

		foreach ($d as $resultado) {
			$titledescription = $resultado['title'] . $resultado['description'];
			$verificador = "Desenvolvedor";
			$this->assertNotContains(strtolower($verificador), strtolower($titledescription));
			foreach ($resultado['cidade'] as $key => $value) {
				$verificador = "Penha";
				$this->assertContains(strtolower($verificador), strtolower($value));
			}
		}

		foreach ($e as $resultado) {
			$titledescription = $resultado['title'] . $resultado['description'];
			$verificador = "Caixa";
			$this->assertContains(strtolower($verificador), strtolower($titledescription));
			foreach ($resultado['cidade'] as $key => $value) {
				$verificador = "Tokyo";
				$this->assertNotContains(strtolower($verificador), strtolower($value));
			}
		}
    }

    public function testOrdenacao(){
    	$a = $this->instancia->buscaVagas($this->data, 'Desenvolvedor', '', '');
    	$b = $this->instancia->buscaVagas($this->data, 'Desenvolvedor', '', 'desc');
    	$c = $this->instancia->buscaVagas($this->data, 'Desenvolvedor', '', 'asc');

    	$ordenadoAsc = false;
    	$ordenadoDesc = false;
    	$desordenado = true;

    	$ordAsc = $a;
    	$ordDesc = $a;
    	
 		usort($ordAsc, function($a, $b) {
		   return $a['salario'] - $b['salario'];
		});
    	usort($ordDesc, function($a, $b) {
		   return $b['salario'] - $a['salario'];
		});

    	if($a === $ordAsc || $a === $ordDesc)
    		$desordenado = false;

    	$this->assertTrue($desordenado);

    	if($b === $ordDesc)
    		$ordenadoDesc = true;

    	$this->assertTrue($ordenadoDesc);

    	if($c === $ordAsc)
    		$ordenadoAsc = true;
    	$this->assertTrue($ordenadoAsc);
    }

}