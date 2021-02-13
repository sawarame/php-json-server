<?php

/**
 * @see       https://github.com/sawarame/php-json-server for the canonical source repository
 * @copyright https://github.com/sawarame/php-json-server/blob/master/COPYRIGHT.md
 * @license   https://github.com/sawarame/php-json-server/blob/master/LICENSE.md New BSD License
 */

namespace Domain\Service\Logic;

use Domain\Repository\Db\JsonDb;
use Domain\Service\Logic\DataLogic;
use Exception;

class JsonDbManagerLogic
{
    private $jsonDb;
    private $dataLogic;

    /**
     * Constructor.
     */
    public function __construct(
        JsonDb $jsonDb,
        DataLogic $dataLogic
    ) {
        $this->jsonDb = $jsonDb;
        $this->dataLogic = $dataLogic;
    }

    /**
     * Find data by primary key.
     *
     * @param integer $id
     * @return array
     */
    public function find(string $schemaName, int $id): ?array
    {
        $allRows = $this->jsonDb->read($schemaName);
        return $this->dataLogic->find($allRows, $id);
    }

    /**
     * Read data from data repository.
     *
     * @param string $schemaName
     * @param array $params
     * @return array
     */
    public function read(string $schemaName, array $params): array
    {
        $allRows = $this->jsonDb->read($schemaName);
        $columns = $this->dataLogic->columns(current($allRows));
        $shapedParams = array_filter($this->dataLogic->shape($columns, $params), function ($data) {
            return ! is_null($data);
        });
        $searchedRows = $this->dataLogic->search($allRows, $shapedParams);

        $total = count($searchedRows);
        $page = $this->dataLogic->page($params);
        $results = $this->dataLogic->results($params);
        $offset = $page * $results;
        $data = array_slice($searchedRows, $offset, $results);

        return [
            'total' => $total,
            'pages' => (int)ceil($total / $results),
            'results'  => count($data),
            'data'  => $data,
        ];
    }

    /**
     * Insert to data repository.
     *
     * @param string $schemaName
     * @param array $row
     * @return integer
     */
    public function insert(string $schemaName, array $row): array
    {
        $allRows = $this->jsonDb->read($schemaName);
        $shapedRow = $this->dataLogic->shape(
            $this->dataLogic->columns(current($allRows)),
            $row
        );

        if (empty($shapedRow['id'])) {
            $shapedRow['id'] = $this->dataLogic->maxId($allRows) + 1;
        }

        if ($this->dataLogic->find($allRows, $shapedRow['id'])) {
            throw new Exception('The id is already exists.');
        }

        $this->jsonDb->save($schemaName, array_merge($allRows, [$shapedRow]));
        return $shapedRow;
    }

    /**
     * Update data.
     *
     * @param array $data
     * @return void
     */
    public function update(string $schemaName, array $row): ?array
    {
        $allRows = $this->jsonDb->read($schemaName);
        $shapedRow = $this->dataLogic->shape(
            $this->dataLogic->columns(current($allRows)),
            $row
        );

        if (empty($shapedRow['id'])) {
            throw new Exception('Column `id` is required in update data.');
        }

        foreach ($allRows as $key => $org) {
            if ($org['id'] == $shapedRow['id']) {
                $allRows[$key] = $shapedRow;
                $this->jsonDb->save($schemaName, $allRows);
                return $shapedRow;
            }
        }

        throw new Exception('Data is not exists with id is ' . $shapedRow['id'] . '.');
    }

    /**
     * Deleta data.
     *
     * @param integer $id
     * @return void
     */
    public function delete(string $schemaName, int $id): ?array
    {
        $allRows = $this->jsonDb->read($schemaName);

        foreach ($allRows as $key => $row) {
            if ($row['id'] == $id) {
                $deletedRow = $allRows[$key];
                unset($allRows[$key]);
                $this->jsonDb->save($schemaName, $allRows);
                return $deletedRow;
            }
        }
        throw new Exception('Data is not exists with id is ' . $id . '.');
    }
}
