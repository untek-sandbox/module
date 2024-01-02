<?php

/**
 * @var $formRender \Untek\Component\Web\Form\Libs\FormRender
 * @var string $content
 */

?>

<?= $formRender->errors() ?>

<?= $formRender->beginFrom() ?>

<div class="form-group field-form-login required has-error">
    <?= $formRender->label('value') ?>
    <?= $formRender->input('value', 'text') ?>
    <?= $formRender->hint('value') ?>
</div>
<div class="form-group">
    <?= $formRender->input('save', 'submit') ?>
</div>

<?= $formRender->endFrom() ?>

<?= $content ?>
