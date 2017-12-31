<?php
require_once('vendor/autoload.php');

/*****/
$cfg = new \stdClass();
$cfg->juz = 1;
$cfg->enEdition = 'en.pickthall';
$cfg->arEdition = 'quran-uthmani';
/*****/


$t = new \AlQuranCloud\ApiClient\Client();

$juz = $t->juz($cfg->juz, $cfg->arEdition);
$juzEn = $t->juz($cfg->juz, $cfg->enEdition);

$ayahs = $juz->data->ayahs;
$ayahsEn = $juzEn->data->ayahs;
$surahs = $juz->data->surahs;

$arCellStyle = array('valign' => 'center');
$enCellStyle = array('valign' => 'center');
//$arFontStyle = array('bold' => true, 'size' => '28', 'rtl' => true, 'name' => 'KFGQPC Uthman Taha Naskh');
$arFontStyle = array('bold' => true, 'size' => '28', 'rtl' => true);
$enFontStyle = array('bold' => true);
/**
$html = '<table>';

foreach($ayahs as $no => $ayah) {
    $html .= '<tr>';
    $html .= '<td>';
    $html .= $ayah->text;
    $html .= '</td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '<td>';
    $html .= $ayahsEn[$no]->text;
    $html .= '</td>';
    $html .= '</tr>';
}

$html .= '</table>';
*/

$phpWord = new \PhpOffice\PhpWord\PhpWord();
$section = $phpWord->addSection();
$header = array('size' => 16, 'bold' => true);
$section->addText('Basic table', $header);
$table = $section->addTable();
foreach ($ayahs as $no => $ayah) {
    $table->addRow();
    $table->addCell('10000', $arCellStyle)->addText($ayah->text .  '۝', $arFontStyle, ['align' => 'right']);
    $table->addRow();
    $table->addCell('10000', $enCellStyle)->addText($ayah->numberInSurah . ' ' . $ayahsEn[$no]->text, $enFontStyle);
}
// Saving the document as OOXML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save('quran.docx');


