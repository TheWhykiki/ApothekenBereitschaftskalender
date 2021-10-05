<?php
    use Joomla\CMS\Date\Date;
    use Joomla\CMS\Language\Text;

    // Sprache setzen für Datum

    setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
    strftime("%A, der %e. %B %G", strtotime("now"));

    extract($displayData);

    $name1 = $apotheke1->apothekenName;
    $strasse1 = $apotheke1->strasse;
    $ort1 = $apotheke1->plz;
    $tel1 = $apotheke1->telefon;

    if(!empty($apotheke2))
    {
        $name2 = $apotheke2->apothekenName;
        $strasse2 = $apotheke2->strasse;
        $ort2 = $apotheke2->plz;
        $tel2 = $apotheke2->telefon;
    }


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
                <h4 class="uk-heading"><?= $name1; ?></h4>
            </li>
            <li>
                <span uk-icon="location"></span><?= $strasse1; ?>, <?= $ort1; ?>
            </li>
            <li>
                <a href="tel:<?= $tel1; ?>">
                    <span uk-icon="receiver"></span>
                    <?= $tel1; ?>
                </a>
            </li>
        </ul>
        <?php if(!empty($apotheke2)): ?>
        <ul class="uk-list">
            <li>
                <h4 class="uk-heading"><?= $name2; ?></h4>
            </li>
            <li>
                <span uk-icon="location"></span><?= $strasse2; ?>, <?= $ort2; ?>
            </li>
            <li>
                <a href="tel:<?= $tel2; ?>">
                    <span uk-icon="receiver"></span>
                    <?= $tel2; ?>
                </a>
            </li>
        </ul>
        <?php endif; ?>

    </div>
    <div class="uk-card-footer">
    </div>
</div>


