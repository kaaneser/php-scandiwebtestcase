<?php

namespace App\Model;

use Core\BaseModel;

class ProductModel extends BaseModel
{
    public function getProducts()
    {
        return $this->db->query("SELECT Product.SKU, Name, Price, Size, Width, Height, Length, Weight FROM Product
            LEFT JOIN Furniture ON Product.SKU = Furniture.SKU
            LEFT JOIN Book ON Product.SKU = Book.SKU
            LEFT JOIN DVD ON Product.SKU = DVD.SKU;
        ", true);
    }

    public function massDelete($data)
    {
        $sql = "DELETE FROM Product WHERE Product.SKU IN (" . $data . ");";
        return $this->db->connect->prepare($sql)->execute();
    }

    public function AddDVD($data)
    {
        $addProduct = $this->db->connect->prepare("INSERT INTO Product (SKU, Name, Price) VALUES (:sku, :name, :price)");
        $addProduct->execute([
            ":sku" => $data->SKU,
            ":name" => $data->Name,
            ":price" => $data->Price
        ]);
        $addDVD = $this->db->connect->prepare("INSERT INTO DVD (SKU, Size) VALUES (:sku, :size)");
        $addDVD->execute([
            ":sku" => $data->SKU,
            ":size" => $data->additionalInfo->Size
        ]);
    }

    public function AddBook($data)
    {
        $addProduct = $this->db->connect->prepare("INSERT INTO Product (SKU, Name, Price) VALUES (:sku, :name, :price)");
        $addProduct->execute([
            ":sku" => $data->SKU,
            ":name" => $data->Name,
            ":price" => $data->Price
        ]);
        $addDVD = $this->db->connect->prepare("INSERT INTO Book (SKU, Weight) VALUES (:sku, :weight)");
        $addDVD->execute([
            ":sku" => $data->SKU,
            ":weight" => $data->additionalInfo->Weight
        ]);
    }

    public function AddFurniture($data)
    {
        $addProduct = $this->db->connect->prepare("INSERT INTO Product (SKU, Name, Price) VALUES (:sku, :name, :price)");
        $addProduct->execute([
            ":sku" => $data->SKU,
            ":name" => $data->Name,
            ":price" => $data->Price
        ]);
        $addDVD = $this->db->connect->prepare("INSERT INTO Furniture (SKU, Height, Width, Length) VALUES (:sku, :height, :width, :length)");
        $addDVD->execute([
            ":sku" => $data->SKU,
            ":height" => $data->additionalInfo->Height,
            ":width" => $data->additionalInfo->Width,
            ":length" => $data->additionalInfo->Length
        ]);
    }
}