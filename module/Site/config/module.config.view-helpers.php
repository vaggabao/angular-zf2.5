<?php

use Site\ServiceFactory\ViewHelper\HeaderViewFactory;

return array(
    'view_helpers' => array(
        'factories' => array(
            'HeaderView' => HeaderViewFactory::class,
        )
    )
);
