<?php

use PHPUnit\Framework\TestCase;

class DotenvTest extends TestCase
{
    public function testDotenvClassExists()
    {
        $this->assertTrue(class_exists(\Dotenv\Dotenv::class));
    }
}
