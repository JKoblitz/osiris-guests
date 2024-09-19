<?php
/**
 * Main form file to be filles out by the guest
 * 
 * This file is part of the OSIRIS package.
 * Copyright (c) 2024 Julia Koblitz, OSIRIS Solutions GmbH
 *
 * @package     OSIRIS Guest Forms
 * @since       0.1.0
 * 
 * @copyright	Copyright (c) 2024 Julia Koblitz, OSIRIS Solutions GmbH
 * @author		Julia Koblitz <julia.koblitz@osiris-solutions.de>
 * @license     MIT
 */

$lang = lang('en', 'de');
?>

<div class="content">

    <a class="btn btn-primary float-right" href="?lang=<?= lang('de', 'en') ?>">
        <?= lang('Deutsch', 'English') ?>
    </a>

    <h1><?= lang('Guest Form', 'Gast-Anmeldung') ?></h1>

    <p>
        <?= lang(
            INTRODUCTION_EN,
            INTRODUCTION_DE
        ) ?>
    </p>


    <form action="#" method="post">
        <small class="text-muted">ID: <?= $id ?></small>

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
                        Ich habe die <a target="_blank" href="data/Datenschutz.pdf">Rechtsbelehrung zum Datenschutz</a> zur Kenntnis genommen.
                    <?php } else { ?>
                        I have acknowledged the <a target="_blank" href="data/Data protection.pdf">legal notice on data protection</a>.
                    <?php } ?>
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="custom-checkbox">
                <input type="checkbox" id="checkbox-3" value="true" name="values[legal][data_protection]" <?= ($form['legal']['data_protection'] ?? false) ? 'checked' : '' ?> required>
                <label for="checkbox-3">
                    <?php if ($lang == 'de') { ?>
                        Ich habe die <a target="_blank" href="data/Datensicherheit.pdf">Rechtsbelehrung zur Datensicherheit</a> zur Kenntnis genommen.
                    <?php } else { ?>
                        I have acknowledged the <a target="_blank" href="data/Data security.pdf">legal notice on data security</a>.
                    <?php } ?>
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="custom-checkbox">
                <input type="checkbox" id="checkbox-4" value="true" name="values[legal][safety_instruction]" <?= ($form['legal']['safety_instruction'] ?? false) ? 'checked' : '' ?> required>
                <label for="checkbox-4">
                    <?php if ($lang == 'de') { ?>
                        Ich habe die <a target="_blank" href="data/Sicherheitsbelehrung_A4.pdf">Sicherheitsbelehrung für Kurzzeitgäste</a> zur Kenntnis genommen.
                    <?php } else { ?>
                        I have acknowledged the <a target="_blank" href="data/Safety Instructions_A4.pdf">safety instructions for short-time guests</a>.
                    <?php } ?>
                </label>
            </div>
        </div>


        <div class="form-group">
            <div class="custom-checkbox">
                <input type="checkbox" id="checkbox-1" value="true" name="values[legal][general]" <?= ($form['legal']['general'] ?? false) ? 'checked' : '' ?> required>
                <label for="checkbox-1">
                    <?= lang(CONTENT_LEGAL_EN, CONTENT_LEGAL_DE) ?>
                </label>
            </div>
        </div>


        <button type="submit" class="btn btn-primary">
            <?= lang('Submit my data', 'Meine Daten übermitteln') ?>
        </button>

    </form>

</div>