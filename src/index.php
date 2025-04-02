<?php
$host = 'postgres';
$dbname = 'meudb';
$user = 'usuario';
$password = 'senha';

$dsn = "pgsql:host=$host;dbname=$dbname;user=$user;password=$password";

try {
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão com PostgreSQL estabelecida com sucesso!";
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>
