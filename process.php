<?php
$url = 'https://score-msc.mysupplychain.dhl.com/score_msc/external/V1/report/160590/run/sync';

$data = array(
    'myQuery' => ["select
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
--trknum, client_id, invnum"],
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
    // Converter CSV para JSON
    $lines = explode(PHP_EOL, $response);
    $header = str_getcsv(array_shift($lines));
    $result = [];

    foreach ($lines as $line) {
        if (!empty($line)) {
            $result[] = array_combine($header, str_getcsv($line));
        }
    }

    // Exibir a resposta em formato JSON
    echo json_encode($result);
}
?>
