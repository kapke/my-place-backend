<?php
namespace Kapke\Bundle\MyPlaceBundle\Base;

interface ReadRepository {
	public function create(array $data = null);
	public function findAll();
	public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
}