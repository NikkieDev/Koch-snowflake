<?php

include_once 'Line.php';

class LineNode
{
	public ?LineNode $n = null;
	public bool $hasChildren = false;

	public function __construct(public Line $payload) {}
}
