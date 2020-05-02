<?php

declare(strict_types=1);

namespace DomainTest\Model;

use PHPUnit\Framework\TestCase;
use Domain\Repository\JsonDbImpl;
use Domain\Exception\JsonDbException;

class JsonDbTest extends TestCase
{
    private $jsonDb = null;

    public function setUp(): void
    {
        $this->jsonDb = new JsonDbImpl([
            'data_path' => __DIR__ . '/../../../../data/db',
        ]);
    }

    public function tearDown(): void
    {
        $this->jsonDb->load('sample');
        $datas = $this->jsonDb->toArray();
        foreach ($datas as $data) {
            $this->jsonDb->delete($data['id']);
        }
        $this->jsonDb->insert(['id' => 1, 'name' => 'Red',   'code' => '#ff0000']);
        $this->jsonDb->insert(['id' => 2, 'name' => 'Green', 'code' => '#00ff00']);
        $this->jsonDb->insert(['id' => 3, 'name' => 'Blue',  'code' => '#0000ff']);
        $this->jsonDb->permanent();
    }

    public function testLoad()
    {
        $this->jsonDb->load('sample');
        $this->assertSame([
            ['id' => 1, 'name' => 'Red',   'code' => '#ff0000'],
            ['id' => 2, 'name' => 'Green', 'code' => '#00ff00'],
            ['id' => 3, 'name' => 'Blue',  'code' => '#0000ff'],
        ], $this->jsonDb->toArray());
    }

    public function testLoadDataNotFound()
    {
        $this->expectException(JsonDbException::class);
        $this->jsonDb->load('not_found');
    }

    public function testInsert()
    {
        $this->jsonDb->load('sample');
        $this->jsonDb->insert(['name' => 'Orange',  'code' => '#ffa500']);
        $this->assertSame([
            ['id' => 1, 'name' => 'Red',    'code' => '#ff0000'],
            ['id' => 2, 'name' => 'Green',  'code' => '#00ff00'],
            ['id' => 3, 'name' => 'Blue',   'code' => '#0000ff'],
            ['id' => 4, 'name' => 'Orange', 'code' => '#ffa500'],
        ], $this->jsonDb->toArray());
    }

    public function testFind()
    {
        $this->jsonDb->load('sample');
        $this->assertSame(
            ['id' => 2, 'name' => 'Green',  'code' => '#00ff00'],
            $this->jsonDb->find(2)
        );
        $this->assertNull($this->jsonDb->find(4));
    }

    public function testUpdate()
    {
        $this->jsonDb->load('sample');
        $this->jsonDb->update(['id' => 2, 'name' => 'Gray', 'code' => '#808080']);
        $this->assertSame([
            ['id' => 1, 'name' => 'Red',   'code' => '#ff0000'],
            ['id' => 2, 'name' => 'Gray',  'code' => '#808080'],
            ['id' => 3, 'name' => 'Blue',  'code' => '#0000ff'],
        ], $this->jsonDb->toArray());
    }

    public function testUpdateIdUnspecified()
    {
        $this->expectException(JsonDbException::class);
        $this->jsonDb->load('sample');
        $this->jsonDb->update(['name' => 'Gray', 'code' => '#808080']);
    }

    public function testUpdateDataNotFound()
    {
        $this->expectException(JsonDbException::class);
        $this->jsonDb->load('sample');
        $this->jsonDb->update(['id' => 4, 'name' => 'Gray', 'code' => '#808080']);
    }

    public function testDelete()
    {
        $this->jsonDb->load('sample');
        $this->jsonDb->delete(2);
        $this->assertSame([
            ['id' => 1, 'name' => 'Red',   'code' => '#ff0000'],
            ['id' => 3, 'name' => 'Blue',  'code' => '#0000ff'],
        ], $this->jsonDb->toArray());
    }

    public function testDeleteDataNotFound()
    {
        $this->expectException(JsonDbException::class);
        $this->jsonDb->load('sample');
        $this->jsonDb->delete(4);
    }

    public function testPermanent()
    {
        $this->jsonDb->load('sample');
        $this->jsonDb->insert(['name' => 'Orange',  'code' => '#ffa500']);
        $this->jsonDb->permanent();

        $this->jsonDb->load('sample');
        $this->assertSame([
            ['id' => 1, 'name' => 'Red',    'code' => '#ff0000'],
            ['id' => 2, 'name' => 'Green',  'code' => '#00ff00'],
            ['id' => 3, 'name' => 'Blue',   'code' => '#0000ff'],
            ['id' => 4, 'name' => 'Orange', 'code' => '#ffa500'],
        ], $this->jsonDb->toArray());
    }
}
