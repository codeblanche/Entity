<?php
return array(
    'Authentication' => array(
        'programId' => 352,
        'username' => 'api',
        'password' => 'handshakeapi'
    ),
    'Country' => array(
        'testGet' => array(
            'input' => 12,
            'expect' => array(
                'code' => 'NL',
                'in_eu' => true,
                'name' => 'Netherlands',
            )
        ),
    ),
    'EndUser' => array(
        'credentials' => array(
            'username' => 'jesper@ratus.nl',
            'password' => 'devel',
            'programId' => 2473,
            'websiteId' => 10, //IsLive
        ),
        'getByProgramId' => array(
            'programId' => 2473,
            'filter' => array(
                'email' => 'jesper@ratus.nl',
            ),
        )
    ),
    'Language' => array(
        'testGet' => array(
            'input' => 1,
            'expect' => array(
                'abbreviation' => 'nl',
                'name' => 'Nederlands',
            )
        ),
    ),
    'PaymentMethod' => array(
        'testGet' => array(
            'input' => 3,
            'expect' => array(
                'abbreviation' => 'ppc',
                'name' => '(PPC) Telefoon (per gesprek)',
            )
        ),
    ),
    'PaymentProfile' => array(
        'testGet' => array(
            'input' => 10,
            'expect' => array(
                'name' => 'iDEAL',
                'parent_id' => 0,
                'public' => 1,
                'payment_method_id' => 4,
                'country_id' => 12,
                'payment_tariff_id' => 69,
                'noa_id' => 0
            )
        ),
    ),
);
