<?php
    use Joomla\CMS\Date\Date;
    use Joomla\CMS\Language\Text;
    $apotheke = $displayData;
    $name = $apotheke->apothekenName;
    $strasse = $apotheke->strasse;
    $ort = $apotheke->plz;
    $tel = $apotheke->telefon;
?>

<ul class="apothekenAusgabe">
    <li>Name: <?= $name; ?></li>
    <li>Strasse: <?= $strasse; ?></li>
    <li>Ort: <?= $ort; ?></li>
    <li>Telefon: <?= $tel; ?></li>
</ul>

