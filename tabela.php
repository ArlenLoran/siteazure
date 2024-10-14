<?php
$url = 'https://score-msc.mysupplychain.dhl.com/score_msc/external/V1/report/160590/run/sync';

// Verifica se o número da nota foi enviado via POST
$invnum = isset($_POST['invnum']) ? $_POST['invnum'] : '8802889342'; // Valor padrão se não houver entrada

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
SUM(rcl.rcvqty) OVER (PARTITION BY rcl.invnum, rcl.prtnum) AS total,
rcl.supnum,
rci.waybil, tr.trlr_num, dsts.lngdsc trlr_stat
 FROM
rcvlin rcl
left join invdtl ivd on rcl.rcvkey =  ivd.rcvkey
left join invsub ivs on ivs.subnum = ivd.subnum
left join invlod ivl on ivl.lodnum = ivs.lodnum
left join prtdsc prd on  prd.locale_id = 'US_ENGLISH' and prd.colval = rcl.prtnum || '|RBCCID|RCKT'
left join rcvinv rci on rci.invnum = rcl.invnum
left join RCVtrk rct on rci.TRKNUM = rct.TRKNUM
left join trlr tr on tr.trlr_id = rct.trlr_id
left join dscmst dsts on dsts.colval = tr.trlr_stat and dsts.colnam = 'trlr_stat' and dsts.locale_id = 'US_ENGLISH'
 
where
rcl.invnum = '$invnum'"],
    'body' => ['']
);

$user = 'arbarret';
$password = '3KT8zx203@Brasil1';
$credenciais = $user . ':' . $password;
$credenciaisBase64 = base64_encode($credenciais);

$headers = array(
    'Authorization: Basic ' . $credenciaisBase64,
    'Content-Type: application/json',
    'Accept: text/csv'
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
    echo json_encode(['error' => 'Erro na requisição']);
} else {
    // Converter CSV para JSON
    $lines = explode(PHP_EOL, trim($response));
    $header = str_getcsv(array_shift($lines));
    $result = [];

    foreach ($lines as $line) {
        if (empty(trim($line))) {
            continue; // Ignorar linhas vazias
        }
        $data = str_getcsv($line);
        $result[] = array_combine($header, $data);
    }

    // Exibir a resposta em formato JSON
    echo json_encode($result);
}
?>
