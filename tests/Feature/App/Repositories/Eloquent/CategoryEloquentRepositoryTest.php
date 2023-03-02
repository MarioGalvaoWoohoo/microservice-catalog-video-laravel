<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use Throwable;

use Tests\TestCase;
use App\Models\Category as Model;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Entity\Category as EntityCategory;
use Core\Domain\Repository\CategoryRepositoryInterface;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\Domain\Repository\PaginationInterface;

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

    public function testFindById()
    {
        // Criou uma categoria faker
        $category = Model::factory()->create();

        $response = $this->repository->findById($category->id);

        $this->assertInstanceOf(EntityCategory::class, $response);
        $this->assertEquals($category->id, $response->id());

    }

    public function testFindByIdNotFound()
    {
        try {
            $this->repository->findById('fakeValue');
            
            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testFindAll()
    {
        // Criou uma categoria faker
        $categories = Model::factory()->count(10)->create();

        $response = $this->repository->findAll();

        // Duas maneiras de fazer a mesma coisa. Verifica se criou 10 registros e se retornou os mesmos 10.
        $this->assertEquals(count($categories), count($response));
        $this->assertCount(10, $response);

    }

    public function testPaginate()
    {
        // Criou uma categoria faker
        Model::factory()->count(20)->create();

        $response = $this->repository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $response);
        $this->assertCount(15, $response->items());
    }

    public function testPaginateWithout()
    {
        $response = $this->repository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $response);
        $this->assertCount(0, $response->items());
    }

    public function testUpdateNotFound()
    {
        try {
            $category = new EntityCategory(name: 'test');
            $this->repository->update($category);
            
            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testUpdate()
    {
        $categoryDb = Model::factory()->create();

        $category = new EntityCategory(
            id: $categoryDb->id,
            name: 'updated name',
        );

        $response = $this->repository->update($category);
        
        $this->assertInstanceOf(EntityCategory::class, $response);
        $this->assertNotEquals($response->name, $categoryDb->name);
        $this->assertEquals('updated name', $response->name);
    }

    public function testDeleteIdNotFound()
    {
        try {
            $this->repository->delete('fake_id');
            
            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testDelete()
    {
        $categoryDb = Model::factory()->create();

        $response = $this->repository->delete($categoryDb->id);
        $this->assertTrue($response);
    }
}


