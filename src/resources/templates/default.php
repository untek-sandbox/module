<?php

/**
 * @var array $dumps
 * @var View $this
 * @var string $content
 * @var string $title
 * @var $formRender FormRender
 */

use Untek\Component\Web\Form\Libs\FormRender;
use Untek\Lib\Web\View\Libs\View;

?>

<?php if (!empty($title)): ?>
    <h1>
        <?= $title ?>
    </h1>
<?php endif; ?>

<?php
if (isset($formRender)) {
    echo $this->renderFile(__DIR__ . '/form.php', [
        'formRender' => $formRender,
    ]);
}
?>

<?php if (!empty($content)): ?>
    <?= $content ?>
<?php endif; ?>

<?php
if (isset($dumps)) {
    foreach ($dumps as $dump) {
        dump($dump);
    }
}
?>