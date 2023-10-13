<?php
    if ($_POST) {
        $conteudo = file_get_contents('dados.php');
        $prestadores = json_decode($conteudo, true);
        unset($prestadores[$_POST['nome']]);
        $manipulador = fopen('dados.php', 'w+');
        fwrite($manipulador, json_encode($prestadores));
        fclose($manipulador);

        header('Location: index.php');
    }  
?>