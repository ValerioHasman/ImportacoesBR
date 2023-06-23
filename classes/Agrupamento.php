<?php

namespace classes;

use util\Operacoes;

class Agrupamento
{

  // private array $ncms;
  private array $ufNcms;
  private array $ufs;
  private array $meses;

  public function __construct() {
    // $this->ncms = Array();
    $this->ufNcms = Array();
    $this->ufs = Array();
    $this->meses = Array();
  }

  public function __get($atributo)
  {
    return $this->$atributo;
  }

  public function agrupar(CSVs $exp, CSVs $imp) : void {
    $this->agruparSemRepetir($exp);
    $this->agruparSemRepetir($imp);
    Operacoes::ordenarArray($this->meses);
    Operacoes::ordenarArray($this->ufs);
  }

  private function agruparSemRepetir(CSVs $csv) {
    /*foreach($csv->csvArray as $arr){
      Operacoes::apenasUm( $arr->linha['CO_NCM'], $this->ncms );
    }*/
    foreach($csv->csvArray as $arr){
      Operacoes::apenasUm( $arr->linha['SG_UF_NCM'], $this->ufs );
    }
    foreach($csv->csvArray as $arr){
      foreach($this->ufs as $uf){
        if($arr->linha['SG_UF_NCM'] == $uf){
          if(!isset($this->ufNcms[$uf])){
            $this->ufNcms[$uf] = [];
          }
          Operacoes::apenasUm( $arr->linha['CO_NCM'], $this->ufNcms[$uf] );
        }
      }
    }
    foreach($csv->csvArray as $arr){
      Operacoes::apenasUm( $arr->linha['CO_MES'], $this->meses );
    }
  }
}