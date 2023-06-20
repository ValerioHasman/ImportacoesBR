<?php

namespace classes;

use Error;

class Linha
{
  private string $linha;

  public function __set($atributo, $value): void
  {
    if ($atributo == 'linha') {
      if(gettype($value) != gettype(Array())){
        throw new Error('Era para ser um Array!!!');
      }
      $emTexto = implode(';', $value);
      $this->$atributo = $emTexto;
    }
  }

  public function __get($atributo)
  {
    if($atributo == 'linha'){
      return explode(';', $this->$atributo );
    } else {
      return $this->$atributo;
    }
    
  }

}