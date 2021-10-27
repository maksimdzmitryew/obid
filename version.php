<?php

$a_production = [
    'version_release'       => '0',
    'version_leader'        => '18', # changes whenever any css,js,api,anonym,person value below has changed; reset each realease
    'version_patch'         => '2',
    'version_maturity'      => 'a', # a=alfa,b=beta,rc=candidate,r=release,sr=service release
    'version_day'           => '300',
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
    'anonym'                => '0.03.2',
    'person'                => '0.14.0',
    'review'                => '0.01.0',
    'api'                   => '0.00.0',
    'css'                   => '0.42.0',
    'js'                    => '0.32.0',
];
