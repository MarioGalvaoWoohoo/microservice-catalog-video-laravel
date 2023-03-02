<?php

namespace Tests\Feature\Core\UseCase\Category;

use Tests\TestCase;
use App\Models\Category as Model;
use Core\UseCase\Category\CreateCategoryUseCase;

use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\DTO\Category\CreateCategory\CategoryCreateInputDto;

class CreateCategoryUseCaseTest extends TestCase
{
    public function test_create()
    {
        $useCase = new CreateCategoryUseCase(new CategoryEloquentRepository(new Model()));

        $responseUseCase = $useCase->execute(
            new CategoryCreateInputDto(
                name: 'Teste',
            )
        );

        $this->assertEquals('Teste', $responseUseCase->name);
        $this->assertNotEmpty($responseUseCase->id);
        $this->assertDatabaseHas('categories', [
            'id' => $responseUseCase->id,
        ]);
    }

}
