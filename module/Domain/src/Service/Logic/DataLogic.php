<?php

/**
 * @see       https://github.com/sawarame/php-json-server for the canonical source repository
 * @copyright https://github.com/sawarame/php-json-server/blob/master/COPYRIGHT.md
 * @license   https://github.com/sawarame/php-json-server/blob/master/LICENSE.md New BSD License
 */

namespace Domain\Service\Logic;

class DataLogic
{
    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    /**
     * Search data.
     */
    public function search(array $rows, array $params): array
    {
        if (isset($params['search_type']) && $params['search_type'] == 'or') {
            $searched = [];
            foreach ($params as $key => $value) {
                $searched = array_merge(
                    $searched,
                    array_filter($rows, function ($row) use ($key, $value) {
                        if (is_array($value)) {
                            return in_array($row[$key], $value);
                        }
                        return $row[$key] == $value;
                    })
                );
            }
        } else {
            $searched = $rows;
            foreach ($params as $key => $value) {
                $searched = array_filter($searched, function ($row) use ($key, $value) {
                    if (is_array($value)) {
                        return in_array($row[$key], $value);
                    }
                    return $row[$key] == $value;
                });
            }
        }
        return array_values($searched);
    }

    /**
     *  Find data by primary key.
     */
    public function find(array $rows, int $id): ?array
    {
        foreach ($rows as $row) {
            if ($row['id'] == $id) {
                return $row;
            }
        }
        return null;
    }

    /**
     * Get columns list from row of data.
     */
    public function columns(array $row): array
    {
        return array_keys($row);
    }

    /**
     * Shape row by columns list.
     */
    public function shape(array $columns, array $row): array
    {
        $shaped = [];
        foreach ($columns as $column) {
            if (! isset($row[$column])) {
                $shaped[$column] = null;
                continue;
            }
            $shaped[$column] = $row[$column];
        }
        if (!empty($row['search_type'])) {
            $shaped['search_type'] = $row['search_type'];
        }
        return $shaped;
    }

    /**
     * Get page from params.
     *
     * @param array $params
     * @return integer
     */
    public function page(array $params): int
    {
        $page = isset($params['page']) ? (int)($params['page'] - 1) : 0;
        return $page < 0 ? 0 : $page;
    }

    /**
     * Get number of results per page.
     *
     * @param array $params
     * @return integer
     */
    public function results(array $params): int
    {
        return isset($params['results']) ? (int)$params['results'] : 20;
    }

    /**
     *
     */
    public function maxId(array $rows): int
    {
        if (empty($rows)) {
            return 0;
        }
        return max(array_column($rows, "id"));
    }
}
