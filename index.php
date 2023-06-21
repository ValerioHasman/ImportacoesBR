<?php
spl_autoload_register();

use classes\CSVs;
use classes\NCMPorMes;

$caminhoExportacao = __DIR__.'\EXP_2022.csv';
$caminhoImportacao = __DIR__.'\IMP_2022.csv';
$caminhoResultados = __DIR__.'\resultado';

processar($caminhoExportacao, $caminhoImportacao, $caminhoResultados);

function processar($caminhoExportacao, $caminhoImportacao, $caminhoResultados){
  ini_set('memory_limit', '4096M'); // Habilite ou mude o valor desta linha se houver faltar de memória.

  $csvArrayEXP = new CSVs();
  $csvArrayEXP->CSVParaArray($caminhoExportacao, ';');

  $csx = new NCMPorMes();
  $csx->Agrupar($csvArrayEXP);
  var_export($csx->ncms);
  var_export($csx->ufs);
  var_export($csx->meses);

}