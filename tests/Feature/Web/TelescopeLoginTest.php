<?php

namespace Tests\Feature\Web;

use Tests\TestCase;

class TelescopeLoginTest extends TestCase
{
    public function test_telescope_login_works_in_local_environment(): void
    {
        $this->app->detectEnvironment(fn () => 'local');

        $response = $this->get('/telescope-login');

        $response->assertRedirect('/telescope');
    }

    public function test_telescope_login_returns_not_found_in_production(): void
    {
        $this->app->detectEnvironment(fn () => 'production');

        $response = $this->get('/telescope-login');

        $response->assertNotFound();
    }
}
