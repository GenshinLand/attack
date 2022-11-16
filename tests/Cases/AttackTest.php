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

use Genshin\Attack\ElementIncrease;
use Genshin\Attack\Person;
use Genshin\Attack\Resistance;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class AttackTest extends TestCase
{
    public function testAttackWithNoElement()
    {
        $p1 = new Person(1000, 100, 100, new Resistance(), new ElementIncrease());
        $p2 = new Person(1000, 100, 100, new Resistance(), new ElementIncrease());

        $p2 = $p1->attack($p2);

        $this->assertSame(900, $p2->hp);
    }
}
