<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use Tests\TestCase;

use App\Models\Category as Model;
use Core\Domain\Entity\Category as EntityCategory;
use Core\Domain\Repository\CategoryRepositoryInterface;
use App\Repositories\Eloquent\CategoryEloquentRepository;


class CategoryEloquentRepositoryTest extends TestCase
{

    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new CategoryEloquentRepository(new Model());
    }

    public function testInsert()
    {
        $entity = new EntityCategory(
            name: 'Teste',
        );

        $response = $this->repository->insert($entity);
        
        $this->assertInstanceOf(CategoryRepositoryInterface::class, $this->repository);
        $this->assertInstanceOf(EntityCategory::class, $response);
        //Muito boa essa função abaixo. Verifica o dado diretamente no banco. Primeiro parametro é a tabela e o segundo o dado verificado
        $this->assertDatabaseHas('categories', [
            'name' => $entity->name
        ]);
    }
}
