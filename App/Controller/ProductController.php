<?php

namespace App\Controller;

use App\Model\ProductModel;
use Core\BaseController;

class ProductController extends BaseController
{
    public function getProducts()
    {
        $ProductModel = new ProductModel();
        print_r(json_encode($ProductModel->getProducts()));
    }

    public function addProduct()
    {
        $data = json_decode($_POST['product']);

        $ProductModel = new ProductModel();
        $func = "Add" . $data->ProductType;
        print_r($ProductModel->$func($data));
    }

    public function massDelete()
    {
        $products = explode(",", $_POST['productList']);
        for ($i=0; $i < count($products); $i++) { 
            $products[$i] = '"' . $products[$i] . '"';
        }
        $productList = implode(",", $products);
        
        $ProductModel = new ProductModel();
        print_r($ProductModel->massDelete($productList));
    }
}