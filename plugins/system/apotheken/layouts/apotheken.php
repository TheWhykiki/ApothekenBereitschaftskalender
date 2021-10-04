<?php
    use Joomla\CMS\Date\Date;
    use Joomla\CMS\Language\Text;

    // Sprache setzen für Datum

    setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
    strftime("%A, der %e. %B %G", strtotime("now"));

    $apotheke = $displayData;
    $name = $apotheke->apothekenName;
    $strasse = $apotheke->strasse;
    $ort = $apotheke->plz;
    $tel = $apotheke->telefon;
    $heute = strftime("%A, den %e. %B %G", strtotime("now"));
    $morgen = strftime("%A, den %e. %B %G", strtotime("now +1day"));
?>
<div class="uk-card uk-card-default uk-width-1-2@m">
    <div class="uk-card-header">
        <div class="uk-grid-small uk-flex-middle" uk-grid>
            <div class="uk-width-expand">
                <h3 class="uk-card-title uk-margin-remove-bottom">Apotheken Bereitschaft für</h3>
                <?= $heute; ?> 8:00 Uhr - <?= $morgen; ?> 8:00 Uhr
            </div>
        </div>
    </div>
    <div class="uk-card-body">
        <ul class="uk-list">
            <li>
                <h4 class="uk-heading"><?= $name; ?></h4>
            </li>
            <li>
                <span uk-icon="location"></span><?= $strasse; ?>, <?= $ort; ?>
            </li>
            <li>
                <a href="tel:<?= $tel; ?>">
                    <span uk-icon="receiver"></span>
                    <?= $tel; ?>
                </a>
            </li>
        </ul>
    </div>
    <div class="uk-card-footer">
    </div>
</div>


