<?php

declare(strict_types=1);

// UseCase organization by Feature
arch('use case - commands suffix')
    ->expect('App\Application\UseCase')
    ->toHaveSuffix('Command');

arch('use case - handlers suffix')
    ->expect('App\Application\UseCase')
    ->toHaveSuffix('Handler');

// Application must not depend on Infrastructure
arch('application - not depends on infrastructure')
    ->expect('App\Application')
    ->not->toUse('App\Infrastructure');

// Application must not use Symfony or Doctrine - framework-agnostic
arch('application - no symfony')
    ->expect('App\Application')
    ->not->toUse('Symfony\*');

arch('application - no doctrine')
    ->expect('App\Application')
    ->not->toUse('Doctrine\*');
