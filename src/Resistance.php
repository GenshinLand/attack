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
 * 抗性.
 */
class Resistance
{
    public function __construct(
        public float $anemo = -0.16,
        public float $cyro = -0.16,
        public float $dendro = -0.16,
        public float $electro = -0.16,
        public float $geo = -0.16,
        public float $hydro = -0.16,
        public float $pyro = -0.16,
    ) {
    }
}
