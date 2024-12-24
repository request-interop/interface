# The _Request_ `$uploads` Property

The _Request_ `$files` property is typically an identical copy of `$_FILES`. Normally, `$_FILES` looks like this with a single file upload ...

```php
$_FILES = [
    'photo' => [
        'tmp_name' => '/tmp/upload/ods9bqgt',
        'error' => 0,
        'name' => 'calvin.jpg',
        'full_path' => '/Users/watterson/Pictures/calvin.jpg',
        'size' => 12345,
        'type' => 'image/jpeg',
    ],
];
```

... which is straightforward enough. But the structure looks like this with multi-file uploads:

```php
$_FILES = [
    'photos' => [
        'tmp_name' => [
            0 => '/tmp/upload/xexrsaq9',
            1 => '/tmp/upload/j6m0j94k',
            2 => '/tmp/upload/8p2ki2px',
        ],
        'error' => [
            0 => 0,
            1 => 0,
            2 => 0,
        ],
        'name' => [
            0 => 'calvin.jpg',
            1 => 'hobbes.jpg',
            2 => 'susie.jpg',
        ],
        'full_path' => [
            0 => '/Users/watterson/Pictures/calvin.jpg',
            1 => '/Users/watterson/Pictures/hobbes.jpg',
            2 => '/Users/watterson/Pictures/susie.jpg',
        ],
        'size' => [
            0 => 12345,
            1 => 23456,
            2 => 45678,
        ],
        'type' => [
            0 => 'image/jpeg',
            1 => 'image/jpeg',
            2 => 'image/jpeg',
        ],
    ],
];
```

That structure is not at all what we expect when we compare it to `$_POST`; instead, we would expect something more like the following:

```php
$uploads = [
    'photos' => [
        0 => [
            'tmp_name' => '/tmp/upload/xexrsaq9',
            'error' => 0,
            'name' => 'calvin.jpg',
            'full_path' => '/Users/watterson/Pictures/calvin.jpg',
            'size' => 12345,
            'type' => 'image/jpeg',
        ],
        1 => [
            'tmp_name' => '/tmp/upload/j6m0j94k',
            'error' => 0,
            'name' => 'hobbes.jpg',
            'full_path' => '/Users/watterson/Pictures/hobbes.jpg',
            'size' => 23456,
            'type' => 'image/jpeg',
        ],
        2 => [
            'tmp_name' => '/tmp/upload/8p2ki2px',
            'error' => 0,
            'name' => 'susie.jpg',
            'full_path' => '/Users/watterson/Pictures/susie.jpg',
            'size' => 34567,
            'type' => 'image/jpeg',
        ],
    ]
];
```

That modified structure is what `UploadsArray` type represents, with the addition that instead of presenting the file information as an array, it is encapsulated in an _Upload_ instance:

```php
$uploads = [
    'photos' => [
        0 => /** Upload instance for calvin.jpg */,
        1 => /** Upload instance for hobbes.jpg */,
        2 => /** Upload instance for susie.jpg */,
    ]
]);
```

Cf. the reference implementation of `uploadsArray()` at [https://github.com/request-interop/impl/blob/0.x/src/RequestFactory.php][] and the corresponding `testUploadsArray()` methods at [https://github.com/request-interop/impl/blob/0.x/tests/RequestFactoryTestCase.php][].
