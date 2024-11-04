<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Untek\Component\Web\TwBootstrap\Widgets\TabContent\TabContentWidget;
use Untek\Sandbox\Module\Presentation\Http\Site\Controllers\MainPageController2;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services()->defaults()->public()->autowire()->autoconfigure();
    $parameters = $configurator->parameters();

    $services->set(TabContentWidget::class, TabContentWidget::class);
    $services->set(MainPageController2::class);

    return;

    $services
        ->load('Untek\Sandbox\Module\\', __DIR__ . '/../../..')
        ->exclude([
            __DIR__ . '/../../../{resources,Domain,Application/Commands,Application/Queries}',
            __DIR__ . '/../../../**/*{Event.php,Helper.php,Message.php,Task.php,Relation.php,Normalizer.php}',
            __DIR__ . '/../../../**/{Dto,Enums}',
        ]);

};