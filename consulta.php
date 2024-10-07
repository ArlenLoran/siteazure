<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os dados do JSON recebido
    $data = json_decode(file_get_contents('php://input'), true);
    $invoice = $data['invoice'] ?? '';

    // Defina a URL da API
    $url = 'https://score-msc.mysupplychain.dhl.com/score_msc/external/V1/report/160590/run/sync';

    // Prepare os dados da consulta
    $query = "WITH nota_carreta AS (
        SELECT
            TRLR_ID,
            LISTAGG(NOTTXT, '
            ') WITHIN GROUP (ORDER BY NOTLIN) NOTTXT
        FROM TRLR_NOTE
        GROUP BY TRLR_ID
    )
    SELECT
        rci.invnum,
        tr.trlr_num,
        TR.TRCTOR_NUM
    FROM
        rcvinv rci
    LEFT JOIN RCVtrk rct ON rci.TRKNUM = rct.TRKNUM
    LEFT JOIN trlr tr ON tr.trlr_id = rct.trlr_id
    WHERE
        rci.invnum = '{$invoice}'";

    $data = array('myQuery' => [$query]);

    $user = 'arbarret';
    $password = '3KT8zx203@Brasil1';
    $credenciais = $user . ':' . $password;
    $credenciaisBase64 = base64_encode($credenciais);

    $headers = array(
        'Authorization: Basic ' . $credenciaisBase64,
        'Content-Type: application/json',
        'Accept: text/csv' // Mudamos para text/csv
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
        // Converter CSV para array
        $lines = explode(PHP_EOL, $response);
        $header = str_getcsv(array_shift($lines));
        $result = [];

        foreach ($lines as $line) {
            if (!empty($line)) {
                $result[] = array_combine($header, str_getcsv($line));
            }
        }

        // Busca pela placa
        $tractorNum = null;
        foreach ($result as $row) {
            if ($row['INVNUM'] == $invoice) {
                $tractorNum = $row['TRACTOR_NUM'];
                break;
            }
        }

        echo json_encode(['tractorNum' => $tractorNum]);
    }
}
?>
