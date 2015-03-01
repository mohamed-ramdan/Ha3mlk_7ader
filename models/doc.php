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



//delete example
//specify the table
//$obj->setTable('category');
//add the cond in that  format "colname='value or variable' and colname=colname" 
//$obj->delete("colname='value or variable' and colname=colname");
//or remove it empty
//echo $obj->delete();

//insert example
//set table name
//$obj->setTable('orderComponent');
//pass array in format of array 'colname' => no ,'colname' =>'string'
//echo $obj->insert(array('orderID' => 3, 'productID' => 2, 'quantity' => 2));




//select example 
//form of cond
//" colname= 'value or variable '  colname=num or  colname=colname "
//select take only one string in the above form.
//$email='mero378@yahoo.com';
//$retarray = $obj->select("email = '$email' and 'password' = md5('123') ");
//var_dump($retarray);


//select join the first is table name mandatory the other is cond conuld be empty

// give table name and the phrase after where
//$retarray = $obj->selectjoin(array("product", "category"), "product.categoryID = category.categoryID");

//first is array to update mand sec is cond
//$obj->setTable('user');
//echo $obj->update(array('name' => 'mero', 'password' => md5('123'), 'roomNumber' => 200, 'ext' => 100, 'picture' => 'upload/image/user/default.png', 'isAdmin' => 0),"isAdmin = 0");

//$retarray = $obj->select(" password = '123' ");
//var_dump($retarray);

