<?php

namespace classes;

use util\Operacoes;

class NCMPorMes
{

  private array $ncms;
  private array $ufs;
  private array $meses;

  public function __construct() {
    $this->ncms = Array();
    $this->ufs = Array();
    $this->meses = Array();
  }

  public function __set($atributo, $value): void
  {
    if ($atributo == 'ncms') {
      $this->$atributo = $value;
    }
    if ($atributo == 'ufs') {
      $this->$atributo = $value;
    }
    if ($atributo == 'meses') {
      $this->$atributo = $value;
    }
  }

  public function __get($atributo)
  {
    return $this->$atributo;
  }

  public function Agrupar(CSVs $csvs) : void {

    foreach($csvs->csvArray as $arr){
      Operacoes::apenasUm( $arr->linha[1], $this->ncms );
    }
    foreach($csvs->csvArray as $arr){
      Operacoes::apenasUm( $arr->linha[2], $this->ufs );
    }
    foreach($csvs->csvArray as $arr){
      Operacoes::apenasUm( $arr->linha[0], $this->meses );
    }
  }

}