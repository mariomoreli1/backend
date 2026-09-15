<?php

return [
    '~^articles/(\d+)$~' => ['ArticlesController', 'show'],
    '~^$~'               => ['MainController', 'main'],
];