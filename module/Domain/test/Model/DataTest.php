<?php

declare(strict_types=1);

namespace DomainTest\Model;

use PHPUnit\Framework\TestCase;
use Domain\Model\Data;

class DataTest extends TestCase
{
    private $data = null;

    public function setUp(): void
    {
        $this->data = new Data([
            ['id' => 1, 'name' => 'Red',   'code' => '#ff0000'],
            ['id' => 2, 'name' => 'Green', 'code' => '#00ff00'],
            ['id' => 3, 'name' => 'Blue',  'code' => '#0000ff'],
        ]);
    }

    public function testGetData()
    {
        $this->assertSame([
            ['id' => 1, 'name' => 'Red',   'code' => '#ff0000'],
            ['id' => 2, 'name' => 'Green', 'code' => '#00ff00'],
            ['id' => 3, 'name' => 'Blue',  'code' => '#0000ff'],
        ], $this->data->getData());
    }

    public function testHas()
    {
        $this->assertTrue($this->data->has(2));
        $this->assertFalse($this->data->has(100));
    }

    public function testFind()
    {
        $this->assertSame(
            ['id' => 3, 'name' => 'Blue',   'code' => '#0000ff'],
            $this->data->find(3)
        );
        $this->assertNull($this->data->find(4));
    }

    public function testReplace()
    {
        $this->data->replace(['name' => 'Orange', 'code' => '#ffa500']);
        $this->data->replace(['name' => 'Purple', 'code' => '#800080']);
        $this->data->replace(['id' => 2, 'name' => 'Gray', 'code' => '#808080']);
        $this->data->replace(['id' => 9, 'name' => 'Yellow', 'code' => '#ffff00']);
        $this->data->replace(['id' => 8, 'name' => 'Black', 'code' => '#000000']);

        $this->assertSame([
            ['id' => 1, 'name' => 'Red',    'code' => '#ff0000'],
            ['id' => 2, 'name' => 'Gray',   'code' => '#808080'],
            ['id' => 3, 'name' => 'Blue',   'code' => '#0000ff'],
            ['id' => 4, 'name' => 'Orange', 'code' => '#ffa500'],
            ['id' => 5, 'name' => 'Purple', 'code' => '#800080'],
            ['id' => 8, 'name' => 'Black',  'code' => '#000000'],
            ['id' => 9, 'name' => 'Yellow', 'code' => '#ffff00'],
        ], $this->data->getData());
    }

    public function testReplaceIdIsNotInteger()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->data->replace(['id' => '2', 'name' => 'Gray', 'code' => '#808080']);
    }

    public function testReplaceValueIsNotScalar()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->data->replace(['name' => ['Gray', 'Orange'], 'code' => '#808080']);
    }

    public function testReplaceIlligalStruct()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->data->replace(['name' => 'Michelle', 'age' => '24']);
    }

    public function testDelete()
    {
        $this->data->delete(2);
        $this->data->delete(4);
        $this->assertSame([
            ['id' => 1, 'name' => 'Red',  'code' => '#ff0000'],
            ['id' => 3, 'name' => 'Blue', 'code' => '#0000ff'],
        ], $this->data->getData());
    }
}
