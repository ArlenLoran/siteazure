<?php
$url = 'https://score-msc.mysupplychain.dhl.com/score_msc/external/V1/report/160590/run/sync?Content-Type=application%2Fjson&Accept=text%2Fcsv';

$data = array(
    'myQuery' => ["WITH nota_carreta  AS (
    select
    TRLR_ID,
    LISTAGG( NOTTXT, '
    '  ) WITHIN GROUP (ORDER BY NOTLIN  ) NOTTXT
 
    from TRLR_NOTE
    --WHERE TRLR_ID = 'TRL0550169'
    GROUP BY TRLR_ID
)
 
select
rci.invnum,
 tr.trlr_num, dsts.lngdsc trlr_stat, tr.trlr_broker, tr.driver_nam, tr.DRIVER_LIC_NUM, dstt.LNGDSC trlr_typ, TR.TRLR_ID ,
 ntc.NOTTXT , TR.YARD_LOC,  TR.TRACTOR_NUM, TR.TRLR_SEAL1, TR.TRLR_SEAL2, TR.TRLR_SEAL3
 FROM
rcvinv rci
left join RCVtrk rct on rci.TRKNUM = rct.TRKNUM
left join trlr tr on tr.trlr_id = rct.trlr_id
left join dscmst dsts on dsts.colval = tr.trlr_stat and dsts.colnam = 'trlr_stat' and dsts.locale_id = 'US_ENGLISH'
LEFT JOIN dscmst dstt ON dstt.colnam = 'trlr_typ' and dstt.LOCALE_ID = 'US_ENGLISH' and dstt.colval = tr.trlr_typ
left join nota_carreta ntc on ntc.TRLR_ID = tr.trlr_id
where
rci.invnum = '8802889342'
--trknum, client_id, invnum"],
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
