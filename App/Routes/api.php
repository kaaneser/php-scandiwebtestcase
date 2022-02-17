<?php

$start->router->run('/getProducts', 'ProductController@getProducts');

$start->router->run('/addProduct', 'ProductController@addProduct', "post");
$start->router->run('/massDelete', 'ProductController@massDelete', "post");