<?php
spl_autoload_register();

use classes\CSVs;

$caminhoExportacao = __DIR__.'\EXP_2022.csv';
$caminhoImportacao = __DIR__.'\IMP_2022.csv';
$caminhoResultados = __DIR__.'\resultado';

processar($caminhoExportacao, $caminhoImportacao, $caminhoResultados);

function processar($caminhoExportacao, $caminhoImportacao, $caminhoResultados){

  $csvArray = new CSVs();
  $csvArray->CSVParaArray($caminhoImportacao, ';');
  echo "\n\n";
  print_r ( $csvArray->csvArray[0] );
  echo "\n\n";
  print_r ( $csvArray->csvArray[count($csvArray->csvArray) - 1] );
  echo "\n\n";
  //var_dump ( $csvArray->csvArray[2000000]->linha[0] );
  //echo "\n\n";
  //var_export ( $csvArray->csvArray[2000000]->linha[0] );
  //echo "\n\n";
}