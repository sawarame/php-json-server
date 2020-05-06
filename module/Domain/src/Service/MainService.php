<?php

/**
 * @see       https://github.com/sawarame/php-json-server for the canonical source repository
 * @copyright https://github.com/sawarame/php-json-server/blob/master/COPYRIGHT.md
 * @license   https://github.com/sawarame/php-json-server/blob/master/LICENSE.md New BSD License
 */

namespace Domain\Service;

use Domain\Repository\JsonDb;
use Domain\Exception\DataNotFoundException;

class MainService
{
    private $db;

    /**
     * Constructor.
     */
    public function __construct(
        JsonDb $db
    ) {
        $this->db = $db;
    }

    /**
     * Read data from data repository.
     *
     * @param array $params
     * @return array
     */
    public function read(string $schemaName, array $params): array
    {
        $this->db->load($schemaName);
        $total = $this->db->countTotal($params);
        $rows  = $this->db->rows($params);
        $data = $this->db->read($params);

        return [
            'total' => $total,
            'pages' => (int)ceil($total / $rows),
            'rows'  => count($data),
            'data'  => $data,
        ];
    }

    /**
     * Insert to data repository.
     *
     * @param array $data
     * @return integer
     */
    public function insert(string $schemaName, array $data): int
    {
        try {
            $this->db->load($schemaName);
            $id = $this->db->insert($data);
        } catch (DataNotFoundException $e) {
            $id = $this->db->insert($data);
        }
        $this->db->permanent();
        return $id;
    }

    /**
     * Find data by primary key.
     *
     * @param integer $id
     * @return array
     */
    public function find(string $schemaName, int $id): ?array
    {
        $this->db->load($schemaName);
        return $this->db->find($id);
    }

    /**
     * Update data.
     *
     * @param array $data
     * @return void
     */
    public function update(string $schemaName, array $data)
    {
        $this->db->load($schemaName);
        $this->db->update($data);
        $this->db->permanent();
    }

    /**
     * Deleta data.
     *
     * @param integer $id
     * @return void
     */
    public function delete(string $schemaName, int $id)
    {
        $this->db->load($schemaName);
        $this->db->delete($id);
        $this->db->permanent();
    }
}
