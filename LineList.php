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

	public function addChildren(): void
	{
		$current = $this->head;
		$prev = null;

		while ($current !== null) {
			$next = $current->n;
			$edge = $current->payload;

			$d = $edge->a->turn($edge->getAngle(), $edge->getDistance()/3);
			$e = $edge->a->turn($edge->getAngle(), $edge->getDistance()/3*2);

			$edgeDE = new Line($d, $e);

			$f = $d->turn($edgeDE->getAngle() - deg2rad(60), $edgeDE->getDistance());
;
			$n1 = new LineNode(new Line($edge->a, $d));
			$n2 = new LineNode(new Line($d, $f));
			$n3 = new LineNode(new Line($f, $e));
			$n4 = new LineNode(new Line($e, $edge->b));

			$n1->n = $n2;
			$n2->n = $n3;
			$n3->n = $n4;
			$n4->n = $next;

			if ($prev === null) {
				$this->head = $n1;
			} else {
				$prev->n = $n1;
			}

			$prev = $n4;
			$current = $next;
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
