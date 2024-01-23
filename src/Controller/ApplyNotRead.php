<?php

namespace App\Controller;

use App\Repository\ApplyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ApplyNotRead extends AbstractController
{
    public function __construct(
        readonly private ApplyRepository $applyRepository
    ) {

    }
    public function __invoke(): array
    {
        $query = $this->applyRepository->createQueryBuilder('a');
        $query->where('a.isRead = 0');

        return $query->getQuery()->getResult();
    }
}
