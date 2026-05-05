<?php

include_once 'Line.php';

class LineNode
{
	public ?LineNode $n = null;

	public function __construct(public Line $payload) {}
}
