<?php

namespace classes;

class CSVs
{

  private Linha $csvCabecalho;
  private array $csvArray;

  public function __set($atributo, $value): void
  {
    if ($atributo == 'csvArray') {
      $this->$atributo = $value;
    }
  }

  public function __get($atributo)
  {
    return $this->$atributo;
  }

  public function CSVParaArray(string $caminho, string $delimitador, bool $temCabecalho = true): void
  {
    $csv = fopen($caminho, 'r');
    $dados = [];
    if($temCabecalho){
      $this->csvCabecalho = new Linha();
      $this->csvCabecalho->linha = fgetcsv($csv, 0, $delimitador);
    }
    for($i = 0; $linha = fgetcsv($csv, 0, $delimitador); $i++){
      $dados[$i] = new Linha();
      $dados[$i]->linha = $linha;
    }
    $this->csvArray = $dados;
  }

}