<?php
spl_autoload_register();

use classes\CSVs;
use planilha\CriaPorUF;

$caminhoExportacao = __DIR__.'\EXP_2022.csv';
$caminhoImportacao = __DIR__.'\IMP_2022.csv';
$caminhoResultados = __DIR__.'\resultado';

processar($caminhoExportacao, $caminhoImportacao, $caminhoResultados);

function processar($caminhoExportacao, $caminhoImportacao, $caminhoResultados){
  ini_set('memory_limit', '4096M'); // Habilite ou mude o valor desta linha se houver faltar de memória. 4096 1024

  $csvArrayEXP = new CSVs();
  $csvArrayEXP->CSVParaArray($caminhoExportacao);
  echo "Exportacao tratada, memória usada: " . memory_get_usage() . PHP_EOL;

  $csvArrayIMP = new CSVs();
  $csvArrayIMP->CSVParaArray($caminhoImportacao);
  echo "Importacao tratada, memória usada: " . memory_get_usage() . PHP_EOL;


  /*$agrupados = new Agrupamento();
  $agrupados->agrupar($csvArrayEXP, $csvArrayIMP);
  echo "Agrupamento tratado, memória usada: " . memory_get_usage() . PHP_EOL;
  $planila = new CriaPorUF($agrupados, $csvArrayEXP, $csvArrayIMP, $caminhoResultados);
  $planila->criaPlanilhaPorUF();*/

  $planila = new CriaPorUF();
  $planila->criaArrayPorUF($csvArrayEXP, $csvArrayIMP);

  var_export( $planila->ufs['SP']['27101911'] );
  echo PHP_EOL;
  var_export( $planila->numeroDeIteracoes );
  echo PHP_EOL;


  echo "Fim, memória usada: " . memory_get_usage() . PHP_EOL;
  
}