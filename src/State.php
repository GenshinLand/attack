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

use JsonSerializable;
use Sworder\Element\ElementInterface;
use Sworder\Element\MainElement;
use Sworder\Element\Reaction\ConsumeInterface;
use Sworder\Element\Reaction\IncreaseInterface;

class State implements JsonSerializable
{
    public function __construct(
        public int $hp,
        public int $attack,
        public int $defense,
        public int $speed,
        public Resistance $resistance,
        public ElementIncrease $increase,
        public ?ElementInterface $element = null
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'hp' => $this->hp,
            'attack' => $this->attack,
            'defense' => $this->defense,
            'speed' => $this->speed,
            'resistance' => $this->resistance,
            'increase' => $this->increase,
            'element' => $this->element,
        ];
    }

    public static function make(array $data)
    {
        $resistance = new Resistance(...$data['resistance']);
        $increase = new ElementIncrease(...$data['increase']);
        $hp = $data['hp'];
        $attack = $data['attack'];
        $defense = $data['defense'];
        $speed = $data['speed'];
        $element = null;
        if (isset($data['element']['enum']) && $data['element']['value'] > 0) {
            $element = MainElement::from($data['element']['enum'])->make($data['element']['value']);
        }

        return new static(
            hp: $hp,
            attack: $attack,
            defense: $defense,
            speed: $speed,
            resistance: $resistance,
            increase: $increase,
            element: $element
        );
    }

    public function withElement(ElementInterface $element): static
    {
        $this->element = $element;
        return $this;
    }

    public function attack(State $person, ?ElementInterface $element = null, float $rate = 1.0): State
    {
        if (! $element) {
            $hp = $this->attack * ($this->attack / $person->defense) * $rate;

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

        $attack = $this->attack * $increase * $rate;
        if ($attack > 0) {
            $hp = $attack * (1 - $person->resistance->getValue($person->element));
            $person->hp -= (int) max($hp, 0);
        }

        return $person;
    }
}
