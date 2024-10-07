<?php
  $url = 'https://score-msc.mysupplychain.dhl.com/score_msc/external/V1/report/160590/run/sync?Content-Type=application%2Fjson&Accept=text%2Fcsv';
 
  $data = array(
      'myQuery' => ['select
ivs.lodnum,
ivl.stoloc,
rcl.prtnum,
rcl.lotnum,
rcl.rcvqty,
'cs' uom,
prd.LNGDSC descricao,
rcl.rcvsts,
ivd.expire_dte,
--peso ta faltando--
rcl.invnum,
SUM(rcl.rcvqty) OVER (PARTITION BY rcl.invnum, rcl.prtnum) AS total
 FROM
rcvlin rcl
left join invdtl ivd on rcl.rcvkey =  ivd.rcvkey
left join invsub ivs on ivs.subnum = ivd.subnum
left join invlod ivl on ivl.lodnum = ivs.lodnum
left join prtdsc prd on  prd.locale_id = 'US_ENGLISH' and prd.colval = rcl.prtnum || '|RBCCID|RCKT'
where
invnum = '8802889342'
--trknum, client_id, invnum'],
      'body' => ['']
  );
 
  $user = 'arbarret';
  $password = '3KT8zx203@Brasil1';
  $credenciais = $user . ':' . $password;
  $credenciaisBase64 = base64_encode($credenciais);
 
  $headers = array(
    'Authorization: Basic ' . $credenciaisBase64,
    'Content-Type: application/json'
  );
 
  // Configurar o contexto HTTP com a requisição POST
  $options = array(
      'http' => array(
          'header'  => $headers,
          'method'  => 'POST',
          'content' => json_encode($data), // Converte o array de dados para JSON
          'ignore_errors' => true, // Isso permite capturar respostas de erro (por exemplo, 400 ou 500)
      )
  );
 
  $context = stream_context_create($options);
 
  // Fazer a requisição HTTP
  $response = file_get_contents($url, false, $context);
 
  if ($response === FALSE) {
      // Tratar o erro
      echo "Erro na requisição";
  } else {
      // Exibir a resposta
      echo $response;
  }
  ?>
