<?php

interface CRUD
{
	public function create(\Slim\Slim $app);
	public function update(\Slim\Slim $app);
	public function get(\Slim\Slim $app, $id);
	public function getall(\Slim\Slim $app);
	public function delete(\Slim\Slim $app, $id);
	public function check_duplicate($object);
}