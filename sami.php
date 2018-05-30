<?php

use Sami\Sami;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in($dir = __DIR__.'/app')
    ->in($dir = __DIR__.'/modules');

return new Sami($iterator, array(
    'theme'                => 'custom',
    'title'                => 'Creativehothouse',
    'build_dir'            => __DIR__.'/public/documentation/sami/build/%version%',
    'cache_dir'            => __DIR__.'/public/documentation/sami/cache/%version%',
    // use a custom theme directory
    'template_dirs'        => array(__DIR__.'/sami_themes/custom'),
    'default_opened_level' => 2,
));