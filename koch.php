<?php

// [INITIAL PLAN]
// 1. Create 2 random points
// 2. Make an equilateral triangle.
// [Recursive]
// [For every line between vertexes]
// 3. Create 2 vertexes or 3 equal parts
// 4. Create an equilateral triangle
// 5. remove line between 2 vertexes.
// [Endloop]
// [EndRecursion]
//
// [OPTIMIZED PLAN]
// 1. Create 2 random vertices
// 2. Calculate a third vertex with equilateral distance 
// 3. Calculate distances between all lines and instantiate the Line classes
// [For every existing Line class]
// 5. Calculate the locations of the next 2 vertices
// 6. Calculate a third vertex with equilateral distance
// 7. Draw out all the collected lines, which is:
// A -> First vertex, First vertex -> Third vertex (tip), Third vertex (tip) -> Second vertex, Second vertex -> B.

error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING);

include_once 'Image.php';
include_once 'Point.php';
include_once 'Line.php';
include_once 'Triangle.php';

$size = 1200;
$maxRenderLocation = $size/1.5;
$baseAngle = deg2rad(60);
$baseEdges = [];
$renderLines = [];

$image = new Image($size);

// For random calculation, keep in mind offset to center may not be larger than X amount of pixels
$vertexA = new Point(rand(0, $maxRenderLocation), rand(0, $maxRenderLocation));
$vertexB = new Point(rand(0, $maxRenderLocation), rand(0, $maxRenderLocation));
$baseEdges[] = $edgeAB = new Line($vertexA, $vertexB);

$distance = $edgeAB->getDistance();
$angle = $edgeAB->getAngle() + $baseAngle;

$vertexC = new Point(
	$vertexA->x + cos($angle)*$distance,
	$vertexA->y + sin($angle)*$distance,
);

$baseTriangle = new Triangle($vertexA, $vertexB, $vertexC);

$baseEdges[] = $edgeAC = new Line($vertexA, $vertexC);
$baseEdges[] = $edgeBC = new Line($vertexB, $vertexC);

/** @var Line $edge */
foreach ($baseEdges as $edge) {
	$vertexD = new Point(
		$edge->a->x + cos($edge->getAngle())*$edge->getDistance()/3,
		$edge->a->y + sin($edge->getAngle())*$edge->getDistance()/3
	);

	$vertexE = new Point(
		$edge->a->x + cos($edge->getAngle())*$edge->getDistance()/3*2,
		$edge->a->y + sin($edge->getAngle())*$edge->getDistance()/3*2,
	);

	$edgeDE = new Line($vertexD, $vertexE);

	$vertexFPositive = new Point(
		$vertexD->x + cos($edgeDE->getAngle() + $baseAngle)*$edgeDE->getDistance(),
		$vertexD->y + sin($edgeDE->getAngle() + $baseAngle)*$edgeDE->getDistance()
	);

	$vertexFNegative = new Point(
		$vertexD->x + cos($edgeDE->getAngle() - $baseAngle)*$edgeDE->getDistance(),
		$vertexD->y + sin($edgeDE->getAngle() - $baseAngle)*$edgeDE->getDistance()
	);

	$distanceFromCenterPositive = sqrt(
		pow($vertexFPositive->x - $baseTriangle->getCenterX(), 2)
		+ pow($vertexFPositive->y - $baseTriangle->getCenterY(), 2)
	);

	$distanceFromCenterNegative = sqrt(
		pow($vertexFNegative->x - $baseTriangle->getCenterX(), 2)
		+ pow($vertexFNegative->y - $baseTriangle->getCenterY(), 2)
	);

	$vertexF = $distanceFromCenterPositive > $distanceFromCenterNegative ? $vertexFPositive : $vertexFNegative;

	$renderLines[] = new Line($edge->a, $vertexD);
	$renderLines[] = new Line($vertexD, $vertexF);
	$renderLines[] = new Line($vertexE, $vertexF);
	$renderLines[] = new Line($vertexE, $edge->b);

	$image->drawLine($edge->a, $edge->b, $image->special);
}

foreach ($renderLines as $line) {
	$image->drawLine($line->a, $line->b);
}

header('Content-Type: image/png');
$image->render();
