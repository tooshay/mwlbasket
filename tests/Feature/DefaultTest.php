<?php

arch('preset-php')->preset()->php();

arch('preset-security')->preset()->security();

arch('strict types is declared')
    ->expect('App')
    ->toUseStrictTypes();

arch('globals')
    ->expect([
        'dd',
        'die',
        'dump',
        'ray',
        'var_dump',
    ])
    ->not->toBeUsed();
