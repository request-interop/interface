<?php return [
    'namespace' => 'RequestInterop\\Interface\\',
    'directory' => dirname(__DIR__) . '/src',
    'template' => dirname(__DIR__) . '/resources/README.tpl.md',
    'interfaces' => [
        'RequestStruct',
        'RequestStructFactory',
        'RequestThrowable',
        'RequestTypeAliases',
    ],
];
