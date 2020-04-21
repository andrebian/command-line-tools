#!/usr/bin/env php
<?php

echo PHP_EOL . PHP_EOL;
echo 'Olá, bem vindo(a) a calculadora de horas. ' . PHP_EOL . 'Informe as horas, separadas por vírgula ( , ). ';
echo 'As horas devem ser enviadas no formato HH:MM apenas.';
echo PHP_EOL . 'Exemplo: 01:45,3:17' . PHP_EOL;
echo PHP_EOL . 'Se quiser calcular o valor total, informe o valor hora em centavos, exemplo: para R$42,00, digite 4200';
echo PHP_EOL . PHP_EOL . 'Exemplo completo: calcular-horas 1:45,3:17,4:39 4200' . PHP_EOL;

$horasAdicionar = isset($argv[1]) ? $argv[1] : null;
$valorMultiplicar = isset($argv[2]) ? (int)$argv[2] : null;

if ($horasAdicionar) {
    $horasAdicionarOriginal = $horasAdicionar;
    $valorMultiplicarOriginal = $valorMultiplicar;

    if ($valorMultiplicar) {
        $valorMultiplicar = (int)$valorMultiplicar;
        $valorMultiplicar = $valorMultiplicar / 60;
    }

    $horasAdicionar = explode(',', $horasAdicionar);

    $totalMinutos = 0;
    $totalValor = 0;

    foreach ($horasAdicionar as $hora) {
        $hora = explode(':', $hora);
        $minutos = (int)($hora[0] * 60) + (int)$hora[1];
        $totalMinutos += $minutos;
    }

    $now = new DateTime();
    $target = new DateTime();
    $target->add(new DateInterval('PT' . $totalMinutos . 'M'));
    $diff = date_diff($now, $target);

    echo PHP_EOL . PHP_EOL;
    $horas = $diff->format('%h');
    if ($diff->format('%d') > 0) {
        $horas += (24 * $diff->format('%d'));
    }
    if ($diff->format('%m') > 0) {
        $horas += (720 * $diff->format('%m'));
    }
    if ($diff->format('%y') > 0) {
        $horas += (8760 * $diff->format('%y'));
    }

    $minutos = $diff->format('%i');

    echo 'Entradas: ' . $horasAdicionarOriginal . ' ' . $valorMultiplicarOriginal . PHP_EOL;

    echo '=============================================================' . PHP_EOL;
    echo 'O total de horas é: ' . $horas . ':' . $minutos;

    if ($valorMultiplicar > 0) {
        $totalValor = number_format((($totalMinutos * $valorMultiplicar) / 100), 2, ',', '.');
        $valorHora = number_format((($valorMultiplicar * 60) / 100), 2, ',', '.');
        echo ' X R$' . $valorHora . ' = R$' . $totalValor;
    }

    echo PHP_EOL . '=============================================================';
}

echo PHP_EOL . PHP_EOL;
