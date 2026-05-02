<?php

include_once 'LineNode.php';

class LineList 
{
	public function __construct(public LineNode $head) {}

	public function add(LineNode $ln): void
	{
		$current = $this->head;

		while ($current->n !== null) {
			$current = $current->n;
		}

		$current->n = $ln;
	}

	/** DOESNT WORK YET **/
	public function addChildren(): void
	{
		$current = $this->head;

		while ($current !== null) {
			$next = $current->n;
			if (!$current->hasChildren) {
				$a = $current->payload->a;
				$b = $current->payload->b;
				$edge = $current->payload;

				$vertexD = new Point(
					$a->x + cos($edge->getAngle()) * $edge->getDistance()/3,
					$a->y + sin($edge->getAngle()) * $edge->getDistance()/3
				);

				$vertexE = new Point(
					$a->x + cos($edge->getAngle()) * $edge->getDistance()/3*2,
					$a->y + sin($edge->getAngle()) * $edge->getDistance()/3*2
				);

				$vertexF = $vertexD->turn(0, $edge->getDistance()/3);

				$node = new LineNode(new Line($vertexD, $vertexF));
				$node2 = new LineNode(new Line($vertexF, $vertexE));

				$node->n = $node2;
				$node2->n = $next;
				$current->n = $node;
				$current->hasChildren = true;

				$current = $next;
			}
		}
	}

	public function readAll(): array
	{
		$current = $this->head;
		$lines = [];

		while ($current !== null) {
			$lines[] = $current->payload;
			$current = $current->n;
		}

		return $lines;
	}
}
