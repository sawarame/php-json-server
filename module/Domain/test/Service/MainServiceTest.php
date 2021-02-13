<?php

/**
 * @see       https://github.com/sawarame/php-json-server for the canonical source repository
 * @copyright https://github.com/sawarame/php-json-server/blob/master/COPYRIGHT.md
 * @license   https://github.com/sawarame/php-json-server/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace DomainTest\Service;

use PHPUnit\Framework\TestCase;
use Domain\Repository\JsonDbImpl;
use Domain\Service\MainService;

class MainServiceTest extends TestCase
{
    private $mainService = null;

    public function setUp(): void
    {
        $mock = $this->createMock(JsonDbImpl::class);
        $this->mainService = new MainService($mock);

        $mock->method('page')->willReturn(0);
        $mock->method('rows')->willReturn(20);

        $mock->method('read')->willReturn([
            ['id' => 1, 'name' => 'Red',   'code' => '#ff0000'],
            ['id' => 2, 'name' => 'Green', 'code' => '#00ff00'],
            ['id' => 3, 'name' => 'Blue',  'code' => '#0000ff'],
        ]);

        $mock->method('countTotal')->willReturn(3);

        $mock->method('insert')->willReturn(4);

        $mock->method('find')
            ->willReturn(['id' => 3, 'name' => 'Blue',  'code' => '#0000ff']);
    }

    public function testRead()
    {
        $schemaName = 'sample';
        $params = [];
        $this->assertSame([
            'total' => 3,
            'pages' => 1,
            'rows'  => 3,
            'data' => [
                ['id' => 1, 'name' => 'Red',   'code' => '#ff0000'],
                ['id' => 2, 'name' => 'Green', 'code' => '#00ff00'],
                ['id' => 3, 'name' => 'Blue',  'code' => '#0000ff'],
            ],
        ], $this->mainService->read($schemaName, $params));
    }

    public function testInsert()
    {
        $schemaName = 'sample';
        $params = [];
        $this->assertSame(4, $this->mainService->insert($schemaName, $params));
    }

    public function testFind()
    {
        $schemaName = 'sample';
        $id = 3;
        $this->assertSame(
            ['id' => 3, 'name' => 'Blue',  'code' => '#0000ff'],
            $this->mainService->find($schemaName, $id)
        );
    }

    public function testUpdate()
    {
        $schemaName = 'sample';
        $params = [];
        $this->assertNull($this->mainService->update($schemaName, $params));
    }

    public function testDelete()
    {
        $schemaName = 'sample';
        $id = 3;
        $this->assertNull($this->mainService->delete($schemaName, $id));
    }
}
