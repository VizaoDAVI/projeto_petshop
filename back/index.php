<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

require "config.php";

// Captura a rota e decodifica caracteres da URL (converte %2F para /)
$rota = $_GET["rota"] ?? "teste";
$rota = urldecode($rota);

function teste() {
    echo json_encode(["mensagem" => "Back-end respondendo"]);
}

// Rota 1: lista todos os animais
function listarAnimais($con) {
    $stmt = $con->query("SELECT * FROM animais");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// Rota 2: filtra animais por espécie (?rota=animais/especie&especie=Cachorro)
function listarPorEspecie($con) {
    $especie = $_GET["especie"] ?? "";
    $stmt = $con->prepare("SELECT * FROM animais WHERE especie = ?");
    $stmt->execute([$especie]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// Rota 3: filtra animais por raça (?rota=animais/raca&raca=Poodle)
function listarPorRaca($con) {
    $raca = $_GET["raca"] ?? "";
    $stmt = $con->prepare("SELECT * FROM animais WHERE raca = ?");
    $stmt->execute([$raca]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// Rota 4: calcula a idade média dos animais (?rota=animais/idade-media)
function idadeMedia($con) {
    $stmt = $con->query("SELECT AVG(idade) AS idade_media FROM animais");
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}

// Execução das rotas
switch ($rota) {
    case "animais":
        listarAnimais($con);
        break;

    case "animais/especie":
        listarPorEspecie($con);
        break;

    case "animais/raca":
        listarPorRaca($con);
        break;

    case "animais/idade-media":
        idadeMedia($con);
        break;

    default:
        teste();
        break;
}