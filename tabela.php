<?php
$url = 'https://score-msc.mysupplychain.dhl.com/score_msc/external/V1/report/160590/run/sync';

// Verifica se o número da nota foi enviado via POST
$invnum = isset($_POST['invnum']) ? $_POST['invnum'] : '8802889342'; // Valor padrão se não houver entrada

// Receber parâmetros de paginação
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$itemsPerPage = isset($_POST['itemsPerPage']) ? (int)$_POST['itemsPerPage'] : 10;
$offset = ($page - 1) * $itemsPerPage;

// Dados da consulta
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
        FROM rcvlin rcl
        LEFT JOIN invdtl ivd ON rcl.rcvkey = ivd.rcvkey
        LEFT JOIN invsub ivs ON ivs.subnum = ivd.subnum
        LEFT JOIN invlod ivl ON ivl.lodnum = ivs.lodnum
        LEFT JOIN prtdsc prd ON prd.locale_id = 'US_ENGLISH' AND prd.colval = rcl.prtnum || '|RBCCID|RCKT'
        LEFT JOIN rcvinv rci ON rci.invnum = rcl.invnum
        LEFT JOIN RCVtrk rct ON rci.TRKNUM = rct.TRKNUM
        LEFT JOIN trlr tr ON tr.trlr_id = rct.trlr_id
        LEFT JOIN dscmst dsts ON dsts.colval = tr.trlr_stat AND dsts.colnam = 'trlr_stat' AND dsts.locale_id = 'US_ENGLISH'
        WHERE rcl.invnum = '$invnum'
        LIMIT $itemsPerPage OFFSET $offset"],
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

    // Query para contar o total de itens
    $countQuery = "SELECT COUNT(*) as total FROM rcvlin WHERE invnum = '$invnum'";
    
    // Executar a consulta de contagem
    $countResult = mysqli_query($con, $countQuery);
    $totalItems = mysqli_fetch_assoc($countResult)['total'];

    // Exibir a resposta em formato JSON
    echo json_encode(['items' => $result, 'totalItems' => $totalItems]);
}
?>
