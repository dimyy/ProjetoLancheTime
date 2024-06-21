<?php
// Este é um script único para gerar o hash da senha
$senha = '123'; // Substitua '123' pela senha que deseja hashar
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);
echo "Hash da senha: " . $senha_hash;
?>
