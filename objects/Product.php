<?php

class Product
{
    private $metal;
    private $format;
    private $quantity;
    private $codi;

    /**
     * Product constructor.
     * @param $metal
     * @param $format
     * @param $quantity
     * @param $codi
     */
    public function __construct($codi, $format, $quantity, $metal)
    {
        $this->metal = $metal;
        $this->format = $format;
        $this->quantity = $quantity;
        $this->codi = $codi;
    }

    /**
     * @param $conn
     * @return mixedº
     */
    public static function selectAll($conn){
        $rQuery =  $conn->query("SELECT *  FROM products");
        foreach ($rQuery->fetchAll() as $product){
            $array[] = new Product($product['codi'],$product['format'],$product['quantity'],$product['metal']);
        }
        return $array;
    }

    public static function selectMetal($conn,$metal){
        $rQuery =  $conn->query("SELECT *  FROM products WHERE metal = '$metal'");
        foreach ($rQuery->fetchAll() as $product){
            $array[] = new Product($product['codi'],$product['format'],$product['quantity'],$product['metal']);
        }
        return $array;
    }

    public function preu(){
        global $preu;

        $valorMetal = $preu[$this->metal];

        try {
            return $this->format == 'Coin'?$valorMetal*$this->quantity:($valorMetal/PES_ONZA)*$this->quantity;
        } catch (ErrorException $e){
            return $this->format == 'Coin'?$valorMetal*$this->quantity:0;
        }
    }

    /**
     * @return string
     */
    public function __toString(){
        return $this->quantity.' '.$this->format.' '. $this->metal;
    }

    /**
     * @return string
     */
    public function img(){
        return "/img/".$this->getCodi().".jpg";
    }

    /**
     * @return mixed
     */
    public function getCodi()
    {
        return $this->codi;
    }

    public static function select($conn,$codi){
        $rQuery =  $conn->query("SELECT *  FROM products WHERE codi='$codi'");
        $product = $rQuery->fetch();
        return new Product($product['codi'],$product['format'],$product['quantity'],$product['metal']);
    }




}