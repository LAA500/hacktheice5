<?php

namespace App\Cart;

use App\Cart\Exceptions\InvalidConditionException;
use App\Cart\Exceptions\InvalidItemException;
use App\Cart\Helpers\Helpers;
use App\Cart\Validators\CartItemValidator;
use App\Cart\Exceptions\UnknownModelException;

class Cart
{
    protected $session;
    protected $events;
    protected $instanceName;
    protected $sessionKey;
    protected $sessionKeyCartItems;
    protected $sessionKeyCartConditions;
    protected $config;
    protected $currentItemId;

    protected $items;
    protected $cartConditions;

    public function __construct($session, $events, $instanceName, $session_key, $config)
    {
        $this->events = $events;
        $this->session = $session;
        $this->instanceName = $instanceName;
        $this->sessionKey = getCartId();
        $this->sessionKeyCartItems = $this->sessionKey . '_cart_items';
        $this->sessionKeyCartConditions = $this->sessionKey . '_cart_conditions';
        $this->config = $config;
        $this->currentItemId = null;

        $this->getContent();
        $this->getConditions();
    }

    /**
     * sets the session key
     *
     * @param string $sessionKey the session key or identifier
     * @return $this|bool
     * @throws \Exception
     */
    public function session($sessionKey)
    {
        if (!$sessionKey) throw new \Exception("Session key is required.");

        $this->sessionKey = $sessionKey;
        $this->sessionKeyCartItems = $this->sessionKey . '_cart_items';
        $this->sessionKeyCartConditions = $this->sessionKey . '_cart_conditions';

        return $this;
    }

    /**
     * Получить имя экземпляра корзины
     *
     * @return string
     */
    public function getInstanceName()
    {
        return $this->instanceName;
    }

    /**
     * Получить товар в корзине по ID
     *
     * @param $itemId
     * @return mixed
     */
    public function get($itemId)
    {
        return $this->items->get($itemId);
    }

    /**
     * Проверка, есть ли уже товар в корзине по ID
     *
     * @param $itemId
     * @return bool
     */
    public function has($itemId)
    {
        return $this->items->has($itemId);
    }

    /**
     * Добавление товара в корзину
     *
     * @param string|array $id
     * @param string $name
     * @param float $price
     * @param int $quantity
     * @param array $attributes
     * @param CartCondition|array $conditions
     * @param string $associatedModel
     * @return $this
     * @throws InvalidItemException
     */
    public function add($id, $name = null, $price = 1, $quantity = 1, $attributes = [], $conditions = [], $associatedModel = null)
    {
        if (is_array($id)) {
            if (Helpers::isMultiArray($id)) {
                foreach ($id as $item) {
                    $this->add(
                        $item['id'],
                        $item['name'],
                        $item['price'],
                        $item['quantity'],
                        Helpers::issetAndHasValueOrAssignDefault($item['attributes'], array()),
                        Helpers::issetAndHasValueOrAssignDefault($item['conditions'], array()),
                        Helpers::issetAndHasValueOrAssignDefault($item['associatedModel'], null)
                    );
                }
            } else {
                $this->add(
                    $id['id'],
                    $id['name'],
                    $id['price'],
                    $id['quantity'],
                    Helpers::issetAndHasValueOrAssignDefault($id['attributes'], array()),
                    Helpers::issetAndHasValueOrAssignDefault($id['conditions'], array()),
                    Helpers::issetAndHasValueOrAssignDefault($id['associatedModel'], null)
                );
            }

            return $this;
        }

        $data = [
            'id' => $id,
            'name' => $name,
            'price' => Helpers::normalizePrice($price),
            'quantity' => $quantity,
            'attributes' => new ItemAttributeCollection($attributes),
            'conditions' => $conditions
        ];

        if (isset($associatedModel) && $associatedModel != '') {
            $data['associatedModel'] = $associatedModel;
        }

        // Валидация данных
        $item = $this->validate($data);

        // Получить корзину
        $cart = $this->items;

        // Проверка, есть ли товар в корзине, если есть - обновить кол-во
        if ($cart->has($id)) {
            $this->update($id, $item);
        } else {
            $this->addRow($id, $item);
        }

        $this->currentItemId = $id;

        return $this;
    }

