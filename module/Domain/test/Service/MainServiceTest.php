<?php

declare(strict_types=1);

namespace DomainTest\Model;

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

        $mock->method('read')->willReturn([
            ['id' => 1, 'name' => 'Red',   'code' => '#ff0000'],
            ['id' => 2, 'name' => 'Green', 'code' => '#00ff00'],
            ['id' => 3, 'name' => 'Blue',  'code' => '#0000ff'],
        ]);

        $mock->method('insert')->willReturn(4);

        $mock->method('find')
            ->willReturn(['id' => 3, 'name' => 'Blue',  'code' => '#0000ff']);


    }

    public function testRead()
    {
        $this->assertSame([
            ['id' => 1, 'name' => 'Red',   'code' => '#ff0000'],
            ['id' => 2, 'name' => 'Green', 'code' => '#00ff00'],
            ['id' => 3, 'name' => 'Blue',  'code' => '#0000ff'],
        ], $this->mainService->read([]));
    }

    public function testInsert()
    {
        $this->assertSame(4, $this->mainService->insert([]));
    }

    public function testFind()
    {
        $this->assertSame(
            ['id' => 3, 'name' => 'Blue',  'code' => '#0000ff'],
            $this->mainService->find(3)
        );
    }

    public function testUpdate()
    {
        $this->assertNull($this->mainService->update([]));
    }

    public function testDelete()
    {
        $this->assertNull($this->mainService->delete(1));
    }
}
