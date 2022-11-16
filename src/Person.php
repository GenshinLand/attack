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
        $hp = $this->attack * ($this->attack / $person->defense);

        $person->hp -= $hp;

        return $person;
    }
}