    /**
     * update a cart
     *
     * @param $id
     * @param array $data
     *
     * the $data will be an associative array, you don't need to pass all the data, only the key value
     * of the item you want to update on it
     * @return bool
     */
    public function update($id, $data)
    {
        if ($this->fireEvent('updating', $data) === false) {
            return false;
        }

        $cart = $this->items;

        $item = $cart->pull($id);

        foreach ($data as $key => $value) {
            // if the key is currently "quantity" we will need to check if an arithmetic
            // symbol is present so we can decide if the update of quantity is being added
            // or being reduced.
            if ($key == 'quantity') {
                // we will check if quantity value provided is array,
                // if it is, we will need to check if a key "relative" is set
                // and we will evaluate its value if true or false,
                // this tells us how to treat the quantity value if it should be updated
                // relatively to its current quantity value or just totally replace the value
                if (is_array($value)) {
                    if (isset($value['relative'])) {
                        if ((bool)$value['relative']) {
                            $item = $this->updateQuantityRelative($item, $key, $value['value']);
                        } else {
                            $item = $this->updateQuantityNotRelative($item, $key, $value['value']);
                        }
                    }
                } else {
                    $item = $this->updateQuantityRelative($item, $key, $value);
                }
            } elseif ($key == 'attributes') {
                $collection = new ItemAttributeCollection($value);
                $item[$key] = $item[$key]->merge($collection);
            } else {
                $item[$key] = $value;
            }
        }

        $cart->put($id, $item);

        $this->save($cart);

        $this->fireEvent('updated', $item);

        return true;
    }

    /**
     * add condition on an existing item on the cart
     *
     * @param int|string $productId
     * @param CartCondition $itemCondition
     * @return $this
     */
    public function addItemCondition($productId, $itemCondition)
    {
        if ($product = $this->get($productId)) {
            $conditionInstance = \App\Cart\CartCondition::class;

            if ($itemCondition instanceof $conditionInstance) {
                // we need to copy first to a temporary variable to hold the conditions
                // to avoid hitting this error "Indirect modification of overloaded element of Darryldecode\Cart\ItemCollection has no effect"
                // this is due to laravel Collection instance that implements Array Access
                // // see link for more info: http://stackoverflow.com/questions/20053269/indirect-modification-of-overloaded-element-of-splfixedarray-has-no-effect
                $itemConditionTempHolder = $product['conditions'];

                if (is_array($itemConditionTempHolder)) {
                    array_push($itemConditionTempHolder, $itemCondition);
                } else {
                    $itemConditionTempHolder = $itemCondition;
                }

                $this->update($productId, array(
                    'conditions' => $itemConditionTempHolder // the newly updated conditions
                ));
            }
        }

        return $this;
    }

    /**
     * Удалить товар из корзины по ID
     *
     * @param $id
     * @return bool
     */
    public function remove($id)
    {
        $cart = $this->items;

        $cart->forget($id);

        $this->save($cart);

        return true;
    }

    /**
     * Очистить корзину
     * 
     * @return bool
     */
    public function clear()
    {
        $this->session->put(
            $this->sessionKeyCartItems,
            []
        );

        return true;
    }

    /**
     * Добавление условия в корзину
     *
     * @param CartCondition|array $condition
     * @return $this
     * @throws InvalidConditionException
     */
    public function condition($condition)
    {
        if (is_array($condition)) {
            foreach ($condition as $c) {
                $this->condition($c);
            }

            return $this;
        }

        if (!$condition instanceof CartCondition) throw new InvalidConditionException('Argument 1 must be an instance of \'App\Cart\CartCondition\' 3');

        $conditions = $this->cartConditions;

        // Check if order has been applied
        if ($condition->getOrder() == 0) {
            $last = $conditions->last();
            $condition->setOrder(!is_null($last) ? $last->getOrder() + 1 : 1);
        }

        $conditions->put($condition->getName(), $condition);

        $conditions = $conditions->sortBy(function ($condition, $key) {
            return $condition->getOrder();
        });

        $this->saveConditions($conditions);

        return $this;
    }

    /**
     * Получить условия корзины
     *
     * @return CartConditionCollection
     */
    public function getConditions()
    {
        $this->cartConditions = new CartConditionCollection($this->session->get($this->sessionKeyCartConditions));
    }

    /**
     * get condition applied on the cart by its name
     *
     * @param $conditionName
     * @return CartCondition
     */
    public function getCondition($conditionName)
    {
        return $this->cartConditions->get($conditionName);
    }

    /**
     * Get all the condition filtered by Type
     * Please Note that this will only return condition added on cart bases, not those conditions added
     * specifically on an per item bases
     *
     * @param $type
     * @return CartConditionCollection
     */
    public function getConditionsByType($type)
    {
        return $this->cartConditions->filter(function (CartCondition $condition) use ($type) {
            return $condition->getType() == $type;
        });
    }


    /**
     * Remove all the condition with the $type specified
     * Please Note that this will only remove condition added on cart bases, not those conditions added
     * specifically on an per item bases
     *
     * @param $type
     * @return $this
     */
    public function removeConditionsByType($type)
    {
        $this->getConditionsByType($type)->each(function ($condition) {
            $this->removeCartCondition($condition->getName());
        });
    }


