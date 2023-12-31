<?php

namespace classes;

use Error;

class Linha
{

  private array $linha;

  public function __set($atributo, $value): void
  {
    if ($atributo == 'linha') {
      if(!is_array($value)){
        throw new Error("O valor recebido não corresponde ao array esperado");
      }
      $this->$atributo = $this->removeDesinteressante($value);
    }
  }

  public function __get($atributo)
  {
    if ($atributo == 'linha') {
      return $this->$atributo;
    }
  }

  private function removeDesinteressante(array $array) : array {
    $interesse = [];
    foreach($array as $chave => $dado){
      if($chave == 1){
        $interesse['CO_MES'] = $dado;
      }
      if($chave == 2){
        $interesse['CO_NCM'] = $dado;
      }
      if($chave == 5){
        $interesse['SG_UF_NCM'] = $dado;
      }
      if($chave == 10){
        $interesse['VL_FOB'] = $dado;
      }
    }
    return $interesse;
  }
}
