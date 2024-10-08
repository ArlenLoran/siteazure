<?php
$url = 'https://score-msc.mysupplychain.dhl.com/score_msc/external/V1/report/160590/run/sync';

$data = array(
    'myQuery' => ["WITH nota_carreta AS (
    select
    TRLR_ID,
    LISTAGG( NOTTXT, '
    '  ) WITHIN GROUP (ORDER BY NOTLIN  ) NOTTXT
    from TRLR_NOTE
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
rci.invnum = '8802889342'"],
    'body' => ['']
);

$user = 'arbarret';
$password = '3KT8zx203@Brasil1';
$credenciais = $user . ':' . $password;
$credenciaisBase64 = base64_encode($credenciais);

$headers = array(
    'Authorization: Basic ' . $credenciaisBase64,
    'Content-Type: application/json',
    'Accept: text/csv' // Aqui, mudamos para text/csv
);

$options = array(
    'http' => array(
        'header'  => $headers,
        'method'  => 'POST',
        'content' => json_encode($data),
        'ignore_errors' => true,
    )
);

$context = stream_context_create($options);

$response = file_get_contents($url, false, $context);

if ($response === FALSE) {
    echo "Erro na requisição";
} else {
    // Converter CSV para JSON e retornar apenas a coluna ntc.NOTTXT
    $lines = explode(PHP_EOL, $response);
    $header = str_getcsv(array_shift($lines));
    $result = [];

    foreach ($lines as $line) {
        if (!empty($line)) {
            $row = array_combine($header, str_getcsv($line));
            // Adiciona apenas ntc.NOTTXT ao resultado
            $result[] = $row['ntc.NOTTXT']; // Certifique-se de que o nome da coluna está correto
        }
    }

    // Exibir a resposta em formato JSON
    echo json_encode($result);
}
?>
