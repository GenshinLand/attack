<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace HyperfTest\Cases;

use PHPUnit\Framework\TestCase;
use Sworder\Attack\ElementIncrease;
use Sworder\Attack\Resistance;
use Sworder\Attack\State;
use Sworder\Element\Gold;

/**
 * @internal
 * @coversNothing
 */
class StateTest extends TestCase
{
    public function testJsonableForState()
    {
        $state = new State(
            1000,
            100,
            100,
            new Resistance(0.8),
            new ElementIncrease(0.8),
            new Gold()
        );

        $json = json_encode($state);

        $res = State::make(json_decode($json, true));

        $this->assertEquals($res, $state);
    }
}
