<?php
$url = 'https://score-msc.mysupplychain.dhl.com/score_msc/external/V1/report/160590/run/sync?Content-Type=application%2Fjson&Accept=text%2Fcsv';

$data = array(
    'myQuery' => ["
    WITH  resumo AS (
 
select
rcl.prtnum, --SKU
 
SUM(rcl.EXPQTY)  EXPQTY_tt, --QUANTIDADE ESPERADA TOTAL
SUM(rcl.IDNQTY)  IDNQTY_tt, --QUANTIDADE IDENTIFICADA TOTAL
rcl.invnum
 FROM
rcvlin rcl
 
left join prtdsc prd on  prd.locale_id = 'US_ENGLISH' and prd.colval = rcl.prtnum || '|RBCCID|RCKT'
left join rcvinv rci on rci.invnum = rcl.invnum
left join RCVtrk rct on rci.TRKNUM = rct.TRKNUM
left join trlr tr on tr.trlr_id = rct.trlr_id
left join dscmst dsts on dsts.colval = tr.trlr_stat and dsts.colnam = 'trlr_stat' and dsts.locale_id = 'US_ENGLISH'
left join dscmst dsis  on dsis.colnam = 'invsts' and dsis.colval = rcl.rcvsts AND dsis.LOCALE_ID = 'US_ENGLISH'
 
 GROUP BY rcl.invnum, rcl.prtnum
 )
 
 
select distinct
ivs.lodnum, --LPN
rcl.prtnum, --SKU
ivl.stoloc, --LOCAL
rcl.lotnum, --LOTE
rcl.rcvqty, --QUANTIDADE
dsis.LNGDSC rcvsts, --STATUS
TO_CHAR(ivd.expire_dte, 'DD/MM/YYYY'), --DATA DE VENCIMENTO
RCL.EXPQTY,
RCL.IDNQTY,
 RESUMO.EXPQTY_tt, --QUANTIDADE ESPERADA TOTAL
RESUMO.IDNQTY_tt, --QUANTIDADE IDENTIFICADA TOTAL
'cs' uom,
prd.LNGDSC descricao, --DESCRIÇÃO DO SKU
--rcl.rcvsts,
rcl.invnum,
SUM(rcl.rcvqty) OVER (PARTITION BY rcl.invnum, rcl.prtnum) AS total,
--rcl.supnum,
rci.waybil, tr.trlr_num, dsts.lngdsc trlr_stat
 FROM
rcvlin rcl
LEFT JOIN resumo ON RESUMO.invnum  = rcl.invnum AND RESUMO.PRTNUM = rcl.prtnum
left join invdtl ivd on rcl.rcvkey =  ivd.rcvkey
left join invsub ivs on ivs.subnum = ivd.subnum
left join invlod ivl on ivl.lodnum = ivs.lodnum
left join prtdsc prd on  prd.locale_id = 'US_ENGLISH' and prd.colval = rcl.prtnum || '|RBCCID|RCKT'
left join rcvinv rci on rci.invnum = rcl.invnum
left join RCVtrk rct on rci.TRKNUM = rct.TRKNUM
left join trlr tr on tr.trlr_id = rct.trlr_id
left join dscmst dsts on dsts.colval = tr.trlr_stat and dsts.colnam = 'trlr_stat' and dsts.locale_id = 'US_ENGLISH'
left join dscmst dsis  on dsis.colnam = 'invsts' and dsis.colval = rcl.rcvsts AND dsis.LOCALE_ID = 'US_ENGLISH'
 
where
rcl.invnum = '8802820568'
 
order by
rcl.prtnum
    "],
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
