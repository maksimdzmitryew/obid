<?php

/**
 *  https://github.com/cviebrock/eloquent-sluggable
 */
return [
    'source'             => null,
    'method'             => null,
    'onUpdate'           => false,
    'separator'          => '_',
    'unique'             => true,
    'uniqueSuffix'       => null,
    'firstUniqueSuffix'  => 2,
    'includeTrashed'     => false,
    'reserved'           => null,
    'maxLength'          => null,
    'maxLengthKeepWords' => true,
    'slugEngineOptions'  => [],
];
