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

use Genshin\Element\ElementInterface;
use Genshin\Element\Enum;

/**
 * 元素增伤.
 */
class ElementIncrease
{
    public function __construct(
        public float $anemo = 0,
        public float $cryo = 0,
        public float $dendro = 0,
        public float $electro = 0,
        public float $geo = 0,
        public float $hydro = 0,
        public float $pyro = 0,
        public float $gold = 0,
    ) {
    }

    public function getValue(ElementInterface $element): float
    {
        return match ($element->toEnum()) {
            Enum::ANEMO => $this->anemo,
            Enum::CRYO => $this->cryo,
            Enum::DENDRO => $this->dendro,
            Enum::ELECTRO => $this->electro,
            Enum::GEO => $this->geo,
            Enum::HYDRO => $this->hydro,
            Enum::PYRO => $this->pyro,
            Enum::GOLD => $this->gold,
        };
    }
}
