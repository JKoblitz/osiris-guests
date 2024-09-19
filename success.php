<?php
/**
 * Success message after form submission
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
?>
<div class="container">
    <div class="content text-center">
        <h1>
            <?= lang('Welcome to',  "Wilkommen an der") ?>
            <?= AFFILIATION ?>
        </h1>
        <img src="<?= ROOTPATH ?>/img/success.svg" alt="" class="img-fluid" style="max-width: 50rem;">
        <p class="lead">
            <?= lang('Form was submitted successfully. Thank you.',  "Formular wurde erfolgreich übermittelt. Vielen Dank.") ?>
        </p>
        <div class="footer position-absolute bottom-0 font-size-12">
            <a href="https://www.freepik.com/free-vector/completed-concept-illustration_10117884.htm#query=flat%20submitted&position=16&from_view=search&track=ais">Image by storyset</a> on Freepik
        </div>
    </div>
</div>