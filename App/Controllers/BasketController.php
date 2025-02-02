<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\DB\Connection;
use App\Core\HTTPException;
use App\Core\Model;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\User;
use http\Exception;
use PDO;

/**
 * Class HomeController
 * Example class of a controller
 * @package App\Controllers
 */
class BasketController extends AControllerBase
{
    /**
     * Authorize controller actions
     * @param $action
     * @return bool
     */
    public function authorize($action)
    {
        switch ($action) {
            case 'index':
            case 'add':
            case 'remove':
            case 'delete':
            case 'confirm':
                if ($this->app->getAuth()->isLogged()) {
                    $queryResult = User::getAll('`email` = ?', [$this->app->getAuth()->getLoggedUserId()]);
                    $user = $queryResult[0];
                    return (strcmp($user->getRole(), 'customer') === 0);
                }
                return false;
            default:
                return false;
        }
    }

    /**
     * Example of an action (authorization needed)
     * @return \App\Core\Responses\Response|\App\Core\Responses\ViewResponse
     */
    public function index(): Response
    {
        return $this->html();
    }

    public function add(): Response
    {
        if ($this->app->getAuth()->isLogged()) {
            $queryResult = User::getAll('`email` = ?', [$this->app->getAuth()->getLoggedUserId()]);
            $user = $queryResult[0];
            if (strcmp($user->getRole(), 'admin') === 0) {
                return $this->redirect($this->url('admin.index'));
            }
        } else {
            return new RedirectResponse(\App\Config\Configuration::LOGIN_URL);
        }
        $prodId = $this->app->getRequest()->getValue('id');
        $size = $this->app->getRequest()->getValue('size');
        $baskets = Basket::getAll('`customerId` = ?', [$user->getId()]);
        if (sizeof($baskets) === 0) {
            $basket = new Basket();
            $basket->setCustomerId($user->getId());
            $basket->save();
        } else {
            $basket = $baskets[0];
        }
        
        $prodSizes = ProductSize::getAll('`productId` = ? AND `size` = ?', [$prodId, $size]);
        if (sizeof($prodSizes) === 0) {
            throw new HTTPException(404);
        }
        $ps = $prodSizes[0];
        if ($ps->getQuantity() > 0) {
            $ps->setQuantity($ps->getQuantity() - 1);
            $ps->save();
            $basketItems = BasketItem::getAll('`productSizeId` = ? AND `basketId` = ?', [$ps->getId(), $basket->getId()]);
            if (sizeof($basketItems) > 0) {
                $bi = $basketItems[0];
                $bi->setQuantity($bi->getQuantity() + 1);
                $bi->save();
            } else {
                $bi = new BasketItem();
                $bi->setQuantity(1);
                $bi->setBasketId($basket->getId());
                $bi->setProductSizeId($ps->getId());
                $bi->save();
            }
        } else {
            throw new HTTPException(404);
        }

        return new RedirectResponse($this->url('product.display', ["id" => $prodId]));
    }

    public function remove(): Response
    {
        $queryResult = User::getAll('`email` = ?', [$this->app->getAuth()->getLoggedUserId()]);
        $user = $queryResult[0];
        $basketItemId = $this->app->getRequest()->getValue('id');
        $bi = BasketItem::getOne($basketItemId);
        $basket = Basket::getOne($bi->getBasketId());

        if ($basket->getCustomerId() === $user->getId()) {
            $this->removeBasketItem($basketItemId, true);
            return $this->redirect($this->url('basket.index'));
        } else {
            throw new HTTPException(403);
        }
    }

    public function delete(): Response
    {
        $queryResult = User::getAll('`email` = ?', [$this->app->getAuth()->getLoggedUserId()]);
        $user = $queryResult[0];
        $basketId = $this->app->getRequest()->getValue('id');
        $basket = Basket::getOne($basketId);
        if ($basket->getCustomerId() === $user->getId()) {
            $this->deleteBasket($basketId, true);
            return $this->redirect($this->url('basket.index'));
        } else {
            throw new HTTPException(403);
        }
    }

    public function confirm(): Response
    {
        $queryResult = User::getAll('`email` = ?', [$this->app->getAuth()->getLoggedUserId()]);
        $user = $queryResult[0];
        $basketId = $this->app->getRequest()->getValue('id');
        $basket = Basket::getOne($basketId);
        if ($basket->getCustomerId() === $user->getId()) {
            $order = new Order();
            $order->setCustomerId($user->getId());
            $order->save();
            foreach (BasketItem::getAll('`basketId` = ?', [$basket->getId()]) as $item) {
                $orderItem = new OrderItem();
                $orderItem->setProductSizeId($item->getProductSizeId());
                $orderItem->setQuantity($item->getQuantity());
                $orderItem->setOrderId($order->getId());
                $orderItem->save();
            }
            $this->deleteBasket($basketId, false);
            return $this->redirect($this->url('customer.index'));
        } else {
            throw new HTTPException(403);
        }
    }

    private function removeBasketItem(int $basketItemId, bool $restockItems): void
    {
        $bi = BasketItem::getOne($basketItemId);
        if ($restockItems) {
            $prodSize = ProductSize::getOne($bi->getProductSizeId());
            $prodSize->setQuantity($prodSize->getQuantity() + $bi->getQuantity());
            $prodSize->save();
        }
        $bi->delete();
    }

    private function deleteBasket(int $basketId, bool $restockItems): void
    {
        $basketItems = BasketItem::getAll('`basketId` = ?', [$basketId]);
        foreach ($basketItems as $bi) {
            $this->removeBasketItem($bi->getId(), $restockItems);
        }
        $basket = Basket::getOne($basketId);
        $basket->delete();
    }
}
