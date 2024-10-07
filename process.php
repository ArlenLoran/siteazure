<?php
// Supondo que você já tenha uma conexão com o banco de dados estabelecida
$query = "
WITH nota_carreta AS (
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
    rci.invnum = '8802889342'
";

// Executar a consulta
$result = $db->query($query);

if ($result) {
    // Armazenar os dados em um array
    $data = [];
    
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    // Transformar em JSON
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Erro ao executar a consulta.']);
}
?>
