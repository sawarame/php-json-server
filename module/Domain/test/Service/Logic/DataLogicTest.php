<?php

/**
 * @see       https://github.com/sawarame/php-json-server for the canonical source repository
 * @copyright https://github.com/sawarame/php-json-server/blob/master/COPYRIGHT.md
 * @license   https://github.com/sawarame/php-json-server/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace DomainTest\Service\Logic;

use PHPUnit\Framework\TestCase;
use Domain\Service\Logic\DataLogic;

class DataLogicTest extends TestCase
{
    private $dataLogic = null;

    public function setUp(): void
    {
        $this->dataLogic = new DataLogic();
    }

    public function testSearch()
    {
        $rows = [
            ["id" => 1, "name" => "Red", "code" => "#ff0000"],
            ["id" => 2, "name" => "Green", "code" => "#00ff00"],
            ["id" => 3, "name" => "Blue", "code" => "#0000ff"],
        ];
        $params1 = ["name" => "Green"];
        $this->assertSame([
            ["id" => 2, "name" => "Green", "code" => "#00ff00"],
        ], $this->dataLogic->search($rows, $params1));

        $params2 = ["name" => "Green", "code" => "#0000ff", "search_type" => "or"];
        $this->assertSame([
            ["id" => 2, "name" => "Green", "code" => "#00ff00"],
            ["id" => 3, "name" => "Blue", "code" => "#0000ff"],
        ], $this->dataLogic->search($rows, $params2));
    }
}
