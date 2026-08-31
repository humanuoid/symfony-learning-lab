<?php

declare(strict_types=1);

// SAC: Single Action Controller Pattern
// All controllers must follow SAC: one class, one action, one __invoke() method
// Routes MUST use PHP attributes (#[Route]) on the CLASS, never on methods or YAML files

// ============================================================================
// SAC: Controllers must have __invoke method
arch('SAC - controllers have __invoke method')
    ->expect(['App\*\Presentation\Web\*'])
    ->toHaveMethod('__invoke');

// ============================================================================
// SAC: Controllers must not have other public methods
arch('SAC - controllers have no other public methods')
    ->expect(['App\*\Presentation\Web\*'])
    ->not->toHaveMethods(['index', 'create', 'edit', 'update', 'delete', 'show', 'list', 'store', 'new']);
