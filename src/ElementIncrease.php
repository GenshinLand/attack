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
namespace Genshin\Attack;

/**
 * 元素增伤.
 */
class ElementIncrease
{
    public function __construct(
        public float $anemo = 0,
        public float $cyro = 0,
        public float $dendro = 0,
        public float $electro = 0,
        public float $geo = 0,
        public float $hydro = 0,
        public float $pyro = 0,
    ) {
    }
}
