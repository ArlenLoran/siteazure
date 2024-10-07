<?php
$url = 'https://score-msc.mysupplychain.dhl.com/score_msc/external/V1/report/160590/run/sync?Content-Type=application%2Fjson&Accept=text%2Fcsv';

$data = array(
    'myQuery' => [
        "WITH nota_carreta AS (
            SELECT
                TRLR_ID,
                LISTAGG(NOTTXT, '
                ') WITHIN GROUP (ORDER BY NOTLIN) AS NOTTXT
            FROM TRLR_NOTE
            GROUP BY TRLR_ID
        )
        SELECT
            rci.invnum,
            tr.trlr_num,
            dsts.lngdsc AS trlr_stat,
            tr.trlr_broker,
            tr.driver_nam,
            tr.DRIVER_LIC_NUM,
            dstt.LNGDSC AS trlr_typ,
            tr.TRL_ID,
            ntc.NOTTXT,
            tr.YARD_LOC,
            tr.TRACTOR_NUM,
            tr.TRL_SEAL1,
            tr.TRL_SEAL2,
            tr.TRL_SEAL3
        FROM
            rcvinv rci
        LEFT JOIN RCVtrk rct ON rci.TRKNUM = rct.TRKNUM
        LEFT JOIN trlr tr ON tr.trlr_id = rct.trlr_id
        LEFT JOIN dscmst dsts ON dsts.colval = tr.trlr_stat AND dsts.colnam = 'trlr_stat' AND dsts.locale_id = 'US_ENGLISH'
        LEFT JOIN dscmst dstt ON dstt.colnam = 'trlr_typ' AND dstt.LOCALE_ID = 'US_ENGLISH' AND dstt.colval = tr.trlr_typ
        LEFT JOIN nota_carreta ntc ON ntc.TRLR_ID = tr.trlr_id
        WHERE
            rci.invnum = '8802889342'"
    ],
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
        'ignore_errors' => true, // Permite capturar respostas de erro (por exemplo, 400 ou 500)
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
