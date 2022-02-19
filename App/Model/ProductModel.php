<?php

namespace App\Model;

use Core\BaseModel;

class ProductModel extends BaseModel
{
    public function getProducts()
    {
        return $this->db->query("SELECT Product.SKU, Name, Price, Size, Width, Height, Length, Weight FROM product
            LEFT JOIN furniture ON product.SKU = furniture.SKU
            LEFT JOIN book ON product.SKU = book.SKU
            LEFT JOIN dvd ON product.SKU = dvd.SKU;
        ", true);
    }

    public function massDelete($data)
    {
        $sql = "DELETE FROM product WHERE product.SKU IN (" . $data . ");";
        return $this->db->connect->prepare($sql)->execute();
    }

    public function AddDVD($data)
    {
        $addProduct = $this->db->connect->prepare("INSERT INTO product (SKU, Name, Price) VALUES (:sku, :name, :price)");
        $addProduct->execute([
            ":sku" => $data->SKU,
            ":name" => $data->Name,
            ":price" => $data->Price
        ]);
        $addDVD = $this->db->connect->prepare("INSERT INTO dvd (SKU, Size) VALUES (:sku, :size)");
        $addDVD->execute([
            ":sku" => $data->SKU,
            ":size" => $data->additionalInfo->Size
        ]);
    }

    public function AddBook($data)
    {
        $addProduct = $this->db->connect->prepare("INSERT INTO product (SKU, Name, Price) VALUES (:sku, :name, :price)");
        $addProduct->execute([
            ":sku" => $data->SKU,
            ":name" => $data->Name,
            ":price" => $data->Price
        ]);
        $addBook = $this->db->connect->prepare("INSERT INTO book (SKU, Weight) VALUES (:sku, :weight)");
        $addBook->execute([
            ":sku" => $data->SKU,
            ":weight" => $data->additionalInfo->Weight
        ]);
    }

    public function AddFurniture($data)
    {
        $addProduct = $this->db->connect->prepare("INSERT INTO product (SKU, Name, Price) VALUES (:sku, :name, :price)");
        $addProduct->execute([
            ":sku" => $data->SKU,
            ":name" => $data->Name,
            ":price" => $data->Price
        ]);
        $addFurniture = $this->db->connect->prepare("INSERT INTO furniture (SKU, Height, Width, Length) VALUES (:sku, :height, :width, :length)");
        $addFurniture->execute([
            ":sku" => $data->SKU,
            ":height" => $data->additionalInfo->Height,
            ":width" => $data->additionalInfo->Width,
            ":length" => $data->additionalInfo->Length
        ]);
    }
}