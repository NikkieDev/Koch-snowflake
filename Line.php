<?php

include_once 'Point.php';

class Line
{
	public function __construct(public readonly Point $a, public readonly Point $b) {}

	public function getDistance(): float 
	{
		$dx = $this->b->x - $this->a->x;
		$dy = $this->b->y - $this->a->y;

		return sqrt(pow($dx, 2) + pow($dy, 2));
	}

	public function getAngle(): float
	{
		$dx = $this->b->x - $this->a->x;
		$dy = $this->b->y - $this->a->y;

		return atan2($dy, $dx);
	}
}
