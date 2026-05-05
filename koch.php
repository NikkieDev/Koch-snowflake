<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING);

include_once 'Image.php';
include_once 'Point.php';
include_once 'Line.php';
include_once 'LineList.php';
include_once 'LineNode.php';
include_once 'Triangle.php';

header('Content-Type: image/png');

$iterations = isset($_GET['iterations']) ? (int) $_GET['iterations'] : 2;

$imageSize = 3200;
$image = new Image($imageSize);

$vertexA = new Point(750, 750);
$vertexB = new Point(1800, 2000);
$edgeAB = new Line($vertexA, $vertexB);

if ($iterations < 1) {
	$image->drawLine($vertexA, $vertexB);
	return $image->render();
}

$vertexC = $vertexA->turn($edgeAB->getAngle() + deg2rad(60), $edgeAB->getDistance());

$lineList = new LineList(new LineNode($edgeAB));
$lineList->add(new LineNode(new Line($vertexB, $vertexC)));
$lineList->add(new LineNode(new Line($vertexC, $vertexA)));


for ($i = 2; $i <= $iterations; $i++) {
	$lineList->addChildren();
}

/** @var Line $line */
foreach ($lineList->readAll() as $line) {
	$image->drawLine($line->a, $line->b);
};

return $image->render();
