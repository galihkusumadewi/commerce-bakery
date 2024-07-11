<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'public/home';

$route['404_override'] = 'errors';
$route['translate_uri_dashes'] = FALSE;
// $route['product'] = 'Products/show_product';
$route['products'] = 'public/products';
$route['products/(:num)'] = 'public/products/index/$1';
//$route['products/cart'] = 'public/cart';
$route['products/detail_produk'] = 'public/products/detail_produk';
$route['career'] = 'public/career';
$route['outlet'] = 'public/outlet';
$route['promo'] = 'public/promo';
$route['member'] = 'member/promo';
$route['faq'] = 'public/faq';
// $route['tambah_data'] = 'public/tambah_data';

//MEMBER AREA

//CART
$route['cart'] = 'public/cart';
$route['purchase'] = 'public/purchase';
$route['cart/(:num)'] = 'public/cart/index/$1';
$route['cart/redeem'] = 'public/purchase/redeem/';
$route['cart/update_cart'] = 'public/cart/update_cart';
$route['update_cart'] = 'public/cart/update_cart';
$route['save_cart'] = 'public/cart/save_cart';
$route['cart/save_cart'] = 'public/cart/save_cart';
$route['remove_product'] = 'public/cart/remove_product';
$route['cart/remove_product'] = 'public/cart/remove_product';
$route['countCartProducts'] = 'public/cart/countCartProducts';
$route['redeem'] = 'public/purchase/redeem';

//Purchase Histories
$route['purchase/edit_purchase_status'] = 'master/purchase/edit_purchase_status';




//FAVORITE
$route['favorite'] = 'public/favorite';
$route['save_favorite'] = 'public/favorite/save_favorite';
$route['check_love_favorite'] = 'public/favorite/checkProductFavorite';
$route['remove_favorite'] = 'public/favorite/removeProductFavorite';



$route['home'] = 'public/home';
$route['login'] = 'public/login';
$route['forgot_password'] = 'public/forgot_password';
$route['email_verification'] = 'public/forgot_password/email_verification';
$route['confirmation_password'] = 'public/forgot_password/confirmation_password';
$route['save_new_password'] = 'public/forgot_password/save_new_password';

$route['process-login'] = 'member/login/login_member';
$route['logout'] = 'member/login/logout';
$route['register'] = 'member/register/register_member';
$route['profile'] = 'member/profile/profile_member';
$route['account'] = 'member/account';
$route['account/detail_history/(:num)'] = 'member/account/detail_history/$1';
$route['account/delete_history/(:num)'] = 'member/account/delete_history/$1';

//Pelamar Job
$route['career/pelamar'] = 'public/career/pelamar';

// Admin Dashboard
// -- LOGIN
$route['administrator'] = 'users/login';
$route['administrator/logout'] = 'users/login/logout';
$route['administrator/login_process'] = 'users/login/login_process';
// -- User Login
$route['administrator/dashboard'] = 'users/data/dashboard';
$route['administrator/profile'] = 'users/data';
$route['updatechart'] = 'users/data/updatechart';
//$route['administrator/dashboard'] = 'users/data/dashboard';




// // -- Data Product
// $route['administrator/tambahproduk'] = 'master/tambah_produk';
// $route['administrator/products'] = 'master/products';
// $route['administrator/products/ratings'] = 'master/products/ratings';
// $route['administrator/products/ratings/(:any)'] = 'master/products/ratings/1';
// // -- Data Categories
// $route['administrator/products'] = 'master/categories';
// $route['administrator/products/(:any)'] = 'master/categories/ratings';
// $route['administrator/products/ratings/(:any)'] = 'master/categories/ratings/1';
// // -- Data User
// $route['administrator/users'] = 'master/users';
// $route['administrator/users/(:any)'] = 'master/users/1';
// $route['administrator/users/role/(:any)'] = 'master/users/role/1';
// // -- Settings App
// $route['administrator/settings'] = 'settings/applications';
// $route['administrator/menus'] = 'settings/menus';
// $route['administrator/menus/(:any)'] = 'settings/menus/role';
// $route['administrator/menus/(:any)/(:any)'] = 'settings/menus/role/1';
// $route['administrator/roles'] = 'settings/roles';
// $route['administrator/roles/(:any)'] = 'settings/roles/role';
// $route['administrator/roles/(:any)/(:any)'] = 'settings/roles/user/1';
// $route['administrator/outlets'] = 'settings/outlets';
// $route['administrator/preferences'] = 'settings/preferences';
