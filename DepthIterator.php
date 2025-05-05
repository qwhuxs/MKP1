<?php

class DepthIterator implements Iterator
{
    private array $stack;
    private ?LightNode $currentNode = null;

    public function __construct(LightNode $rootNode)
    {
        $this->stack = [$rootNode];
    }

    #[\ReturnTypeWillChange]
    public function current(): mixed
    {
        return $this->currentNode;
    }

    #[\ReturnTypeWillChange]
    public function key(): mixed
    {
        return null;
    }

    #[\ReturnTypeWillChange]
    public function next(): void
    {
        $this->currentNode = array_pop($this->stack);

        if ($this->currentNode instanceof LightElementNode) {
            foreach (array_reverse($this->currentNode->getChildren()) as $child) {
                $this->stack[] = $child;
            }
        }
    }

    #[\ReturnTypeWillChange]
    public function rewind(): void
    {
        $this->currentNode = array_pop($this->stack);
    }

    #[\ReturnTypeWillChange]
    public function valid(): bool
    {
        return !empty($this->stack);
    }
}
