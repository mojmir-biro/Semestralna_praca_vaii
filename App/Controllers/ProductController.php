<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\DB\Connection;
use App\Core\HTTPException;
use App\Core\Model;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Models\Product;
use http\Exception;
use PDO;

class ProductController extends AControllerBase
{
    /**
     * Authorize controller actions
     * @param $action
     * @return bool
     */
    public function authorize($action)
    {
        switch ($action) {
            case 'edit':
            case 'delete':
            case 'add':
                return $this->app->getAuth()->isLogged();
            case 'getjson':
                return true;
            default:
                return $this->app->getAuth()->isLogged();
        }
    }

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        return $this->html();
    }

    public function add(): Response
    {
        return $this->html();
    }

    public function edit(): Response
    {
        $id = (int)$this->request()->getValue('id');
        $product = Product::getOne($id);

        if (is_null($product)) {
            throw new HTTPException(404);
        }

        return $this->html(
            [
                'product' => $product
            ]
        );
    }

    public function save()
    {
        $id = (int)$this->request()->getValue('id');

        if ($id > 0) {
            $product = Product::getOne($id);
        } else {
            $product = new Product();
        }

        $price = (double)$this->request()->getValue('price');
        $name = strip_tags($this->request()->getValue('productName'));
        $thumbnail = strip_tags($this->request()->getValue('thumbnail'));

        $product->setPrice($price);
        $product->setName($name);
        $product->setThumbnail($thumbnail);

        $product->save();
        return new RedirectResponse($this->url("admin.index"));
    }

    public function delete()
    {
        $id = (int)$this->request()->getValue('id');
        $product = Product::getOne($id);

        if (is_null($product)) {
            throw new HTTPException(404);
        } else {
            $product->delete();
            return new RedirectResponse($this->url("admin.index"));
        }
    }
}