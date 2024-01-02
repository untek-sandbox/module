<?php

/**
 * @var array $dumps
 * @var View $this
 * @var string $content
 * @var $formRender FormRender
 */

use Untek\Component\Web\Form\Libs\FormRender;
use Untek\Lib\Web\View\Libs\View;

?>

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