<?php

namespace classes;

class Linha
{
  
  private array $linha;

  public function __set($atributo, $value): void
  {
    if ($atributo == 'linha') {
      $this->$atributo = $this->removeDesinteressante($value);
    }
  }

  public function __get($atributo)
  {
    return $this->$atributo;
  }

  function removeDesinteressante(array $array) : array {
    unset($array[0]);
    unset($array[3]);
    unset($array[4]);
    unset($array[6]);
    unset($array[7]);
    unset($array[8]);
    unset($array[9]);
    $interesse = [];
    foreach($array as $dado){
      $interesse[] = $dado;
    }
    return $interesse;
  }
}