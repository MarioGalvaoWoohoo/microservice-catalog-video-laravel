<?php

namespace Tests\Unit\App\Models;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;

abstract class ModelTestCase extends TestCase
{
    abstract protected function model(): Model;
    abstract protected function traits(): array;
    abstract protected function fillables(): array;
    abstract protected function casts(): array;

    public function testIfUseTraits()
    {

        $traitsNeed = $this->traits();

        $traitsUsed = array_keys(class_uses($this->model()));
        $this->assertEquals($traitsNeed, $traitsUsed);
    }

    public function testFillables()
    {
        $expectedFillables = $this->fillables();

        $fillables = $this->model()->getFillable();
        $this->assertEquals($expectedFillables, $fillables);

    }

    public function testIncrementingIsFalse()
    {
        $model = $this->model();
        $this->assertFalse($model->incrementing);
    }

    public function testHasCasts()
    {
        $expectedCasts = $this->casts();

        $casts = $this->model()->getCasts();
        $this->assertEquals($expectedCasts, $casts);

    }
}