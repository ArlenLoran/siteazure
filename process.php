<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $invoice_number = $_POST['invoice_number'];

    $url = 'https://score-msc.mysupplychain.dhl.com/score_msc/external/V1/report/160590/run/sync?Content-Type=application%2Fjson&Accept=text%2Fcsv';

    $data = array(
        'myQuery' => ["WITH nota_carreta AS (
            SELECT
            TRLR_ID,
            LISTAGG(NOTTXT, '\n') WITHIN GROUP (ORDER BY NOTLIN) NOTTXT
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
            TR.TRLR_ID,
            ntc.NOTTXT,
            TR.YARD_LOC,
            TR.TRACTOR_NUM,
            TR.TRLR_SEAL1,
            TR.TRLR_SEAL2,
            TR.TRLR_SEAL3
        FROM
            rcvinv rci
            LEFT JOIN RCVtrk rct ON rci.TRKNUM = rct.TRKNUM
            LEFT JOIN trlr tr ON tr.trlr_id = rct.trlr_id
            LEFT JOIN dscmst dsts ON dsts.colval = tr.trlr_stat AND dsts.colnam = 'trlr_stat' AND dsts.locale_id = 'US_ENGLISH'
            LEFT JOIN dscmst dstt ON dstt.colnam = 'trlr_typ' AND dstt.LOCALE_ID = 'US_ENGLISH' AND dstt.colval = tr.trlr_typ
            LEFT JOIN nota_carreta ntc ON ntc.TRLR_ID = tr.trlr_id
        WHERE
            rci.invnum = '{$invoice_number}'"
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
        // Tente fazer o parsing da resposta JSON
        $responseData = json_decode($response, true);

        if (is_array($responseData) && !empty($responseData)) {
            // Supondo que a resposta contém um array de resultados
            $tractorNum = null;

            // Percorre os resultados para encontrar a placa
            foreach ($responseData as $item) {
                if (isset($item['TRACTOR_NUM'])) {
                    $tractorNum = $item['TRACTOR_NUM'];
                    break; // Encontre a primeira ocorrência e pare
                }
            }

            echo json_encode(['TR' => ['TRACTOR_NUM' => $tractorNum]]);
        } else {
            echo json_encode(['error' => 'Resposta vazia ou inválida']);
        }
    }
} else {
    echo json_encode(['error' => 'Método não permitido']);
}
?>
