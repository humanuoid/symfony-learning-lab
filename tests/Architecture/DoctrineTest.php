<?php

declare(strict_types=1);

// Doctrine mappings must be YAML files in Infrastructure
arch('doctrine - yaml files in infrastructure')
    ->expect('App\Infrastructure\Persistence\Doctrine')
    ->toHaveSuffix('.orm.yaml');

// No Doctrine mappings allowed in config/
test('doctrine - no mappings in config')
    ->expect(glob('config/doctrine/*.orm.yaml'))
    ->toBeEmpty();
