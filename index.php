<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

require "config.php";

$rota = $_GET["rota"] ?? "teste";

function teste() {
    echo json_encode(["mensagem" => "Back-end respondendo"]);
}

function listarAnimais($con) {
    $stmt = $con->query("SELECT * FROM Animais");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function listarPorEspecie($con) {
    $especie = $_GET["especie"] ?? "";
    $stmt = $con->prepare("SELECT * FROM Animais WHERE especie = ?");
    $stmt->execute([$especie]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function listarPorRaca($con) {
    $raca = $_GET["raca"] ?? "";
    $stmt = $con->prepare("SELECT * FROM Animais WHERE raca = ?");
    $stmt->execute([$raca]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function idadeMedia($con) {
    $stmt = $con->query("SELECT AVG(idade) AS idade_media FROM Animais");
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}

function listarServicos($con) {
    $stmt = $con->query("SELECT * FROM Servicos");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function listarPorCategoria($con) {
    $categoria = $_GET["categoria"] ?? "";
    $stmt = $con->prepare("SELECT * FROM Servicos WHERE categoria = ?");
    $stmt->execute([$categoria]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function precoMedio($con) {
    $stmt = $con->query("SELECT AVG(preco) AS preco_medio FROM Servicos");
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}

function maiorPreco($con) {
    $stmt = $con->query("SELECT * FROM Servicos ORDER BY preco DESC LIMIT 1");
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}

function animaisMaisServicos($con) {
    $stmt1 = $con->query("SELECT * FROM Animais");
    $animais = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    $stmt2 = $con->query("SELECT * FROM Servicos");
    $servicos = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "animais" => $animais,
        "servicos" => $servicos
    ]);
}

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

    case "servicos":
        listarServicos($con);
        break;

    case "servicos/categoria":
        listarPorCategoria($con);
        break;

    case "servicos/media-preco":
        precoMedio($con);
        break;

    case "servicos/maior-preco":
        maiorPreco($con);
        break;

    case "animais-servicos":
        animaisMaisServicos($con);
        break;

    default:
        teste();
        break;
}