<?php

namespace planilha;

use classes\CSVs;

class CriaPorUF
{
  /*private Agrupamento $agrupado;
  private CSVs $exportacao;
  private CSVs $importacao;
  private string $caminhoResultados;*/
  private array $ufs;


  public function __set($atributo, $value): void
  {
    if ($atributo == 'ufs') {
      $this->$atributo = $value;
    }
    /*if ($atributo == 'agrupado') {
      $this->$atributo = $value;
    }
    if ($atributo == 'exportacao') {
      $this->$atributo = $value;
    }
    if ($atributo == 'importacao') {
      $this->$atributo = $value;
    }
    if ($atributo == 'caminhoResultados') {
      $this->$atributo = $value;
    }*/
  }

  public function __get($atributo)
  {
    return $this->$atributo;
  }

  public function __construct()
  {
    $this->__set('ufs', []);
    /*$this->__set('agrupado', $agrupado);
    $this->__set('exportacao', $exportacao);
    $this->__set('importacao', $importacao);
    $this->__set('caminhoResultados', $caminhoResultados);*/
  }

  /*public function criaPlanilhaPorUF() : void
  {
    foreach($this->agrupado->ufs as $uf){
      $planilha = [];
      foreach($this->agrupado->ufNcms[$uf] as $ncm){
        echo $ncm . " do " . $uf . PHP_EOL;
        $linhaPlanilha = [];
        $linhaPlanilha['NCM'] = $ncm;
        $netExpAnual = 0;
        $netImpAnual = 0;
        foreach($this->agrupado->meses as $mes){
          $valorFobEXP = $this->valorFob($ncm, $uf, $mes, $this->exportacao);
          $valorFobIMP = $this->valorFob($ncm, $uf, $mes, $this->importacao);
          $netExpAnual += intval($valorFobEXP);
          $netImpAnual += intval($valorFobIMP);
          $linhaPlanilha["Exp_".$this->nomeMes($mes)] = $valorFobEXP;
          $linhaPlanilha["Imp_".$this->nomeMes($mes)] = $valorFobIMP;
          $linhaPlanilha["Net_".$this->nomeMes($mes)] = intval($valorFobEXP) - intval($valorFobIMP);
        }
        $linhaPlanilha["Exp_".$this->exportacao->ano] = $netExpAnual;
        $linhaPlanilha["Imp_".$this->exportacao->ano] = $netImpAnual;
        $linhaPlanilha["Net_".$this->exportacao->ano] = $netExpAnual - $netImpAnual;
        $planilha[] = $linhaPlanilha;
        echo "NCM ok, $ncm de $uf; memória usada: " . memory_get_usage() . PHP_EOL;
        break;
      }
      $cabecalho = [];
      foreach($planilha[0] as $chave => $dado){
        $cabecalho[$chave] = $chave;
      }
      echo PHP_EOL;
      var_export($cabecalho);
      echo PHP_EOL;
      exit();
      CriarCSV::ArrayParaCSV($planilha, $cabecalho, $this->caminhoResultados, $uf);
    }
  }*/

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
      $this->numeroDeIteracoes++;
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

  /*private function valorFob(string $ncm, string $uf, string $mes, CSVs &$csv) : string {
    $valor = 0;
    foreach($csv->csvArray as $dado){
      if($dado->linha['CO_NCM'] === $ncm && $dado->linha['CO_MES'] === $mes && $dado->linha['SG_UF_NCM'] === $uf){
        $valor += intval($dado->linha['VL_FOB']);
      }
    }
    if($valor !== 0){
      return "$valor";
    }
    return "";
  }*/

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
    $colunaNetAno = 'Net' . '_' . $ano;
    $ncm[$colunaMes] += $numVal;
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

    foreach($ncm as $chave => $valor){
      if(substr($chave, 0, 4) == "Net_" && substr($chave, 4, 4) != $ano ){
        $ncm[$colunaNetAno] += $valor;
      }
    }
  }
}