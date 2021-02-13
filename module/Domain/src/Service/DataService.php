<?php

/**
 * @see       https://github.com/sawarame/php-json-server for the canonical source repository
 * @copyright https://github.com/sawarame/php-json-server/blob/master/COPYRIGHT.md
 * @license   https://github.com/sawarame/php-json-server/blob/master/LICENSE.md New BSD License
 */

namespace Domain\Service;

use Domain\Service\Logic\JsonDbManagerLogic;

class DataService
{
    private $jsonDbManagerLogic;

    /**
     * Constructor.
     */
    public function __construct(
        JsonDbManagerLogic $jsonDbManagerLogic
    ) {
        $this->jsonDbManagerLogic = $jsonDbManagerLogic;
    }

    /**
     * Find data by primary key.
     *
     * @param integer $id
     * @return array
     */
    public function find(string $schemaName, int $id): ?array
    {
        return $this->jsonDbManagerLogic->find($schemaName, $id);
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
        return $this->jsonDbManagerLogic->read($schemaName, $params);
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
        return $this->jsonDbManagerLogic->insert($schemaName, $row);
    }

    /**
     * Update data.
     *
     * @param array $data
     * @return void
     */
    public function update(string $schemaName, array $row): ?array
    {
        return $this->jsonDbManagerLogic->update($schemaName, $row);
    }

    /**
     * Deleta data.
     *
     * @param integer $id
     * @return void
     */
    public function delete(string $schemaName, int $id): ?array
    {
        return $this->jsonDbManagerLogic->delete($schemaName, $id);
    }
}
