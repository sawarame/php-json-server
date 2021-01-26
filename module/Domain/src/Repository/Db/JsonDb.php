<?php

/**
 * @see       https://github.com/sawarame/php-json-server for the canonical source repository
 * @copyright https://github.com/sawarame/php-json-server/blob/master/COPYRIGHT.md
 * @license   https://github.com/sawarame/php-json-server/blob/master/LICENSE.md New BSD License
 */

namespace Domain\Repository\Db;

use Domain\Exception\JsonDbException;

class JsonDb
{

    private $config;

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
    public function read(string $schemaName): array
    {
        $this->path = $this->config['data_path'] . "/${schemaName}.json";
        if (! is_file($this->path)) {
            throw new JsonDbException('Json data file is not exists.' . realpath($this->path));
        }
        $rows = json_decode(file_get_contents($this->path), true);
        if (is_null($rows)) {
            throw new JsonDbException('Faild to open json data file.' . realpath($this->path));
        }
        return $rows ;
    }

    /**
     * Save joson data.
     *
     * @param string $schemaName
     * @param array $rows
     * @return array
     */
    public function save(string $schemaName, array $rows): void
    {
        $this->path = $this->config['data_path'] . "/${schemaName}.json";

        foreach ($rows as $row) {
            foreach ($row as $value) {
                if (! is_scalar($value)) {
                    throw new JsonDbException('Column data must be scalar.');
                }
            }
        }
        file_put_contents($this->path, json_encode(
            $rows,
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        ));
        return ;
    }
}
