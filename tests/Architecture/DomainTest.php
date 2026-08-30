<?php

declare(strict_types=1);

// Domain layer must be pure - no external dependencies
arch('domain - no symfony')
    ->expect('App\Domain')
    ->not->toUse('Symfony\*');

arch('domain - no doctrine')
    ->expect('App\Domain')
    ->not->toUse('Doctrine\*');

// Domain must not depend on other layers
arch('domain - no application dependency')
    ->expect('App\Application')
    ->not->toBeUsedIn('App\Domain');

arch('domain - no infrastructure dependency')
    ->expect('App\Infrastructure')
    ->not->toBeUsedIn('App\Domain');

arch('domain - no presentation dependency')
    ->expect('App\Presentation')
    ->not->toBeUsedIn('App\Domain');
