<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerP4r27ne\srcDevDebugProjectContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerP4r27ne/srcDevDebugProjectContainer.php') {
    touch(__DIR__.'/ContainerP4r27ne.legacy');

    return;
}

if (!\class_exists(srcDevDebugProjectContainer::class, false)) {
    \class_alias(\ContainerP4r27ne\srcDevDebugProjectContainer::class, srcDevDebugProjectContainer::class, false);
}

return new \ContainerP4r27ne\srcDevDebugProjectContainer([
    'container.build_hash' => 'P4r27ne',
    'container.build_id' => '3a154554',
    'container.build_time' => 1561455269,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerP4r27ne');
