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
use Sworder\Element\Geo;
use Sworder\Element\Hydro;
use Sworder\Element\Pyro;

/**
 * @internal
 * @coversNothing
 */
class AttackTest extends TestCase
{
    public function testAttackWithNoElement()
    {
        $p1 = new State(1000, 100, 100, 10, new Resistance(), new ElementIncrease());
        $p2 = new State(1000, 100, 100, 10, new Resistance(), new ElementIncrease());

        $p2 = $p1->attack($p2);

        $this->assertSame(900, $p2->hp);
    }

    public function testAttackWithElement()
    {
        $p1 = new State(1000, 100, 100, 10, new Resistance(), new ElementIncrease());
        $p2 = new State(1000, 100, 100, 10, new Resistance(), new ElementIncrease(), new Pyro());

        $p2 = $p1->attack($p2, new Hydro());

        $this->assertSame(769, $p2->hp);
        $this->assertSame(5, $p2->element->getValue());

        $p1 = new State(1000, 100, 100, 10, new Resistance(), new ElementIncrease());
        $p2 = new State(1000, 100, 100, 10, new Resistance(), new ElementIncrease(), new Pyro(1));

        $p2 = $p1->attack($p2, new Hydro());

        $this->assertSame(769, $p2->hp);
        $this->assertSame(4, $p2->element->getValue());
        $this->assertInstanceOf(Hydro::class, $p2->element);
    }

    public function testAttackWithNotReactElement()
    {
        $p1 = new State(1000, 100, 100, 10, new Resistance(), new ElementIncrease());
        $p2 = new State(1000, 100, 100, 10, new Resistance(), new ElementIncrease(), new Pyro());

        $p2 = $p1->attack($p2, new Geo());

        $this->assertSame(885, $p2->hp);
        $this->assertSame(10, $p2->element->getValue());
    }
}
