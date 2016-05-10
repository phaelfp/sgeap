"use strict";

const tabela1 = {
  faixa_inicial:0,
  faixa_final:1000,
  fee_mensal:0.1,
  exito_mensal:0.3
};

const tabela2 = {
  faixa_inicial:1001,
  faixa_final:10000,
  fee_mensal:0.08,
  exito_mensal:0.3
};

const tabela3 = {
  faixa_inicial:10001,
  faixa_final:50000,
  fee_mensal:0.06,
  exito_mensal:0.3
};

const tabela4 = {
  faixa_inicial:50001,
  faixa_final:100000,
  fee_mensal:0.04,
  exito_mensal:0.3
};

const tabela5 = {
  faixa_inicial:100001,
  faixa_final:500000,
  fee_mensal:0.03,
  exito_mensal:0.3
};

const tabela6 = {
  faixa_inicial:500001,
  fee_mensal:0.02,
  exito_mensal:0.3
};

const tabela_auxiliar = {
  economia_bruta:0.277,
  rca_inicial:1.1
};

let tabela = [tabela1,tabela2,tabela3,tabela4,tabela5,tabela6];

function getFee(valor){
  let fee =0;
  for(let x in tabela){
    if (tabela[x].faixa_inicial < valor)
      fee = tabela[x].fee_mensal;
  }
  return fee;
}

function getExito(valor){
  let exito =0;
  for(let x in tabela){
    if (tabela[x].faixa_inicial < valor)
      exito = tabela[x].exito_mensal;
  }
  return exito;
}