    /**
     * removes a condition on a cart by condition name,
     * this can only remove conditions that are added on cart bases not conditions that are added on an item/product.
     * If you wish to remove a condition that has been added for a specific item/product, you may
     * use the removeItemCondition(itemId, conditionName) method instead.
     *
     * @param $conditionName
     * @return void
     */
    public function removeCartCondition($conditionName)
    {
        $conditions = $this->cartConditions;

        $conditions->pull($conditionName);

        $this->saveConditions($conditions);
    }

    /**
     * remove a condition that has been applied on an item that is already on the cart
     *
     * @param $itemId
     * @param $conditionName
     * @return bool
     */
    public function removeItemCondition($itemId, $conditionName)
    {
        if (!$item = $this->items->get($itemId)) {
            return false;
        }

        if ($this->itemHasConditions($item)) {
            // NOTE:
            // we do it this way, we get first conditions and store
            // it in a temp variable $originalConditions, then we will modify the array there
            // and after modification we will store it again on $item['conditions']
            // This is because of ArrayAccess implementation
            // see link for more info: http://stackoverflow.com/questions/20053269/indirect-modification-of-overloaded-element-of-splfixedarray-has-no-effect

            $tempConditionsHolder = $item['conditions'];

            // if the item's conditions is in array format
            // we will iterate through all of it and check if the name matches
            // to the given name the user wants to remove, if so, remove it
            if (is_array($tempConditionsHolder)) {
                foreach ($tempConditionsHolder as $k => $condition) {
                    if ($condition->getName() == $conditionName) {
                        unset($tempConditionsHolder[$k]);
                    }
                }

                $item['conditions'] = $tempConditionsHolder;
            }

            // if the item condition is not an array, we will check if it is
            // an instance of a Condition, if so, we will check if the name matches
            // on the given condition name the user wants to remove, if so,
            // lets just make $item['conditions'] an empty array as there's just 1 condition on it anyway
            else {
                $conditionInstance = "App\\Cart\\CartCondition";

                if ($item['conditions'] instanceof $conditionInstance) {
                    if ($tempConditionsHolder->getName() == $conditionName) {
                        $item['conditions'] = array();
                    }
                }
            }
        }

        $this->update($itemId, array(
            'conditions' => $item['conditions']
        ));

        return true;
    }

    /**
     * remove all conditions that has been applied on an item that is already on the cart
     *
     * @param $itemId
     * @return bool
     */
    public function clearItemConditions($itemId)
    {
        if (!$item = $this->items->get($itemId)) {
            return false;
        }

        $this->update($itemId, array(
            'conditions' => array()
        ));

        return true;
    }

    /**
     * clears all conditions on a cart,
     * this does not remove conditions that has been added specifically to an item/product.
     * If you wish to remove a specific condition to a product, you may use the method: removeItemCondition($itemId, $conditionName)
     *
     * @return void
     */
    public function clearCartConditions()
    {
        $this->session->put(
            $this->sessionKeyCartConditions,
            array()
        );
    }

    /**
     * get cart sub total without conditions
     * @param bool $formatted
     * @return float
     */
    public function getSubTotalWithoutConditions()
    {
        $cart = $this->items;

        $sum = $cart->sum(function ($item) {
            return filter_var($item->getPriceSum(), FILTER_SANITIZE_NUMBER_FLOAT);
        });

        return floatval($sum);
    }

    /**
     * get cart sub total
     * @param bool $formatted
     * @return float
     */
    public function getSubTotal()
    {
        $cart = $this->items;

        $sum = $cart->sum(function (ItemCollection $item) {
            return $item->getPriceSumWithConditions(false);
        });

        // get the conditions that are meant to be applied
        // on the subtotal and apply it here before returning the subtotal
        $conditions = $this->cartConditions
            ->filter(function (CartCondition $cond) {
                return $cond->getTarget() === 'subtotal';
            });

        // if there is no conditions, lets just return the sum
        if (!$conditions->count()) return floatval($sum);

        // there are conditions, lets apply it
        $newTotal = 0;
        $process = 0;

        $conditions->each(function (CartCondition $cond) use ($sum, &$newTotal, &$process) {

            // if this is the first iteration, the toBeCalculated
            // should be the sum as initial point of value.
            $toBeCalculated = ($process > 0) ? $newTotal : $sum;

            $newTotal = $cond->applyCondition($toBeCalculated);

            $process++;
        });

        return floatval($newTotal);
    }

