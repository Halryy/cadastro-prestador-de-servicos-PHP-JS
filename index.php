<!DOCTYPE HTML>
<html>
<head>
	<title>Edit/Delete</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
	<link rel="stylesheet" href="style.css">
	<script src="https://kit.fontawesome.com/ddf62469f1.js" crossorigin="anonymous"></script>
	<script src="script.js" defer></script>
	<script src="validacao.js" defer></script>
</head>
<body>
	<h2>Formulario de cadastro de prestador de servicos</h2>
	<?php
		// Mensagens de erro.
		$erroNome = 'Campo obrigatorio/Nome deve possuir no minimo 3 caracteres';
		$erroSobrenome = 'Campo obrigatorio';
		$erroEmail = 'Campo obrigatorio/Email invalido';
		$erroWebsite = 'Website invalido';
		$erroDataIni = 'Campo obrigatorio/Data inicial não pode ser menor que a atual';
		$erroDataFim = 'Campo obrigatorio/Data final não pode ser menor ou igual a data inicial';
		$erroAtividades = 'Campo obrigatorio';
		$erroRegiao = 'Campo obrigatorio';

		// Variáveis com os valores.
		$nome = '';
		$sobrenome = '';
		$email = '';
		$website = '';
		$dataIni = '';
		$dataFim = '';
		$atividades = '';
		function verificaNome() {
			if (strlen($_POST['nome']) < 3) {
				global $erroNome;
				return $erroNome;
			}
			return $_POST['nome'];
		}
		function verificaSobrenome() {
			if (strlen($_POST['sobrenome']) < 1) {
				global $erroSobrenome;
				return $erroSobrenome;
			}
			if ($_POST['sobrenome'] == '') {
				global $erroSobrenome;
				return $erroSobrenome;
			}
			return $_POST['sobrenome'];
		}
		function verificaEmail() {
			$regex = "/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/";
			if (preg_match($regex, $_POST['email'])) {
			return $_POST['email'];
			}
			global $erroEmail;
			return $erroEmail;
		}
		function verificaWebsite() {
			if ($_POST['website'] != '') {
				if (filter_var($_POST['website'], FILTER_VALIDATE_URL)) {
					return $_POST['website'];
				}
				global $erroWebsite;
				return $erroWebsite;
			}
			return $_POST['website'];
		}
		function verificaDataIni() {
			$dataAtual = new DateTime();
			$dataAtual->setTime(0, 0, 0);
			$dataIniObj = new DateTime($_POST['dataini']);
			if ($dataIniObj < $dataAtual) {
				global $erroDataIni;
				return $erroDataIni;
			}
			return $_POST['dataini'];
		}
		function verificaDataFim() {
			$dataFimObj = new DateTime($_POST['datafim']);
			$dataIniObj = new DateTime($_POST['dataini']);
			if ($dataFimObj <= $dataIniObj) {
				global $erroDataFim;
				return $erroDataFim;
			}
			return $_POST['dataini'];
		}
		function verificaAtividades() {
			if (isset($_POST['atividade'])) {
				if (count($_POST['atividade']) < 1) {
					global $erroAtividades;
					return $erroAtividades;
				}
			}
			else if (!isset($_POST['atividade'])) {
				global $erroAtividades;
				return $erroAtividades;
			}
			return $_POST['atividade'];
		}
		function verificaRegiao() {
			if (isset($_POST['regiao'])) {
				if ($_POST['regiao'] == '' || $_POST['regiao'] == null) {
					global $erroRegiao;
					return $erroRegiao;
				}
			}
			else {
				global $erroRegiao;
				return $erroRegiao;
			}
			return $_POST['regiao'];
		}
		if ($_POST) {
			function valida() {
				// Mensagens de erro.
				global $erroNome;
				global $erroSobrenome;
				global $erroEmail;
				global $erroWebsite;
				global $erroDataIni;
				global $erroDataFim;
				global $erroAtividades;
				global $erroRegiao;

				// Variáveis com os valores.
				global $nome;
				global $sobrenome;
				global $email;
				global $website;
				global $dataIni;
				global $dataFim;
				global $regiao;
				global $atividades;

				$nome = verificaNome();
				$sobrenome = verificaSobrenome();
				$email = verificaEmail();
				$website = verificaWebsite();
				$dataIni = verificaDataIni();
				$dataFim = verificaDataFim();
				$atividades = verificaAtividades();

				$regiao = verificaRegiao();
				if ($nome == $erroNome) {
					echo 'ERRO SERVIDOR: '.$erroNome.'(NOME) <br>';
				}
				if ($sobrenome == $erroSobrenome) {
					echo 'ERRO SERVIDOR: '.$erroSobrenome.'(SOBRENOME) <br>';
				}
				if ($email == $erroEmail) {
					echo 'ERRO SERVIDOR: '.$erroEmail.'(EMAIL) <br>';
				}
				if ($website == $erroWebsite) {
					echo 'ERRO SERVIDOR: '.$erroWebsite.'(WEBSITE) <br>';
				}
				if ($dataIni == $erroDataIni) {
					echo 'ERRO SERVIDOR: '.$erroDataIni.'(DATA INICIAL) <br>';
				}
				if ($dataFim == $erroDataFim) {
					echo 'ERRO SERVIDOR: '.$erroDataIni.'(DATA FINAL) <br>';
				}
				if ($atividades == $erroAtividades) {
					echo 'ERRO SERVIDOR: '.$erroAtividades.'(ATIVIDADES) <br>';
				}
				if ($regiao == $erroRegiao) {
					echo 'ERRO SERVIDOR: '.$erroRegiao.'(REGIAO) <br>';
				}

				if ($nome == $erroNome
					|| $sobrenome == $erroSobrenome
					|| $email == $erroEmail
					|| $dataIni == $erroDataIni
					|| $dataFim == $erroDataFim
					|| $atividades == $erroAtividades
					|| $regiao == $erroRegiao)
					{
						echo '<br>';
						return false;
					}

				return true;
			}

			if (valida()) {
				global $nome;
				global $sobrenome;
				global $email;
				global $website;
				global $dataIni;
				global $dataFim;
				global $regiao;
				global $atividades;

				$conteudo = file_get_contents('dados.php');
				$prestadores = is_null(json_decode($conteudo, true)) ? null : json_decode($conteudo, true);
		
				$prestadores[$nome] = [
					'sobrenome' => $sobrenome,
					'email' => $email,
					'website' => $website,
					'dataIni' => $dataIni,
					'dataFim' => $dataFim,
					'regiao' => $regiao,
					'atividades' => implode("-", $atividades)
				];
				
				$manipulador = fopen('dados.php', 'w+');
				fwrite($manipulador, json_encode($prestadores));
				fclose($manipulador);
				clearstatcache();
			}
			$conteudo = file_get_contents('dados.php');
			$prestadores = json_decode($conteudo, true);
		} else {
			$conteudo = file_get_contents('dados.php');
			$prestadores = json_decode($conteudo, true);
		}
	?>
	<div id="tabela-prestadores">
		<table>
			<thead>
				<tr>
					<th>Nome</th>
					<th>Sobrenome</th>
					<th>E-mail</th>
					<th>Website</th>
					<th>Data inicial</th>
					<th>Data final</th>
					<th>Região</th>
					<th>Atividades</th>
					<th style="text-align: center;">Acoes</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($prestadores) { foreach ($prestadores as $nome => $prestador) { ?>
						<form class="formDeletaPrestador" action="deletaPrestador.php" method="post">
							<tr>
								<td><?= $nome ?></td>
								<input name="nome" value="<?= $nome ?>" type="hidden">
								<td><?= $prestador['sobrenome'] ?></td>
								<td><?= $prestador['email'] ?></td>
								<td><?= $prestador['website'] ?></td>
								<td><?= $prestador['dataIni'] ?></td>
								<td><?= $prestador['dataFim'] ?></td>
								<td><?= $prestador['regiao'] ?></td>
								<td><?= $prestador['atividades'] ?></td>
								<td class="excluir-td" id="excluir-td"><button class="delete-btn"><i class="far fa-trash-alt"></i></button></td>
							</tr>
						</form>
				<?php }} ?>
			</tbody>
		</table>
	</div><br>
	<p style='text-align: center;'>Para editar algum prestador, digite o Nome do mesmo no input "Nome" e reenvie suas novas informações.</p>
	<form name="formulario" id="formulario" method="post" action="index.php">
		<div class="row grid">
			<div style="flex-grow: 1">
				<label for="nome">Nome</label>
				<input class="input-text" type="text" name="nome" id="nome" />
			</div>
			<div style="flex-grow: 1">
				<label for="sobrenome">Sobrenome</label>
				<input class="input-text" type="text" name="sobrenome" id="sobrenome" />
			</div>
		</div>
		<div class="row grid">
			<div class="vertical-row" style="flex-grow: 9">
				<div style="flex-grow: 1; margin-top: 5px;">
					<label for="email">E-mail</label>
					<input class="input-text" type="text" name="email" id="email" />
				</div>
				<div style="flex-grow: 2">
					<label for="website">Website</label>
					<input class="input-text" type="url" name="website" id="website" />
				</div>
			</div>
			<fieldset id="periodo" style="flex-grow: 1">
				<legend>Período de disponibilidade</legend>
				<div id="div-erro">
					<p class="erro" id="erroPeriodoDataIni"></p>
					<p class="erro" id="erroPeriodoDataFim"></p>
				</div>
				<div id="data-div">
					<div style="flex-grow: 1">
						<label for="dataini">Data inicial</label>
						<input class="input-data" type="date" name="dataini" id="dataini" />
					</div>
					<div style="flex-grow: 1">
						<label for="datafim">Data final</label>
						<input class="input-data" type="date" name="datafim" id="datafim" />
					</div>
				</div>
			</fieldset>
		</div>
		<div class="grid">
			<fieldset class="grupo" id="fieldset-regiao" style="flex-grow: 1">
				<legend>Principal regiao de atuacao</legend>
				<div>
					<input class="liberar regioes" type="radio" name="regiao" id="sul" value="Sul" />
					<label for="sul">Sul</label>
				</div>
				<div>
					<input class="liberar regioes" type="radio" name="regiao" id="sudeste" value="Sudeste" />
					<label for="sudeste">Sudeste</label>
				</div>
				<div>
					<input class="regioes" type="radio" name="regiao" id="centro" value="Centro-oeste" />
					<label for="centro">Centro-oeste</label>
				</div>
				<div>
					<input class="liberar regioes" type="radio" name="regiao" id="nordeste" value="Nordeste" />
					<label for="nordeste">Nordeste</label>
				</div>
				<div>
					<input class="liberar regioes" type="radio" name="regiao" id="norte" value="Norte" />
					<label for="norte">Norte</label>
				</div>
				<p class="erro" id="erroRegiao">Campo obrigatorio</p>
			</fieldset>
			<fieldset class="grupo" id="fieldset-atividade">
				<legend>Atividades pretendidas</legend>
				<div>
					<input type="checkbox" name="atividade[]" id="analista" value="Analista" />
					<label for="analista">Analista</label>
				</div>
				<div>
					<input type="checkbox" name="atividade[]" id="programador" value="Programador" />
					<label for="programador">Programador</label>
				</div>
				<div>
					<input type="checkbox" name="atividade[]" id="webdesigner" value="Webdesigner" />
					<label for="webdesigner">Web-designer</label>
				</div>
				<div>
					<input type="checkbox" name="atividade[]" id="dba" value="DBA" />
					<label for="dba">DBA</label>
				</div>
				<div>
					<input type="checkbox" name="atividade[]" id="administrador" value="Administrador de rede" />
					<label for="administrador">Administrador de rede</label>
				</div>
				<p class="erro" id="erroAtividades">Campo obrigatorio</p>
			</fieldset>
			<fieldset class="acoes">
				<legend>Acoes</legend>
				<button class="btns-form-prestador" type='submit' id="btnEnviar">Enviar</button>
				<button class="btns-form-prestador" type='reset' id="btnReset">Reiniciar</button>
				<button class="btns-form-prestador" type='button' id="btnAjuda">Ajuda</button>
			</fieldset>
		</div>
	</form>
</body>

</html>