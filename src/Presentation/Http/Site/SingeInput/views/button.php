<?php

/**
 * @var $formRender \Untek\Component\Web\Form\Libs\FormRender
 * @var string $content
 */

?>

<?= $formRender->errors() ?>

<?= $formRender->beginFrom() ?>

<div class="form-group">
    <?= $formRender->input('save', 'submit') ?>
</div>

<?= $formRender->endFrom() ?>

<?= $content ?>
