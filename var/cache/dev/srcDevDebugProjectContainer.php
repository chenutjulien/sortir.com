<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerVzblcmg\srcDevDebugProjectContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerVzblcmg/srcDevDebugProjectContainer.php') {
    touch(__DIR__.'/ContainerVzblcmg.legacy');

    return;
}

if (!\class_exists(srcDevDebugProjectContainer::class, false)) {
    \class_alias(\ContainerVzblcmg\srcDevDebugProjectContainer::class, srcDevDebugProjectContainer::class, false);
}

return new \ContainerVzblcmg\srcDevDebugProjectContainer([
    'container.build_hash' => 'Vzblcmg',
    'container.build_id' => 'a93dbdd4',
    'container.build_time' => 1561447972,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerVzblcmg');
