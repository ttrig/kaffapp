<?php

namespace Tests\Feature;

use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    public function test_happy_path()
    {
        $this->get(route('home'))->assertOk();
    }
}
