<?php

/**
 * @var View $view
 * @var $formRender FormRender
 */

use Untek\Component\Web\Form\Libs\FormRender;
use Untek\Lib\Web\View\Libs\View;

$formView = $formRender->getFormView();
$formHtml = '';
foreach ($formView->children as $name => $type) {
    if ($name != 'save') {
        $formHtml .= $formRender->row($name);
    }
}

?>

<?= $formRender->errors() ?>

<?= $formRender->beginFrom() ?>

<?= $formHtml ?>

<div class="form-group">
    <?= $formRender->input('save', 'submit') ?>
</div>

<?= $formRender->endFrom() ?>
