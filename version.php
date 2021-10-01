<?php

$a_production = [
    'version_release'       => '0',
    'version_leader'        => '13', # changes whenever any css,js,api,anonym,person value below has changed; reset each realease
    'version_patch'         => '5',
    'version_maturity'      => 'a', # a=alfa,b=beta,rc=candidate,r=release,sr=service release
    'version_day'           => '274',
    'version_seq'           => '4', # subsequent commit during same day for the same version
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
    'anonym'                => '0.01.3',
    'person'                => '0.11.1',
    'review'                => '0.01.1',
    'api'                   => '0.00.0',
    'css'                   => '0.40.0',
    'js'                    => '0.29.1',
];
