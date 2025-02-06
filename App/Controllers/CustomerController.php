<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\User;

/**
 * 
 * @package App\Controllers
 */
class CustomerController extends AControllerBase
{
    /**
     * Authorize controller actions
     * @param $action
     * @return bool
     */
    public function authorize($action)
    {
        if ($this->app->getAuth()->isLogged()) {
            $queryResult = User::getAll('`email` = ?', [$this->app->getAuth()->getLoggedUserId()]);
            $user = $queryResult[0];
            return (strcmp($user->getRole(), 'customer') === 0);
        }
        return false;
    }

    /**
     * Example of an action (authorization needed)
     * @return \App\Core\Responses\Response|\App\Core\Responses\ViewResponse
     */
    public function index(): Response
    {
        //die($this->app->getRequest()->getValue('result'));
        return $this->html();
    }

    public function edit(): Response
    {
        $name = strip_tags($this->app->getRequest()->getValue('name'));
        $street = strip_tags($this->app->getRequest()->getValue('street'));
        $city = strip_tags($this->app->getRequest()->getValue('city'));
        $country = strip_tags($this->app->getRequest()->getValue('country'));
        $postalCode = strip_tags($this->app->getRequest()->getValue('postal'));

        if (strlen($name) < 3) {
            //name too short
            return $this->redirect($this->url("customer.index", ['result' => 'short_name']));
        }
        if (!is_numeric($postalCode) && strlen($postalCode) !== 0) {
            //postal code contains letters
            return $this->redirect($this->url("customer.index", ['result' => 'invalid_postal']));
        }
        if (strlen($country) > 3 && strcmp($country, 'NO_VAL') !== 0) {
            //invalid country code
            return $this->redirect($this->url("customer.index", ['result' => 'invalid_country']));
        }

        $countryCodes = ['NO_VAL', 'CZE', 'HUN', 'GER', 'POL', 'AUT', 'SVK', 'UKR'];
        $valid = false;
        foreach ($countryCodes as $cntr) {
            if (strcmp($country, $cntr) === 0) {
                $valid = true;
                break;
            }
        }

        if (!$valid) {
            //invalid country code
            return $this->redirect($this->url("customer.index", ['result' => 'invalid_country']));
        }

        $queryResult = User::getAll('`email` = ?', [$this->app->getAuth()->getLoggedUserId()]);
        $user = $queryResult[0];

        $user->setName($name);
        $user->setCity($city);
        $user->setCountry($country);
        $user->setStreet($street);
        $user->setPostalCode($postalCode);

        $user->save();
        
        return $this->redirect($this->url('customer.index'));
    }
}