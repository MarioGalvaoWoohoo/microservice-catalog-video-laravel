<?php

namespace Tests\Feature\Core\UseCase\Category;

use Tests\TestCase;

use App\Models\Category as Model;
use Core\UseCase\DTO\Category\CategoryInputDto;
use Core\UseCase\Category\DeleteCategoryUseCase;
use App\Repositories\Eloquent\CategoryEloquentRepository;


class DeleteCategoryUseCaseTest extends TestCase
{
    public function test_delete()
    {
        $categoryDb = Model::factory()->create();
        
        $useCase = new DeleteCategoryUseCase(new CategoryEloquentRepository(new Model()));

        $useCase->execute(
            new CategoryInputDto(
                id: $categoryDb->id,
            )
        );

        $this->assertSoftDeleted($categoryDb);
        
    }
}
