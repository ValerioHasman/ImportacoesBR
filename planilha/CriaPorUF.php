<?php

namespace planilha;

use classes\CSVs;

class CriaPorUF
{
  private array $ufs;
  private array|false $cabecalho;

  public function __set($atributo, $value): void
  {
    if ($atributo == 'ufs') {
      $this->$atributo = $value;
    }
    if ($atributo == 'cabecalho') {
      $this->$atributo = $value;
    }
  }

  public function __get($atributo)
  {
    if('cabecalho'){
      if(!isset($this->$atributo)){
        if(!isset($this->ufs)){
          return false;
        }
        foreach($this->ufs as $uf){
          foreach($uf as $ncm){
            foreach($ncm as $chave => $valor){
              $this->$atributo[$chave] = $chave;
            }
            return $this->$atributo;
          }
        }
      }
      return $this->$atributo;
    }
    return $this->$atributo;
  }

  public function __construct()
  {
    $this->__set('ufs', []);
  }

  public function criaArrayPorUF(CSVs $exportacao, CSVs $importacao) : void
  {
    $this->ArrayPorUF($exportacao, 'Exp');
    $this->ArrayPorUF($importacao, 'Imp');
  }

  private function ArrayPorUF(CSVs $csvs, string $tipo) : void {
    foreach($csvs->csvArray as $dado){
      $ncm = $dado->linha['CO_NCM'];
      $uf  = $dado->linha['SG_UF_NCM'];
      $mes = $dado->linha['CO_MES'];
      $val = $dado->linha['VL_FOB'];
      $ano = $csvs->ano;

      if(!isset($this->ufs[$uf][$ncm])){
        $this->ufs[$uf][$ncm] = $this->estruturaBasica($ncm, $ano);
      }

      $this->setNoMes($this->ufs[$uf][$ncm], $mes, $val, $tipo, $ano);
    }
  }

  private function estruturaBasica($ncm, $ano) : array {
    return Array('NCM' => $ncm,
      'Exp_jan' => 0,
      'Imp_jan' => 0,
      'Net_jan' => 0,
      'Exp_fev' => 0,
      'Imp_fev' => 0,
      'Net_fev' => 0,
      'Exp_mar' => 0,
      'Imp_mar' => 0,
      'Net_mar' => 0,
      'Exp_abr' => 0,
      'Imp_abr' => 0,
      'Net_abr' => 0,
      'Exp_mai' => 0,
      'Imp_mai' => 0,
      'Net_mai' => 0,
      'Exp_jun' => 0,
      'Imp_jun' => 0,
      'Net_jun' => 0,
      'Exp_jul' => 0,
      'Imp_jul' => 0,
      'Net_jul' => 0,
      'Exp_ago' => 0,
      'Imp_ago' => 0,
      'Net_ago' => 0,
      'Exp_set' => 0,
      'Imp_set' => 0,
      'Net_set' => 0,
      'Exp_out' => 0,
      'Imp_out' => 0,
      'Net_out' => 0,
      'Exp_nov' => 0,
      'Imp_nov' => 0,
      'Net_nov' => 0,
      'Exp_dez' => 0,
      'Imp_dez' => 0,
      'Net_dez' => 0,
      'Exp_' . $ano => 0,
      'Imp_' . $ano => 0,
      'Net_' . $ano => 0,
    );
  }

  private function nomeMes(string|int $mes) : string
  {
    $nummes = intval($mes);
    switch($nummes){
      case 1:
        return 'jan';
        break;
      case 2:
        return 'fev';
        break;
      case 3:
        return 'mar';
        break;
      case 4:
        return 'abr';
        break;
      case 5:
        return 'mai';
        break;
      case 6:
        return 'jun';
        break;
      case 7:
        return 'jul';
        break;
      case 8:
        return 'ago';
        break;
      case 9:
        return 'set';
        break;
      case 10:
        return 'out';
        break;
      case 11:
        return 'nov';
        break;
      case 12:
        return 'dez';
        break;
      default:
        return "$mes";
        break;
    }
  }

  private function setNoMes( &$ncm, $mes, $val, string $tipo, $ano) : void
  {
    $numVal = intval($val);
    $valexp = 0;
    $valimp = 0;
    $nomeMes      = $this->nomeMes($mes);
    $colunaMes    = $tipo . '_' . $nomeMes;
    $colunaNet    = 'Net' . '_' . $nomeMes;
    $colunaCsvAno = $tipo . '_' . $ano;
    $colunaNetAno = 'Net' . '_' . $ano;
    $ncm[$colunaMes] += $numVal;

    /** Nets */

    switch ($tipo) {
      case 'Exp':
        $valexp = $ncm[$colunaMes];
        $valimp = $ncm['Imp_' . $nomeMes];
        break;
      case 'Imp':
        $valexp = $ncm['Exp_' . $nomeMes];
        $valimp = $ncm[$colunaMes];
        break;
      default:
        die('Valor esperado: Exp ou Imp');
        break;
    }
    $ncm[$colunaNet] = $valexp - $valimp;
    $ncm[$colunaNetAno] = 0;
    $ncm[$colunaCsvAno] = 0;

    foreach($ncm as $chave => $valor){
      if(substr($chave, 0, 4) == "Net_" && substr($chave, 4, 4) != $ano ){
        $ncm[$colunaNetAno] += $valor;
      }
      if(substr($chave, 0, 3) == $tipo && substr($chave, 4, 4) != $ano ){
        $ncm[$colunaCsvAno] += $valor;
      }
    }
  }
}