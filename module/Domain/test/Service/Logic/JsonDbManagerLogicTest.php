<?php

/**
 * @see       https://github.com/sawarame/php-json-server for the canonical source repository
 * @copyright https://github.com/sawarame/php-json-server/blob/master/COPYRIGHT.md
 * @license   https://github.com/sawarame/php-json-server/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace DomainTest\Service\Logic;

use PHPUnit\Framework\TestCase;
use Domain\Repository\Db\JsonDb;
use Domain\Service\Logic\DataLogic;
use Domain\Service\Logic\JsonDbManagerLogic;

class JsonDbManagerLogicTest extends TestCase
{
    private $jsonDbManagerLogic = null;
    private $mockJsonDb = null;
    private $mockDataLogic = null;

    public function setUp(): void
    {
        $this->mockJsonDb = $this->createMock(JsonDb::class);
        $this->mockDataLogic = $this->createMock(DataLogic::class);
        $this->jsonDbManagerLogic = new JsonDbManagerLogic(
            $this->mockJsonDb,
            $this->mockDataLogic
        );

        $this->mockJsonDb->method('read')->willReturn([
            ['id' => 1, 'name' => 'Red',   'code' => '#ff0000'],
            ['id' => 2, 'name' => 'Green', 'code' => '#00ff00'],
            ['id' => 3, 'name' => 'Blue',  'code' => '#0000ff'],
        ]);

        $this->mockDataLogic->method('columns')->willReturn(
            ['id', 'name', 'code']
        );

        $this->mockDataLogic->method('shape')->willReturn(
            ['name' => 'Blue']
        );

        $this->mockDataLogic->method('page')->willReturn(0);
        $this->mockDataLogic->method('results')->willReturn(20);
    }

    public function testFind()
    {
        $schemaName = 'sample';
        $id = 2;

        $this->mockDataLogic->method('find')->willReturn(
            ['id' => 2, 'name' => 'Green', 'code' => '#00ff00']
        );

        $this->assertSame(
            ['id' => 2, 'name' => 'Green', 'code' => '#00ff00'],
            $this->jsonDbManagerLogic->find($schemaName, $id)
        );
    }

}
