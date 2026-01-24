<?php

namespace App\Repository;

use App\Entity\Site;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Site>
 */
class SiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Site::class);
    }

    /**
     * @param array<int, array<string, mixed>> $sorters
     * @param array<int, array<string, mixed>> $filters
     *
     * @return array{data: array<int, Site>, total: int}
     */
    public function findForTabulator(int $page, int $size, array $sorters, array $filters): array
    {
        $qb = $this->createQueryBuilder('site');

        $allowedFields = [
            'name' => 'site.name',
            'city' => 'site.city',
            'address' => 'site.address',
            'capacity' => 'site.capacity',
            'status' => 'site.status',
            'updated_at' => 'site.updatedAt',
        ];

        $this->applyFilters($qb, $filters, $allowedFields);
        $this->applySorters($qb, $sorters, $allowedFields);

        $countQb = clone $qb;
        $total = (int) $countQb
            ->select('COUNT(site.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $offset = ($page - 1) * $size;
        $data = $qb
            ->setFirstResult($offset)
            ->setMaxResults($size)
            ->getQuery()
            ->getResult();

        return [
            'data' => $data,
            'total' => $total,
        ];
    }

    /**
     * @param array<int, array<string, mixed>> $filters
     * @param array<string, string> $allowedFields
     */
    private function applyFilters($qb, array $filters, array $allowedFields): void
    {
        $index = 0;

        foreach ($filters as $filter) {
            if (!is_array($filter)) {
                continue;
            }

            $field = $filter['field'] ?? null;
            $value = $filter['value'] ?? null;

            if (!$field || $value === null || $value === '' || !isset($allowedFields[$field])) {
                continue;
            }

            $param = 'filter_' . $index;
            $column = $allowedFields[$field];

            if ($field === 'capacity') {
                $qb->andWhere($column . ' = :' . $param)
                    ->setParameter($param, (int) $value);
                $index++;
                continue;
            }

            if ($field === 'updated_at') {
                $date = \DateTimeImmutable::createFromFormat('d/m/Y', (string) $value);
                if (!$date) {
                    continue;
                }

                $start = $date->setTime(0, 0);
                $end = $date->setTime(23, 59, 59);

                $qb->andWhere($column . ' BETWEEN :' . $param . '_start AND :' . $param . '_end')
                    ->setParameter($param . '_start', $start)
                    ->setParameter($param . '_end', $end);
                $index++;
                continue;
            }

            $qb->andWhere($column . ' LIKE :' . $param)
                ->setParameter($param, '%' . $value . '%');
            $index++;
        }
    }

    /**
     * @param array<int, array<string, mixed>> $sorters
     * @param array<string, string> $allowedFields
     */
    private function applySorters($qb, array $sorters, array $allowedFields): void
    {
        foreach ($sorters as $sorter) {
            if (!is_array($sorter)) {
                continue;
            }

            $field = $sorter['field'] ?? null;
            $dir = strtolower((string) ($sorter['dir'] ?? 'asc'));

            if (!$field || !isset($allowedFields[$field])) {
                continue;
            }

            $direction = $dir === 'desc' ? 'DESC' : 'ASC';
            $qb->addOrderBy($allowedFields[$field], $direction);
        }
    }
}
