<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Untek\Component\Web\TwBootstrap\Widgets\TabContent\TabContentWidget;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services()->defaults()->public();
    $parameters = $configurator->parameters();

    $services->set(TabContentWidget::class, TabContentWidget::class);
};