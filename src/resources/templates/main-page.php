<?php

/**
 * @var array $modules
 */

?>

<h1>
    Sandbox
</h1>

<ul>
    <?php foreach ($modules as $module): ?>
        <li>
            <?= $module['pureName'] ?>
        </li>
        <?php if (!empty($module['controllers'])): ?>
            <ul>
                <?php foreach ($module['controllers'] as $controller): ?>
                    <li>
                        <a href="<?= $controller['uri'] ?>">
                            <?= $controller['title'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
