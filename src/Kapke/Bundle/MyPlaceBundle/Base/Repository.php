<?php
interface Repository extends ReadRepository {
	public function remove($instance);
	public function persist($instance);
}