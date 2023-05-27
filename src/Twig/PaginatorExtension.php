<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PaginatorExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('paginationSequence', [$this, 'paginationSequence']),
        ];
    }

    public function paginationSequence(int $currentPage, int $allPages): array
    {
        if ($allPages <= 6) {
            return range(1, $allPages);
        }

        return range($currentPage - 4, $currentPage + 1);
    }
}