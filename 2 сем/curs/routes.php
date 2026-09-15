<?php

return [
    '~^$~'                        => ['MainController',    'main'],
    '~^articles/(\d+)$~'          => ['ArticlesController', 'show'],
    '~^articles/(\d+)/edit$~'     => ['ArticlesController', 'edit'],
    '~^calculator$~'              => ['CalcController',     'index'],
    '~^contacts$~'                => ['ContactsController', 'index'],
];
