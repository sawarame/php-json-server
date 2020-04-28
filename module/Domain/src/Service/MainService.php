<?php

namespace Domain\Service;

use Domain\Repository\JsonDb;

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
        return $this->db->read($params);
    }

    /**
     * Insert to data repository.
     *
     * @param array $data
     * @return integer
     */
    public function insert(string $schemaName, array $data): int
    {
        $this->db->load($schemaName);
        $id = $this->db->insert($data);
        $this->db->permanent();
        return $id;
    }

    /**
     * Find data by primary key.
     *
     * @param integer $id
     * @return array
     */
    public function find(string $schemaName, int $id): array
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
