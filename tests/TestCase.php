<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use RuntimeException;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->guardAgainstRunningOnTheWorkingDatabase();
    }

    /**
     * Tests that use RefreshDatabase drop and re-migrate every table. Pointing the
     * suite at the working database silently destroys it, so fail loudly instead.
     */
    private function guardAgainstRunningOnTheWorkingDatabase(): void
    {
        $connection = config('database.default');
        $testDatabase = (string) config("database.connections.{$connection}.database");
        $workingDatabase = $this->workingDatabaseName();

        if ($testDatabase === '') {
            throw new RuntimeException('The testing database is not configured. Set DB_DATABASE in phpunit.xml.');
        }

        if ($workingDatabase !== null && $testDatabase === $workingDatabase) {
            throw new RuntimeException(
                "Refusing to run tests against the working database [{$testDatabase}]. "
                .'Point DB_DATABASE in phpunit.xml at a dedicated schema.'
            );
        }
    }

    /**
     * The database this application uses outside of tests. Read from .env directly,
     * because phpunit.xml has already overridden the environment by this point.
     */
    private function workingDatabaseName(): ?string
    {
        $envPath = base_path('.env');

        if (!is_readable($envPath)) {
            return null;
        }

        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
        $name = null;

        foreach ($lines as $line) {
            if (preg_match('/^\s*DB_DATABASE\s*=\s*(.*)$/', $line, $matches) === 1) {
                $name = trim($matches[1], " \t\"'");
            }
        }

        return ($name === null || $name === '') ? null : $name;
    }
}
