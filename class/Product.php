<?php
require_once("./include/bdd.php");

class Product
{
    public $id;
    public $product;
    public $quantity;
    public $price;
    public $gender;
    public $type;
    public $path;

    //CONSTRUCTOR

    public function __construct($id, $product, $quantity, $price, $gender, $type, $path)
    {
        $this->id = $id;
        $this->product = $product;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->gender = $gender;
        $this->type = $type;
        $this->path = $path;
    }

    public function register($bdd)
    {
        $register = $bdd->prepare("INSERT INTO `product` (`id`, `product`, `quantity`, `price`, `gender`, `type`, `path`) VALUES (NULL,?,?,?,?,?,?);");
        $register->execute([$this->product, $this->quantity, $this->price, $this->gender, $this->type, $this->path]);
    }

    public function delete($bdd)
    {
        $delete = $bdd->prepare("DELETE FROM product WHERE `product`.`id` = ? ");
        $delete->execute([$this->id]);
    }

    public function update($bdd)
    {
        $update = $bdd->prepare("UPDATE product SET product = ? , quantity = ? , price = ? , gender = ? , type = ? , path = ? WHERE product.id = ?");
        $update->execute([$this->product, $this->quantity, $this->price, $this->gender, $this->type, $this->path, $this->id]);
    }
}

// $product = new Product(6, "t-shirt noir", 6, 5, "Homme", "t-shirt", "ici");
// $product->register($bdd);
// $product->delete($bdd);
// $product->update($bdd);
