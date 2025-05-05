<?php

require_once 'VisitorInterface.php';

class CountVisitor implements VisitorInterface
{
    private array $counts = [];

    public function visit(LightNode $node): void
    {
        if ($node instanceof LightElementNode) {
            $tag = $node->getTagName();
            if (!isset($this->counts[$tag])) {
                $this->counts[$tag] = 0;
            }
            $this->counts[$tag]++;
        }

        if ($node instanceof LightElementNode) {
            foreach ($node->getChildren() as $child) {
                $this->visit($child);
            }
        }
    }

    public function getResults(): array
    {
        return $this->counts;
    }
}
