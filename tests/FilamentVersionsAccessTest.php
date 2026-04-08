<?php

namespace Maksde\FilamentVersions\Tests;

use Maksde\FilamentVersions\Support\FilamentVersionsAccess;

class FilamentVersionsAccessTest extends TestCase
{
    public function test_check_with_null_is_allowed(): void
    {
        $this->assertTrue(FilamentVersionsAccess::check(null));
    }

    public function test_check_with_empty_array_is_allowed(): void
    {
        $this->assertTrue(FilamentVersionsAccess::check([]));
    }

    public function test_check_with_empty_string_is_allowed(): void
    {
        $this->assertTrue(FilamentVersionsAccess::check(''));
    }
}
