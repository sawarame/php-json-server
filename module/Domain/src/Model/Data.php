<?php

namespace Domain\Model;

use JsonSerializable;
use InvalidArgumentException;

/**
 * Data model class.
 */
class Data implements JsonSerializable
{
    /**
     * data of data model.
     *
     * @var array
     */
    private $data = [];

    /**
     * struct of data model.
     *
     * @var array
     */
    private $struct = [];

    /**
     * current max id.
     *
     * @var integer
     */
    private $maxId = 0;

    public function jsonSerialize() {
        return $this->getData();
    }

    /**
     * Constructor.
     *
     * Set data to data model.
     *
     * @param array $data
     * @return void
     */
    public function __construct(array $data)
    {
        foreach ($data as $row) {
            $this->replace($row);
        }
    }

    /**
     * Get data model data.
     *
     * @return array
     */
    public function getData(): array
    {
        ksort($this->data);
        return array_values($this->data);
    }

    /**
     * Check whether a row is exists in data model.
     *
     * @param integer $id
     * @return boolean
     */
    public function has(int $id): bool
    {
        return isset($this->data[$id]);
    }

    /**
     * Find row by id.
     *
     * @return array
     */
    public function find(int $id): ?array
    {
        if ($this->has($id)) {
            return $this->data[$id];
        }
        return null;
    }

    /**
     * [WIP] Fetch data by search parameters.
     *
     * @return array
     */
    public function read(array $param, array $sort): array
    {
        $data = $this->getData();
        return $data;
    }

    /**
     * Insert or replace row to data model.
     *
     * @param array $row
     * @return integer id of inserted (or replaced) row.
     */
    public function replace(array $row): int
    {
        if (empty($row['id'])) {
            $row['id'] = ++$this->maxId;
        }
        if (! is_integer($row['id'])) {
            throw new InvalidArgumentException('some message.');
        }
        if (! $this->getStruct()) {
            $this->setStruct(array_keys($row));
        }
        $newRow = $this->shapeByStruct($row);
        $this->data[$newRow['id']] = $newRow;
        if ($newRow['id'] > $this->maxId) {
            $this->maxId = $newRow['id'];
        }
        return $newRow['id'];
    }

    /**
     * Delete row from data model.
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        if ($this->has($id)) {
            unset($this->data[$id]);
        }
    }

    /**
     * Set struct for data model.
     *
     * @param array $struct
     * @return void
     */
    private function setStruct(array $struct): void
    {
        $newStruct = [];
        if (! in_array('id', $struct)) {
            throw new InvalidArgumentException('some message.');
        }
        $newStruct[] = 'id';
        foreach ($struct as $column) {
            if (! is_string($column)) {
                throw new InvalidArgumentException('some message.');
            }
            if ('id' === $column) {
                continue;
            }
            if (in_array($column, $newStruct)) {
                throw new InvalidArgumentException('some message.');
            }
            $newStruct[] = $column;
        }
        $this->struct = $newStruct;
    }

    /**
     * Get struct.
     *
     * @return array
     */
    private function getStruct(): array
    {
        return $this->struct;
    }

    /**
     * Check whether argument is same as struct of data model.
     *
     * @param integer $id
     * @return boolean
     */
    private function checkStruct(array $row): bool
    {
        $keys = array_keys($row);
        foreach ($keys as $key) {
            if (! in_array($key, $this->struct)) {
                return false;
            }
        }
        foreach ($this->struct as $column) {
            if (! in_array($column, $keys)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Format argument into structure of data model.
     *
     * @param array $row
     * @param boolean $force
     * @return array
     */
    private function shapeByStruct(array $row, bool $force = false): array
    {
        if (! $force && ! $this->checkStruct($row)) {
            throw new InvalidArgumentException('some message.');
        }

        $shapedRow = [];
        foreach ($this->struct as $column) {
            if (! is_scalar($row[$column])) {
                throw new InvalidArgumentException('some message.');
            }
            $shapedRow[$column] = $row[$column];
        }
        return $shapedRow;
    }
}
