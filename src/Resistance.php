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
namespace Sworder\Attack;

use Sworder\Element\ElementInterface;
use Sworder\Element\MainElement;
use Sworder\Element\VariantElement;

/**
 * 抗性.
 */
class Resistance
{
    public function __construct(
        public float $gold = -0.16,
        public float $dendro = -0.16,
        public float $hydro = -0.16,
        public float $pyro = -0.16,
        public float $geo = -0.16,
        public float $anemo = -0.16,
        public float $cryo = -0.16,
        public float $electro = -0.16,
    ) {
    }

    public function getValue(ElementInterface $element): float
    {
        return match ($element->toEnum()) {
            MainElement::GOLD => $this->gold,
            MainElement::DENDRO => $this->dendro,
            MainElement::HYDRO => $this->hydro,
            MainElement::PYRO => $this->pyro,
            MainElement::GEO => $this->geo,
            VariantElement::ANEMO => $this->anemo,
            VariantElement::CRYO => $this->cryo,
            VariantElement::ELECTRO => $this->electro,
        };
    }
}
