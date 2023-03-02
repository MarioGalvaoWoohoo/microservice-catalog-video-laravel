<?php

namespace Tests\Feature\Core\UseCase\Category;

use Tests\TestCase;
use App\Models\Category as Model;
use Core\UseCase\Category\ListCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryInputDto;
use App\Repositories\Eloquent\CategoryEloquentRepository;

class ListCategoryUseCaseTest extends TestCase
{
    public function test_list()
    {
        $categoryDb = Model::factory()->create();
        
        $useCase = new ListCategoryUseCase(new CategoryEloquentRepository(new Model()));

        $responseUseCase = $useCase->execute(
            new CategoryInputDto(
                id: $categoryDb->id,
            )
        );

        $this->assertEquals($categoryDb->id, $responseUseCase->id);
        $this->assertEquals($categoryDb->name, $responseUseCase->name);
        $this->assertEquals($categoryDb->description, $responseUseCase->description);
    }
}
