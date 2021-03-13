<?php

return [
    [
        'name' => 'News',
        'flag' => 'news.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'news.create',
        'parent_flag' => 'news.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'news.edit',
        'parent_flag' => 'news.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'news.destroy',
        'parent_flag' => 'news.index',
    ],
];
