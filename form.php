<?php

$lang = lang('en', 'de');
?>

<div class="content w-600 mw-full mx-auto">

<a class="btn btn-primary float-right" href="?lang=<?=lang('de', 'en')?>">
    <i class="ph ph-translate"></i>
    <?=lang('Deutsch', 'English')?>
</a>

    <h1><?= lang('Guest Form', 'Gast-Anmeldung') ?></h1>

    <p>
        <?= lang(
            'Welcome to the DSMZ Leibniz Institute. Please fill out the following form thoroughly, read the instructions and acknowledge their receipt.',
            'Willkommen beim Leibniz-Institut DSMZ. Bitte füllen Sie das folgende Formular gewissenhaft aus, lesen Sie die Belehrungen und bestätigen Sie deren Erhalt.'
        ) ?>
    </p>


    <form action="#" method="post">
        <p class="text-muted">ID: <?= $id ?></p>

        <input type="hidden" name="values[id]" value="<?= $id ?>">

        <h5 class="title"><?= lang('Guest information', 'Angaben zum Gast') ?></h5>

        <div class="form-group">
            <label for="first-name" class="required">Name</label>
            <div class="input-group" data-module="person">
                <input type="text" class="form-control flex-reset w-50" name="values[guest][academic_title]" id="academic-title" value="<?= $form['guest']['academic_title'] ?? '' ?>" placeholder="<?= lang('Title', 'Titel') ?>">
                <input type="text" class="form-control" name="values[guest][first]" id="first-name" value="<?= $form['guest']['first'] ?? '' ?>" required placeholder="<?= lang('First name', 'Vorname') ?>">
                <input type="text" class="form-control" name="values[guest][last]" id="last-name" value="<?= $form['guest']['last'] ?? '' ?>" required placeholder="<?= lang('Last name', 'Nachname') ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="guest-birthday" class="required"><?= lang('Date of Birth', 'Geburtstag') ?></label>
            <input type="date" class="form-control" name="values[guest][birthday]" id="guest-birthday" value="<?= $form['guest']['birthday'] ?? '' ?>" required>
        </div>


        <h5 class="title"><?= lang('Contact', 'Kontaktinformationen') ?></h5>

        <div class="form-group">
            <label for="guest-phone" class="element-other"><?= lang('Telephone', 'Telefon') ?></label>
            <input type="text" class="form-control" name="values[guest][phone]" id="guest-phone" value="<?= $form['guest']['phone'] ?? '' ?>">
        </div>

        <div class="form-group">
            <label for="guest-mail" class="required"><?= lang('E-Mail', 'E-Mail') ?></label>
            <input type="text" class="form-control" name="values[guest][mail]" id="guest-mail" value="<?= $form['guest']['mail'] ?? '' ?>" required>
        </div>

        <div class="form-group">
            <label for="guest-accomodation" class="element-other"><?= lang('Accomodation during stay', 'Unterkunftsadresse während des Aufenthalts') ?></label>
            <input type="text" class="form-control" name="values[guest][accomodation]" id="guest-accomodation" value="<?= $form['guest']['accomodation'] ?? '' ?>">
        </div>


        <h5 class="title"><?= lang('Company / University', 'Firma / Universität / Schule') ?></h5>

        <div class="form-group">
            <label for="guest-affiliation" class="required"><?= lang('Name', 'Name') ?></label>
            <input type="text" class="form-control" name="values[affiliation][name]" id="guest-affiliation" value="<?= $form['affiliation']['name'] ?? '' ?>" required>
        </div>

        <div class="form-group">
            <label for="guest-address" class="required"><?= lang('Address', 'Anschrift') ?></label>
            <input type="text" class="form-control" name="values[affiliation][address]" id="guest-address" value="<?= $form['affiliation']['address'] ?? '' ?>" required>
        </div>

        <div class="form-group">
            <label for="guest-country" class="required"><?= lang('Country', 'Land') ?></label>
            <input type="text" class="form-control" name="values[affiliation][country]" id="guest-country" value="<?= $form['affiliation']['country'] ?? '' ?>" required>
        </div>


        <h5 class="title"><?= lang('Details of the stay', 'Details zum Aufenthalt') ?></h5>
        <p class="text-muted">
            <?= lang('These details were provided by the supervisor.', 'Diese Details wurden bereits vom Betreuer ausgefüllt.') ?>
        </p>

        <table class="table  mb-20">
            <tbody>
                <tr>
                    <td><?= lang('Time frame of the stay', 'Dauer des Aufenthalts') ?></td>
                    <td><?= fromToDate($form['start'] ?? null, $form['end'] ?? null) ?></td>
                </tr>
                <tr>
                    <td><?= lang('Responsible Scientist at the ' . AFFILIATION, 'Verantwortliche/r Wissenschaftler/in von ' . AFFILIATION) ?></td>
                    <td><?= $form['supervisor']['name'] ?? 'unknown' ?></td>
                </tr>
                <tr>
                    <td><?= lang('Title / Topic / Description', 'Titel / Thema / Beschreibung') ?></td>
                    <td><?= $form['title'] ?? 'unknown' ?></td>
                </tr>
                <tr>
                    <td><?= lang('Purpose of stay', 'Zweck des Aufenthalts') ?></td>
                    <td><?= $form['category'] ?? 'unknown' ?></td>
                </tr>
                <tr>
                    <td><?= lang('The visit is financed by', 'Die Finanzierung erfolgt') ?></td>
                    <td><?= $form['payment'] ?? 'unknown' ?></td>
                </tr>
            </tbody>
        </table>


        <h5 class="title"><?= lang('Legal Instructions', 'Belehrungen') ?></h5>

        <div class="form-group">
            <div class="custom-checkbox">
                <input type="checkbox" id="checkbox-2" value="true" name="values[legal][data_security]" <?= ($form['legal']['data_security'] ?? false) ? 'checked' : '' ?> required>
                <label for="checkbox-2">
                    <?php if ($lang == 'de') { ?>
                        Ich habe die <a href="data/Datenschutz.pdf">Rechtsbelehrung zum Datenschutz</a> zur Kenntnis genommen.
                    <?php } else { ?>
                        I have acknowledged the <a href="data/Data protection.pdf">legal notice on data protection</a>.
                    <?php } ?>
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="custom-checkbox">
                <input type="checkbox" id="checkbox-3" value="true" name="values[legal][data_protection]" <?= ($form['legal']['data_protection'] ?? false) ? 'checked' : '' ?> required>
                <label for="checkbox-3">
                    <?php if ($lang == 'de') { ?>
                        Ich habe die <a href="data/Datensicherheit.pdf">Rechtsbelehrung zur Datensicherheit</a> zur Kenntnis genommen.
                    <?php } else { ?>
                        I have acknowledged the <a href="data/Data security.pdf">legal notice on data security</a>.
                    <?php } ?>
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="custom-checkbox">
                <input type="checkbox" id="checkbox-4" value="true" name="values[legal][safety_instruction]" <?= ($form['legal']['safety_instruction'] ?? false) ? 'checked' : '' ?> required>
                <label for="checkbox-4">
                    <?php if ($lang == 'de') { ?>
                        Ich habe die <a href="data/Sicherheitsbelehrung_A4.pdf">Sicherheitsbelehrung für Kurzzeitgäste</a> zur Kenntnis genommen.
                    <?php } else { ?>
                        I have acknowledged the <a href="data/Safety Instructions_A4.pdf">safety instructions for short-time guests</a>.
                    <?php } ?>
                </label>
            </div>
        </div>


        <div class="form-group">
            <div class="custom-checkbox">
                <input type="checkbox" id="checkbox-1" value="true" name="values[legal][general]" <?= ($form['legal']['general'] ?? false) ? 'checked' : '' ?> required>
                <label for="checkbox-1">
                    <?php if (lang('en', 'de') == 'de') { ?>
                        Ich verpflichte mich, die in der DSMZ bestehende Sicherheitsordnung sowie die übrigen betrieblichen Regelungen zu beachten. Die „Sicherheitsbelehrung“ der DSMZ habe ich in schriftlicher Form erhalten und werde diese befolgen. Ich verpflichte mich ferner, die mir in dem genannten Zeitraum bekannt werdenden Mitteilungen, Messprotokolle, Beschreibungen, Verfahren usw., soweit sie wirtschaftlich verwertbar sind, vertraulich zu behandeln und sie keinem Dritten bekannt zu geben.

                        Von entsprechenden Informationen werde ich weder persönlich noch durch Firmen gewerblich Gebrauch machen, d.h. sie weder direkt noch indirekt verwerten, es sei denn auf Grund einer ausdrücklichen Vereinbarung mit der DSMZ. Diese Verpflichtung entfällt, soweit die genannten Mitteilungen nachweislich schon infolge von Publikationen Gemeingut sind bzw. werden, oder mir nachweislich von anderer Seite bekannt werden, ohne direkt oder indirekt von der DSMZ zu stammen.
                    <?php } else { ?>
                        I assure to observe DSMZ-security rules and other internal regulations. I have received the written “Safety Instructions of DSMZ”. Furthermore, I assure to treat confidential the information, results of measurements, descriptions, procedures, etc., as far as they are commercially usable. I will not announce them to any third party.

                        I will not use the achieved information for commercial purposes, neither personally nor by any company. I will not use them directly or indirectly, unless DSMZ has given the explicit permission.

                        This obligation is not applicable if the information has already been announced by publications or has provable been made known to me from third parties without deriving directly or indirectly from DSMZ.
                    <?php } ?>
                </label>
            </div>
        </div>


        <button type="submit" class="btn btn-primary">
            <?= lang('Submit my data', 'Meine Daten übermitteln') ?>
        </button>

    </form>

</div>