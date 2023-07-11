<?php

require_once('./autoload.php');

use classes\CriarCSV;
use classes\CSVs;
use planilha\CriaPorUF;

$caminhoExportacao = __DIR__ . DIRECTORY_SEPARATOR . 'EXP_2022.csv';
$caminhoImportacao = __DIR__ . DIRECTORY_SEPARATOR . 'IMP_2022.csv';
$caminhoResultados = __DIR__ . DIRECTORY_SEPARATOR . 'resultado';

processar($caminhoExportacao, $caminhoImportacao, $caminhoResultados);

function processar($caminhoExportacao, $caminhoImportacao, $caminhoResultados){
  ini_set('memory_limit', '4096M'); // Habilite ou mude o valor desta linha se houver faltar de memória.

  $csvArrayEXP = new CSVs();
  $csvArrayEXP->CSVParaArray($caminhoExportacao);
  echo "Exportacao tratada, memória usada: " . memory_get_usage() . PHP_EOL;

  $csvArrayIMP = new CSVs();
  $csvArrayIMP->CSVParaArray($caminhoImportacao);
  echo "Importacao tratada, memória usada: " . memory_get_usage() . PHP_EOL;

  $planila = new CriaPorUF();
  $planila->criaArrayPorUF($csvArrayEXP, $csvArrayIMP);
  echo "Arrays criados, memória usada: " . memory_get_usage() . PHP_EOL;

  $csvArrayEXP = null;
  $csvArrayIMP = null;

  foreach($planila->ufs as $nome => $planilhaUF){
    CriarCSV::ArrayParaCSV($planilhaUF, $planila->cabecalho, $caminhoResultados, $nome);
  }

  echo "Fim, memória usada: " . memory_get_usage() . PHP_EOL;

}