    /**
     * the new total in which conditions are already applied
     *
     * @return float
     */
    public function getTotal()
    {
        $subTotal = $this->getSubTotal();

        $newTotal = 0;

        $process = 0;

        $conditions = $this
            ->getConditions()
            ->filter(function (CartCondition $cond) {
                return $cond->getTarget() === 'total';
            });

        // if no conditions were added, just return the sub total
        if (!$conditions->count()) {
            return $subTotal;
        }

        $conditions
            ->each(function (CartCondition $cond) use ($subTotal, &$newTotal, &$process) {
                $toBeCalculated = ($process > 0) ? $newTotal : $subTotal;

                $newTotal = $cond->applyCondition($toBeCalculated);

                $process++;
            });

        return $newTotal;
    }

    /**
     * get total quantity of items in the cart
     *
     * @return int
     */
    public function getTotalQuantity()
    {
        $items = $this->items;

        if ($items->isEmpty()) return 0;

        $count = $items->sum(function ($item) {
            return $item['quantity'];
        });

        return $count;
    }

    /**
     * get the cart
     *
     * @return CartCollection
     */
    public function getContent()
    {
        $this->items = (new CartCollection($this->session->get($this->sessionKeyCartItems)))->reject(function ($item) {
            return !($item instanceof ItemCollection);
        });
    }

    /**
     * check if cart is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->items->isEmpty();
    }

    /**
     * validate Item data
     *
     * @param $item
     * @return array $item;
     * @throws InvalidItemException
     */
    protected function validate($item)
    {
        $rules = [
            'id' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric|min:0.1',
            'name' => 'required|string',
        ];

        $validator = CartItemValidator::make($item, $rules);

        if ($validator->fails()) {
            throw new InvalidItemException($validator->messages()->first());
        }

        return $item;
    }

    /**
     * add row to cart collection
     *
     * @param $id
     * @param $item
     * @return bool
     */
    protected function addRow($id, $item)
    {
        if ($this->fireEvent('adding', $item) === false) {
            return false;
        }

        $cart = $this->items;

        $cart->put($id, new ItemCollection($item, $this->config));

        $this->save($cart);

        $this->fireEvent('added', $item);

        return true;
    }

    /**
     * save the cart
     *
     * @param $cart CartCollection
     */
    protected function save($cart)
    {
        $this->session->put($this->sessionKeyCartItems, $cart);
    }

    /**
     * save the cart conditions
     *
     * @param $conditions
     */
    protected function saveConditions($conditions)
    {
        $this->session->put($this->sessionKeyCartConditions, $conditions);
    }

    /**
     * check if an item has condition
     *
     * @param $item
     * @return bool
     */
    protected function itemHasConditions($item)
    {
        if (!isset($item['conditions'])) return false;

        if (is_array($item['conditions'])) {
            return count($item['conditions']) > 0;
        }

        $conditionInstance = "App\\Cart\\CartCondition";

        if ($item['conditions'] instanceof $conditionInstance) return true;

        return false;
    }

    /**
     * update a cart item quantity relative to its current quantity
     *
     * @param $item
     * @param $key
     * @param $value
     * @return mixed
     */
    protected function updateQuantityRelative($item, $key, $value)
    {
        if (preg_match('/\-/', $value) == 1) {
            $value = (int)str_replace('-', '', $value);

            // we will not allowed to reduced quantity to 0, so if the given value
            // would result to item quantity of 0, we will not do it.
            if (($item[$key] - $value) > 0) {
                $item[$key] -= $value;
            }
        } elseif (preg_match('/\+/', $value) == 1) {
            $item[$key] += (int)str_replace('+', '', $value);
        } else {
            $item[$key] += (int)$value;
        }

        return $item;
    }

    /**
     * update cart item quantity not relative to its current quantity value
     *
     * @param $item
     * @param $key
     * @param $value
     * @return mixed
     */
    protected function updateQuantityNotRelative($item, $key, $value)
    {
        $item[$key] = (int)$value;

        return $item;
    }

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    protected function fireEvent($name, $value = [])
    {
        return $this->events->dispatch($this->getInstanceName() . '.' . $name, array_values([$value, $this]), true);
    }

    /**
     * Associate the cart item with the given id with the given model.
     *
     * @param string $id
     * @param mixed  $model
     *
     * @return void
     */
    public function associate($model)
    {
        if (is_string($model) && !class_exists($model)) {
            throw new UnknownModelException("The supplied model {$model} does not exist.");
        }

        $cart = $this->items;

        $item = $cart->pull($this->currentItemId);

        $item['associatedModel'] = $model;

        $cart->put($this->currentItemId, new ItemCollection($item, $this->config));

        $this->save($cart);

        return $this;
    }
}
