<?php

namespace util;

abstract class Operacoes
{
  public static function apenasUm(string $dado, array &$array) : void
  {
    $dadoExiste = false;
    foreach($array as $dadoUnico){
      if($dadoUnico == $dado){
        $dadoExiste = true;
        break;
      }
    }
    if(!$dadoExiste){
      $array[] = strval($dado);
    }
  }

  public static function ordenarArray(array &$array) : void
  {
    sort($array);
  }
}