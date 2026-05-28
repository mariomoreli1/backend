<?php

return [
    '~^articles/(\d+)$~'      => ['ArticlesController', 'show'],
    '~^articles/(\d+)/edit$~' => ['ArticlesController', 'edit'],
    '~^$~'                    => ['MainController', 'main'],
];