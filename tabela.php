<?php
$url = 'https://score-msc.mysupplychain.dhl.com/score_msc/external/V1/report/160590/run/sync?Content-Type=application%2Fjson&Accept=text%2Fcsv';

$data = array(
    'myQuery' => ["select ivs.lodnum, ivl.stoloc, rcl.prtnum, rcl.lotnum, rcl.rcvqty, 'cs' uom, prd.LNGDSC descricao, rcl.rcvsts, ivd.expire_dte, rcl.invnum FROM rcvlin rcl LEFT JOIN invdtl ivd ON rcl.rcvkey = ivd.rcvkey LEFT JOIN invsub ivs ON ivs.subnum = ivd.subnum LEFT JOIN invlod ivl ON ivl.lodnum = ivs.lodnum LEFT JOIN prtdsc prd ON prd.locale_id = 'US_ENGLISH' AND prd.colval = rcl.prtnum || '|RBCCID|RCKT' WHERE rcl.invnum = '8802889342'"],
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
    echo json_encode(["error" => "Erro na requisição"]);
} else {
    $rows = str_getcsv($response, "\n");
    $dataArray = [];
    foreach ($rows as $row) {
        $dataArray[] = str_getcsv($row);
    }
    
    // Retorna os dados em formato JSON
    echo json_encode($dataArray);
}
?>
