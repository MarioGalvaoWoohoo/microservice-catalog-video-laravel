<?php

namespace Tests\Feature\Core\UseCase\Category;

use Tests\TestCase;
use App\Models\Category as Model;
use Core\UseCase\Category\UpdateCategoryUseCase;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\DTO\Category\UpdateCategory\CategoryUpdateInputDto;

class UpdateCategoryUseCaseTest extends TestCase
{
    public function test_update()
    {
        $categoryDb = Model::factory()->create();
        
        $useCase = new UpdateCategoryUseCase(new CategoryEloquentRepository(new Model()));

        $responseUseCase = $useCase->execute(
            new CategoryUpdateInputDto(
                id: $categoryDb->id,
                name: 'Name Updated',
            )
        );

        $this->assertEquals('Name Updated', $responseUseCase->name);
        $this->assertEquals($categoryDb->description, $responseUseCase->description);
        $this->assertDatabaseHas('categories', [
            'name' => $responseUseCase->name
        ]);
        
    }
}
