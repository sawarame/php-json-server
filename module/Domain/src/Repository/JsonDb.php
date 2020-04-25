<?php

namespace Domain\Repository;

interface JsonDb {

    function load(string $schemaName): JsonDb;

    function toArray(): array;

    function insert(array $data): int;

    function find(int $id): ?array;

    function read(array $params): array;

    function update(array $data): JsonDb;

    function delete(int $id): JsonDb;

    function permanent(): JsonDb;
}
