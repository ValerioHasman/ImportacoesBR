<?php

namespace classes;

class CSVs
{

  private Linha $csvCabecalho;
  private array $csvArray;
  private string $ano;

  public function __get($atributo)
  {
    return $this->$atributo;
  }

  public function CSVParaArray(string $caminho, string $delimitador = ';', bool $temCabecalho = true): void
  {

    if(!file_exists($caminho)){
      die('Arquivo de exportação ou importação ausente!!!' . PHP_EOL . 'Verifique as variáveis $caminhoExportacao e $caminhoImportacao no index.php.' . PHP_EOL);
    }

    $csv = fopen($caminho, 'r');
    $dados = [];
    if($temCabecalho){
      $this->csvCabecalho = new Linha();
      $this->csvCabecalho->linha = fgetcsv($csv, 0, $delimitador);
    }
    for($i = 0; $linha = fgetcsv($csv, 0, $delimitador); $i++){
      $dados[$i] = new Linha();
      $dados[$i]->linha = $linha;
      if($i == 0){
        $this->ano = $linha[0];
      }
    }
    $this->csvArray = $dados;
    fclose($csv);
  }

}