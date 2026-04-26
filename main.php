<?php

// We know that all angles have to be 60 degrees.
// Given that information, we can use the angle of 60 degrees to get a radian value. (degrees * pi / 180)
// With this radian value we can get a sine and cosine.
// Then follow the steps:
//
// divide the line segment into three segments of equal length.
// draw an equilateral triangle that has the middle segment from step 1 as its base and points outward.
// remove the line segment that is the base of the triangle from step 2.
//
// [Unrelated notes for self]
// cosin(angle) = multiplier for $length on X
// sin(angle) = multiplier for $length on Y

error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING);

include_once 'Point.php';
include_once 'Image.php';

$image = new Image(800);
$length = 100;
$angle = deg2rad(60);

$bottomRightPoint = new Point($image->getCenter()->x + cos($angle) * $length*2, $image->getCenter()->y);
$roofPoint = new Point($image->getCenter()->x + cos($angle) * $length, $image->getCenter()->y - sin($angle) * $length);

$image->drawline($image->getCenter(), $roofPoint);
$image->drawline($image->getCenter(), $bottomRightPoint);
$image->drawline($roofPoint, $bottomRightPoint);

header("Content-Type: image/png");
return $image->render();
