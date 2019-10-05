<?php

class Vaga{
    private $numero;
    private $flgOcupada;
   
    function setOcupada(){
        $this->flgOcupada = true;
    }
   
    function setDesocupada(){
        $this->flgOcupada = false;
    }
}

class Estacionar{
    private $veiculo;
    private $vaga;
    private $dthEstacionamento;

    function estacionar($veiculo, $vaga){
        $this->veiculo = $veiculo;
        $this->vaga = $vaga;
       
        $this->dthEstacionamento = date('Y-m-d H:i:s');
       
        $vaga->setOcupada();
    }
   
    function liberarVaga(){
        $this->veiculo = '';
        $this->vaga = '';

        $vaga->setDesocupada();
    }
   
    function calculaPagamento($preco){ // coloquei o preço como parametro para quando sofrer reajuste ser mais facil a manutenção. Poderia colocar também no banco de dados.
        $dataAgora = date('Y-m-d H:i:s');
        $tempoEstacionado = strtotime($dataAgora) - strtotime($this->dthEstacionamento);
        $tempoEstacionadoMinutos = $tempoEstacionado/60;
       
       
        $valor = $tempoEstacionadoMinutos * $preco;// Aqui cobrei por minuto
//        $valor = (ceil($tempoEstacionadoMinutos/15)) * $precoFracao; Aqui seria por fracao de 15 em 15 minutos
       
        return $valor;
    }
   
    function registraPagamento($caixa, $valor){
        $caixa->deposita($valor);
        $this->liberarVaga();
    }
}

class Caixa{
    private $valorTotalCaixa,// Sempre inicia com algum troco
    $valorArrecadado = 0;
   
    function Caixa($valorInicial){
        $this->valorTotalCaixa = $valorInicial;
    }
   
    function deposita($valor){
        $this->valorTotalCaixa += $valor;
        $this->valorArrecadado += $valor;
    }
}?>