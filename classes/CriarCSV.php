<?php

namespace classes;

class CriarCSV
{
  public static function ArrayParaCSV(array $array, array|false $cabecalho = false, string $caminho, string $nomeParaOArquivo = 'arquivo', $delimitador = ';') : void
  {
    $csv = fopen($caminho."\\".$nomeParaOArquivo.".csv", 'w+');
    
    if($cabecalho){
      fputcsv($csv, $cabecalho, $delimitador);
    }
    foreach($array as $linha){
      fputcsv($csv, $linha, $delimitador);
    }
    fclose($csv);
  }
}