<?php

namespace App\Controller;

use ApiPlatform\Doctrine\Orm\Paginator;
use App\Repository\ApplyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ApplyRead extends AbstractController
{
    public function __construct(
        readonly private ApplyRepository $applyRepository
    ) {

    }
    public function __invoke(Paginator $data): array
    {
        $query = $this->applyRepository->createQueryBuilder('a');
        $query->where('a.isRead = 1');

        return $query->getQuery()->getResult();
    }
}
