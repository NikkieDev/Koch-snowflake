<?php

include_once 'Point.php';
include_once 'Line.php';

class Image
{
	private $image;
	public int $white, $black, $special;

	public function __construct(
		public readonly int $size,
	)
	{
		$this->image = imagecreatetruecolor($size, $size);
		$this->white = imagecolorallocate($this->image, 255, 255, 255);
		$this->black = imagecolorallocate($this->image, 0, 0, 0);
		$this->special = imagecolorallocate($this->image, 255, 0, 128);

		imagefill($this->image, 0, 0, $this->black);
	}

	/**
	 * <summary>
	 * return center of self in cartesic coordinates
	 * </summary>
	 *
	 * <algo>
	 * Create a new point with X & Y both being half the $size of this object
	 * </algo>
	 */
	public function getCenter(): Point
	{
		return new Point($this->size/2, $this->size/2);
	}

	/**
	 * <summary>
	 * Draw line between $a and $b
	 * </summary>
	 *
	 * <algo>
	 * Use imageline to draw a line on self between $a and $b, taking X & Y of $a as start destination
	 * and X & Y of $b as end destination
	 * </algo>
	 */
	public function drawLine(Point $a, Point $b, int $color = 16777215): Line
	{
		imageline(
			$this->image,
			$a->x,
			$a->y,
			$b->x,
			$b->y,
			$color
		);

		return new Line($a, $b);
	}

	/**
	 * <summary>
	 * return self as png
	 * </summary>
	 */
	public function render()
	{
		return imagepng($this->image);
	}
}
