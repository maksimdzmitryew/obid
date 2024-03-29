<?php

$a_production = [
    'version_release'       => '0',
    'version_leader'        => '22', # changes whenever any css,js,api,anonym,person value below has changed; reset each realease
    'version_patch'         => '0',
    'version_maturity'      => 'a', # a=alfa,b=beta,rc=candidate,r=release,sr=service release
    'version_day'           => '047',
    'version_seq'           => '1', # subsequent commit during same day for the same version
];

return (object) [

    'app'                   => $a_production['version_release'] . '.'
    . $a_production['version_leader'] . '.'
    . $a_production['version_patch']
    . ($a_production['version_maturity'] ? '+' : '')
    . $a_production['version_maturity']
    . $a_production['version_day'] . ':'
    . $a_production['version_seq'],
    'release'               => $a_production['version_release'],
    'anonym'                => '0.07.0',
    'person'                => '0.14.0',
    'review'                => '0.01.0',
    'api'                   => '0.00.0',
    'css'                   => '0.46.0',
    'js'                    => '0.38.0',
];
