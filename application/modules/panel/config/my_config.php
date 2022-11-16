<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| CI Bootstrap 3 Configuration
| -------------------------------------------------------------------------
| This file lets you define default values to be passed into views 
| when calling MY_Controller's render() function. 
| 
| See example and detailed explanation from:
| 	/application/config/ci_bootstrap_example.php
*/

$config['my_config'] = array(

	// Site name
	'site_name' => 'Repairer',

	// Default page title prefix
	'page_title_prefix' => '',

	// Default page title
	'page_title' => '',

	// Default meta data
	'meta_data'	=> array(
		'author'		=> '',
		'description'	=> '',
		'keywords'		=> ''
	),
	
	

	// Default CSS class for <body> tag
	'body_class' => 'hold-transition sidebar-mini',
	
	// Menu items
	'menu' => array(
		'welcome' => array(
			'name'		=> 'home',
			'url'		=> 'welcome/index',
			'icon'		=> 'fas fa-tachometer-alt',
			'icon_material'		=> 'dashboard',
		),
		'reparation' => array(
			'name'		=> 'repair/index',
			'url'		=> 'reparation',
			'icon'		=> 'fas fa-list-alt',
			'icon_material'		=> 'list',
		),

		'customers' => array(
			'name'		=> 'customers/index',
			'url'		=> 'customers',
			'icon'		=> 'fas fa-users',
			'icon_material'		=> 'people',
		),

		'inventory' => array(
			'name'		=> 'inventory',
			'url'		=> 'inventory',
			'icon'		=> 'fa fa-tasks',
			'icon_material'		=> 'shopping_basket',
			'children'  => array(
				'view_stock'	=> 'inventory',
				'add_stock'	=> 'inventory/add',
				'suppliers'	=> 'inventory/suppliers',
				'inventory/manufacturers'	=> 'inventory/manufacturers',
				'inventory/models'	=> 'inventory/models',
			)
		),

		'pos' => array(
			'name'		=> 'pos',
			'url'		=> 'pos',
			'icon'		=> 'fa fa-desktop',
		),


		'purchases' => array(
			'name'		=> 'purchases',
			'url'		=> 'purchases',
			'icon'		=> 'fa fa-tasks',
			'icon_material'		=> 'list',
			'children'  => array(
				'view_purchases'	=> 'purchases',
				'add_purchase'	=> 'purchases/add',
			)
		),

		'reports' => array(
			'name'		=> 'reports',
			'url'		=> 'reports',
			'icon'		=> 'fas fa-chart-pie',
			'icon_material'		=> 'donut_small',
			'children'  => array(
				'stock_chart'			=> 'reports/stock',
				'finance_chart'		=> 'reports/finance',
				'alert_quantity'		=> 'reports/quantity_alerts',
				'sales'		=> 'reports/sales',
				'drawer_report'		=> 'reports/drawer',
			)
		),


		'barcode' => array(
			'name'		=> 'barcode',
			'url'		=> 'barcode',
			'icon'		=> 'fa fa-barcode',
		),

		
	),

	// Login page
	'login_url' => 'panel/login',

	
	// AdminLTE settings
	'adminlte' => array(
		'body_class' 	=> array(
			'admin'	=> 'skin-purple',
		)
	),

	// Debug tools
	'debug' => array(
		'view_data'	=> FALSE,
		'profiler'	=> FALSE
	),
);

/*
| -------------------------------------------------------------------------
| Override values from /application/config/config.php
| -------------------------------------------------------------------------
*/
$config['sess_cookie_name'] = 'ci_session_admin';