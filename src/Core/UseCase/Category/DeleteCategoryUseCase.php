<?php

namespace Core\UseCase\Category;

use Core\UseCase\DTO\Category\CategoryInputDto;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\DeleteCategory\CategoryDeleteOutputDto;

class DeleteCategoryUseCase
{
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CategoryInputDto $input): CategoryDeleteOutputDto
    {
        $responseDelete = $this->repository->Delete($input->id);

        return new CategoryDeleteOutputDto(
            success: $responseDelete
        );
    }
}