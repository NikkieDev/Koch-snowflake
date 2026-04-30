<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING);

include_once 'Image.php';
include_once 'Point.php';
include_once 'Line.php';
include_once 'Triangle.php';

header('Content-Type: image/png');

$iterations = isset($_GET['iterations']) ? (int) $_GET['iterations'] : 2;

$imageSize = 1200;

$baseEdges = $drawLines = [];
$baseAngle = deg2rad(60);

$image = new Image($imageSize);

$vertexA = new Point(rand(0, $imageSize - 400), rand(0, $imageSize - 400));
$vertexB = new Point(rand(0, $imageSize - 400), rand(0, $imageSize - 400));
$edgeAB = new Line($vertexA, $vertexB);

if ($iterations < 1) {
	$image->drawLine($vertexA, $vertexB);
	return $image->render();
}

$vertexC = new Point(
	$vertexA->x + cos($edgeAB->getAngle() + $baseAngle) * $edgeAB->getDistance(),
	$vertexA->y + sin($edgeAB->getAngle() + $baseAngle) * $edgeAB->getDistance()
);

$firstIteration = new Triangle($vertexA, $vertexB, $vertexC);

if ($iterations < 2) {
	foreach ($firstIteration->getEdges() as $edge) {
		$image->drawLine($edge->a, $edge->b);
	}

	return $image->render();
}

$iterationEdges = $firstIteration->getEdges();

for ($i = 2; $i <= $iterations; $i++) {
	$nextIteration = [];

	foreach ($iterationEdges as $edge) {
		$vertexD = new Point(
			$edge->a->x + cos($edge->getAngle()) * $edge->getDistance()/3,
			$edge->a->y + sin($edge->getAngle()) * $edge->getDistance()/3
		);

		$vertexE = new Point(
			$edge->a->x + cos($edge->getAngle()) * $edge->getDistance()/3*2,
			$edge->a->y + sin($edge->getAngle()) * $edge->getDistance()/3*2
		);

		$edgeDE = new Line($vertexD, $vertexE);

		$cross = ($edge->b->x - $edge->a->x) * ($firstIteration->getCenterY() - $edge->a->y)
			   - ($edge->b->y - $edge->a->y) * ($firstIteration->getCenterX() - $edge->a->x);

		$angle = $cross > 0
			? $edgeDE->getAngle() - $baseAngle
			: $edgeDE->getAngle() + $baseAngle;

		$vertexF = new Point(
			$vertexD->x + cos($angle) * $edgeDE->getDistance(),
			$vertexD->y + sin($angle) * $edgeDE->getDistance(),
		);

		$nextIteration[] = new Line($edge->a, $vertexD);
		$nextIteration[] = new Line($vertexD, $vertexF);
		$nextIteration[] = new Line($vertexE, $vertexF);
		$nextIteration[] = new Line($vertexE, $edge->b);
	}

	$iterationEdges = $nextIteration;
	if ($i === $iterations) {
		$drawLines = $iterationEdges;
	}
}

foreach ($drawLines as $line) {
	$image->drawLine($line->a, $line->b);
}

$image->render();
