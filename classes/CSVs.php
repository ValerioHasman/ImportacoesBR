<?php

namespace classes;

class CSVs
{

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

  public function CSVParaArray(string $caminho, string $delimitador): void
  {
    $csv = fopen($caminho, 'r');
    $dados = [];
    for($i = 0; $linha = fgetcsv($csv, 0, $delimitador); $i++){
      $dados[$i] = new Linha();
      $dados[$i]->linha = $linha;
    }
    $this->csvArray = $dados;
  }

}