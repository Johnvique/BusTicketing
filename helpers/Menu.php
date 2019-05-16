<?php
/**
 * Menu Items
 * All Project Menu
 * @category  Menu List
 */

class Menu{
	
	
	public static $navbarsideleft = array(
		array(
			'path' => 'home', 
			'label' => 'Home', 
			'icon' => '<i class="fa fa-home fa-2x"></i>'
		),
		
		array(
			'path' => 'employees', 
			'label' => 'Employees', 
			'icon' => '<i class="fa fa-group fa-2x"></i>'
		),
		
		array(
			'path' => 'buses', 
			'label' => 'Buses', 
			'icon' => '<i class="fa fa-bus fa-2x"></i>'
		),
		
		array(
			'path' => 'bookings', 
			'label' => 'Bookings', 
			'icon' => '<i class="fa fa-book fa-2x"></i>'
		),
		
		array(
			'path' => 'payments', 
			'label' => 'Payments', 
			'icon' => '<i class="fa fa-money fa-2x"></i>'
		),
		
		array(
			'path' => 'routes', 
			'label' => 'Routes', 
			'icon' => '<i class="fa fa-road fa-2x"></i>'
		),
		
		array(
			'path' => 'schedule', 
			'label' => 'Schedule', 
			'icon' => '<i class="fa fa-clock-o fa-2x"></i>'
		),
		
		array(
			'path' => 'reservations', 
			'label' => 'Reservations', 
			'icon' => '<i class="fa fa-pencil-square-o fa-2x"></i>'
		),
		
		array(
			'path' => 'complains', 
			'label' => 'Complains', 
			'icon' => '<i class="fa fa-comments fa-2x"></i>'
		),
		
		array(
			'path' => 'customers', 
			'label' => 'Customers', 
			'icon' => '<i class="fa fa-user-plus fa-2x"></i>'
		)
	);

	public static $navbartopleft = array(
		array(
			'path' => 'employees/add', 
			'label' => 'Add employees', 
			'icon' => '<i class="fa fa-plus-circle fa-2x"></i>'
		)
	);

	
	
}