<?php

namespace Domain\Repository;

use InvalidArgumentException;
use Domain\Model\Data;

class JsonDbImpl implements JsonDb {

    private $config;
    private $model;
    private $path;

    /**
     * Constructor.
     * Setup JsonDb configuration.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Load json data from schema name.
     *
     * @param string $schemaName
     * @return JsonDb
     */
    public function load(string $schemaName): JsonDb
    {
        $path = $this->config['data_path'] . "/${schemaName}.json";
        if (! is_file($path)) {
            throw new InvalidArgumentException('some message.');
        }
        $data = json_decode(file_get_contents($path), true);
        if (! $data) {
            throw new InvalidArgumentException('some message.');
        }
        $this->path = $path;
        $this->model = new Data($data);
        return $this;
    }

    /**
     * Return current data converted to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->model->getData();
    }

    /**
     * Insert data.
     *
     * @param array $data
     * @return integer
     */
    public function insert(array $data): int
    {
        return $this->model->replace($data);
    }

    /**
     * Find data by primary key.
     *
     * @param integer $id
     * @return array|null
     */
    public function find(int $id): ?array
    {
        return $this->model->find($id);
    }

    /**
     * Retrurn data searched.
     *
     * @param array $params
     * @return array
     */
    public function read(array $params): array
    {
        $param = [];
        $sort = [];
        return $this->model->read($param, $sort);
    }

    /**
     * Update date.
     *
     * @param array $data
     * @return JsonDb
     */
    public function update(array $data): JsonDb
    {
        if (empty($data['id'])) {
            throw new InvalidArgumentException('some message.');
        }
        if (! $this->model->find($data['id'])) {
            throw new InvalidArgumentException('some message.');
        }
        $this->model->replace($data);
        return $this;
    }

    /**
     * Delete data.
     *
     * @param integer $id
     * @return JsonDb
     */
    public function delete(int $id): JsonDb
    {
        if (! $this->model->find($id)) {
            throw new InvalidArgumentException('some message.');
        }
        $this->model->delete($id);
        return $this;
    }

    /**
     * Save current data.
     *
     * @return JsonDb
     */
    public function permanent(): JsonDb
    {
        file_put_contents($this->path, json_encode(
            $this->model,
            JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT
        ));
        return $this;
    }

    public function __toString()
    {
        return json_encode($this->model);
    }
}
