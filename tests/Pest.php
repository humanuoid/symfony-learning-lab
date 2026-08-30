<?php

pest()->beforeEach(function () {
    $this->arch()->ignore([
        'vendor',
        'var',
        'public',
        'config',
        'tests',
        'migrations',
    ]);
});
