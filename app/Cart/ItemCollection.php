<?php

namespace App\Cart;

use App\Cart\Helpers\Helpers;
use Illuminate\Support\Collection;

class ItemCollection extends Collection
{

    /**
     * Sets the config parameters.
     *
     * @var
     */
    protected $config;

    /**
     * ItemCollection constructor.
     * @param array|mixed $items
     * @param $config
     */
    public function __construct($items, $config = [])
    {
        parent::__construct($items);

        $this->config = $config;
    }

    /**
     * Получить цену товара
     *
     * @return mixed|null
     */
    public function getPriceSum()
    {
        return $this->price * $this->quantity;
    }

    public function __get($name)
    {
        if ($this->has($name) || $name == 'model') {
            return !is_null($this->get($name)) ? $this->get($name) : $this->getAssociatedModel();
        }
        return null;
    }

    /**
     * Возвращает связанную модель товара
     *
     * @return bool
     */
    protected function getAssociatedModel()
    {
        if (!$this->has('associatedModel')) {
            return null;
        }

        $associatedModel = $this->get('associatedModel');

        return with(new $associatedModel())->find($this->get('id'));
    }

    /**
     * Проверка, есть ли у товара условия
     *
     * @return bool
     */
    public function hasConditions()
    {
        if (!isset($this['conditions'])) return false;
        if (is_array($this['conditions'])) {
            return count($this['conditions']) > 0;
        }
        $conditionInstance = "App\\Cart\\CartCondition";
        if ($this['conditions'] instanceof $conditionInstance) return true;

        return false;
    }

    /**
     * Вывести условия
     *
     * @return mixed|null
     */
    public function getConditions()
    {
        if (!$this->hasConditions()) return [];
        return $this['conditions'];
    }

    /**
     * Получить цену товара, в которой уже применены условия (скидки, налог и пр.)
     * 
     * @return mixed|null
     */
    public function getPriceWithConditions()
    {
        $originalPrice = $this->price;
        $newPrice = 0;
        $processed = 0;

        if ($this->hasConditions()) {
            if (is_array($this->conditions)) {
                foreach ($this->conditions as $condition) {
                    ($processed > 0) ? $toBeCalculated = $newPrice : $toBeCalculated = $originalPrice;
                    $newPrice = $condition->applyCondition($toBeCalculated);
                    $processed++;
                }
            } else {
                $newPrice = $this['conditions']->applyCondition($originalPrice);
            }

            return $newPrice;
        }
        return $originalPrice;
    }

    /**
     * Получить сумму, в которой уже применены условия (скидки, налог и пр.)
     * 
     * @return mixed|null
     */
    public function getPriceSumWithConditions()
    {
        return $this->getPriceWithConditions(false) * $this->quantity;
    }
}
