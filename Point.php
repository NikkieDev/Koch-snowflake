<?php

class Point
{
	public function __construct(public readonly float $x, public readonly float $y) {}

	public function turn(float $angle, float $distance): Point 
	{
		return new Point(
			$this->x + cos($angle) * $distance,
			$this->y + sin($angle) * $distance,
		);
	}
}
