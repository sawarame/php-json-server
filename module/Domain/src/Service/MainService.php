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
     *
     *
     * @param array $params
     * @return array
     */
    public function read(array $params): array
    {
        return $this->db->read($params);
    }

    /**
     *
     *
     * @param array $data
     * @return integer
     */
    public function insert(array $data): int
    {
        return $this->db->insert($data);
    }

    /**
     *
     *
     * @param integer $id
     * @return array
     */
    public function find(int $id): array
    {
        return $this->db->find($id);
    }

    /**
     *
     *
     * @param array $data
     * @return void
     */
    public function update(array $data)
    {
        $this->db->update($data);
    }

    /**
     *
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id)
    {
        $this->db->delete($id);
    }
}
