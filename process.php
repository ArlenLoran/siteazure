<?php
$url = 'https://score-msc.mysupplychain.dhl.com/score_msc/external/V1/report/160590/run/sync?Content-Type=application%2Fjson&Accept=text%2Fcsv';

$data = array(
    'myQuery' => ["WITH nota_carreta  AS (
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

$response = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = file_get_contents($url, false, $context);
    
    if ($response !== FALSE) {
        $responseData = json_decode($response, true);
        // Supondo que a resposta seja um array e você esteja buscando TR.TRACTOR_NUM
        $tractorNum = $responseData['data'][0]['TRACTOR_NUM'] ?? 'Não encontrado'; // Ajuste conforme a estrutura da resposta
    } else {
        $tractorNum = "Erro na requisição";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Veículo</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="query" placeholder="Digite sua pesquisa" required>
        <button type="submit">Pesquisar</button>
    </form>

    <?php if (isset($tractorNum)): ?>
        <input type="text" value="<?php echo htmlspecialchars($tractorNum); ?>" readonly placeholder="Placa do veículo">
    <?php endif; ?>
</body>
</html>
