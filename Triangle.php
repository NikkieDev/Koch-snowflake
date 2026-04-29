<?php

include_once 'Point.php';

class Triangle
{
	public function __construct(
		public readonly Point $a,
		public readonly Point $b,
		public readonly Point $c,
	) {}

	public function getCenterX()
	{
		return ($this->a->x + $this->b->x + $this->c->x) / 3;
	}

	public function getCenterY()
	{
		return ($this->a->y + $this->b->y + $this->c->y) / 3;
	}
}
