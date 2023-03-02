<?php

namespace Tests\Feature\Core\UseCase\Category;

use Tests\TestCase;
use App\Models\Category as Model;
use Core\UseCase\Category\ListCategoriesUseCase;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\DTO\Category\ListCategories\ListCategoriesInputDto;


class ListCategoriesUseCaseTest extends TestCase
{
    public function test_list_empty()
    {
        $responseUseCase = $this->createUseCase();
        $this->assertCount(0, $responseUseCase->items);
    }

    public function test_list_all()
    {

        $categoriesDb = Model::factory()->count(20)->create();

        $responseUseCase = $this->createUseCase();

        $this->assertCount(15, $responseUseCase->items);
        $this->assertEquals(count($categoriesDb), $responseUseCase->total);
    }

    private function createUseCase()
    {
        $useCase = new ListCategoriesUseCase(new CategoryEloquentRepository(new Model()));
        return $useCase->execute(new ListCategoriesInputDto());
    }
}
