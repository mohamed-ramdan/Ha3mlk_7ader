<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function __autoload($classname) {
    $filename = $classname . ".php";
    include_once($filename);
}

$obj = ORM::getInstance();




//$obj->setTable('category');
//echo $obj->delete(array());
//$obj->setTable('cafeOrder');
//echo $obj->delete(array());
//$obj->setTable('orderComponent');
//echo $obj->delete(array());
//$obj->setTable('product');
//echo $obj->delete(array());
//$obj->setTable('user');
//echo $obj->delete(array());
echo "</br>";

echo"__________________________________________________________";
echo "</br>";



echo "category";

$obj->setTable('category');
echo $obj->insert(array('name' => 'launch'));

echo "</br>";
echo"__________________________________________________________";
echo "</br>";

echo "cafeorder";

$obj->setTable('cafeOrder');
echo $obj->insert(array('orderID' => 3, 'date' => '20-8-2013', 'amount' => 200, 'status' => 'avaliable', 'distinationRoomNumber' => 200, 'orderUserID' => 52, 'note' => 'hellow hurry plz'));

echo "</br>";

echo"__________________________________________________________";
echo "</br>";


echo "orderComponent";

$obj->setTable('orderComponent');
echo $obj->insert(array('orderID' => 3, 'productID' => 2, 'quantity' => 2));

echo "</br>";

echo"__________________________________________________________";
echo "</br>";


echo "product";


$obj->setTable('product');
echo $obj->insert(array('name' => 'coffe', 'price' => 100, 'picture' => '/upload/image/product/default.png', 'status' => 'avaliable', 'categoryID' => 11));

echo "</br>";

echo"__________________________________________________________";
echo "</br>";

echo "user";


$obj->setTable('user');
echo $obj->insert(array('name' => 'merit', 'email' => 'mero378@yahoo.com', 'password' => md5('123'), 'roomNumber' => 200, 'ext' => 100, 'picture' => 'upload/image/user/default.png', 'isAdmin' => 1));

echo "</br>";

echo"__________________________1_______________________________";
echo "</br>";


$retarray = $obj->select(array('email' => 'mero3@yahoo.com', 'password' => md5('123')));
var_dump($retarray);

echo "</br>";

echo"_____________________________2_____________________________";
echo "</br>";

$obj->setTable('user');
$retarray = $obj->select(array());
var_dump($retarray);
echo "</br>";

echo"______________________________3___________________________";
echo "</br>";

$retarray = $obj->select(array('email' => 'mero3@yahoo.com'));
var_dump($retarray);
echo "</br>";

echo"____________________4______________________________________";
echo "</br>";

$obj->setTable('product');
$retarray = $obj->select(array());

var_dump($retarray);
echo "</br>";

echo"________________________5_________________________________";
echo "</br>";

$obj->setTable('category');
$retarray = $obj->select(array(), "where categoryID>10");
var_dump($retarray);
echo "</br>";

echo"_________________________6________________________________";
echo "</br>";

//tables wll be sent
echo "</br>";

echo "complex select";
echo"__________________________7_______________________________";
echo "</br>";

$retarray = $obj->selectjoin(array("product", "category", "cafeOrder", "user", "orderComponent"), array("product.categoryID" => "category.categoryID", "user.userID" => "cafeOrder.orderUserID", "orderComponent.orderID" => "cafeOrder.orderID", "orderComponent.productID" => "product.productID"));

var_dump($retarray);
echo "</br>";



echo"____________________________8_____________________________";
echo "</br>";

$retarray = $obj->selectjoin(array("product", "category"), array("product.categoryID" => "category.categoryID",));

var_dump($retarray);



echo "</br>";

echo"___________________________9______________________________";
echo "</br>";

$obj->setTable('user');
echo $obj->update(array('name' => 'mero', 'email' => 'mero3mero@yahoo.com', 'password' => md5(123), 'roomNumber' => '200', 'ext' => 100, 'picture' => 'upload/image/user/default.png', 'isAdmin' => 0), array('userID' => 1));


echo"__________________________________________________________";


