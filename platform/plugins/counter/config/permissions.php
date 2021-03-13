<?php

return [
    [
        'name' => 'Counters',
        'flag' => 'counter.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'counter.create',
        'parent_flag' => 'counter.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'counter.edit',
        'parent_flag' => 'counter.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'counter.destroy',
        'parent_flag' => 'counter.index',
    ],
];
