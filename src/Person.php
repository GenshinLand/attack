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
use Genshin\Element\Reaction\ConsumeInterface;
use Genshin\Element\Reaction\IncreaseInterface;

class Person
{
    public function __construct(
        public int $hp,
        public int $attack,
        public int $defense,
        public Resistance $resistance,
        public ElementIncrease $increase,
        public ?ElementInterface $element = null
    ) {
    }

    public function withElement(ElementInterface $element): static
    {
        $this->element = $element;
        return $this;
    }

    public function attack(Person $person, ?ElementInterface $element = null): Person
    {
        if (! $element) {
            $hp = $this->attack * ($this->attack / $person->defense);

            $person->hp -= (int) max($hp, 0);

            return $person;
        }

        $reaction = $element->react($person->element);
        if ($reaction instanceof ConsumeInterface) {
            $value = $person->element->getValue() - $reaction->consume();
            if ($value > 0) {
                $person->element->setValue($value);
            }

            if ($value <= 0) {
                $person->element = null;
                if ($value < 0 && $element->isAttach()) {
                    // 附着转化
                    $person->element = $element->toEnum()->make(-$value);
                }
            }
        }

        $increase = 1 + $this->increase->getValue($element);

        if ($reaction instanceof IncreaseInterface) {
            $increase = $increase + $reaction->increase();
        }


        $attack = $this->attack * $increase;
        if ($attack > 0) {
            $hp = $attack * (1 - $person->resistance->getValue($person->element));
            $person->hp -= (int) max($hp, 0);
        }

        return $person;
    }
}
