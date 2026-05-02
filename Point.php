<?php

class Point
{
	public function __construct(public readonly float $x, public readonly float $y) {}

	public function turn(float $offset, float $distance, bool $positive = true): Point 
	{
		$angle = deg2rad($positive?60:-60) + $offset;
		return new Point(
			$this->x + cos($angle) * $distance,
			$this->y + sin($angle) * $distance,
		);
	}
}
