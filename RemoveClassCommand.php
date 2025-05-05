<?php

require_once 'CommandInterface.php';

class RemoveClassCommand implements CommandInterface
{
    private LightElementNode $element;
    private string $class;

    public function __construct(LightElementNode $element, string $class)
    {
        $this->element = $element;
        $this->class = $class;
    }

    public function execute(): void
    {
        $this->element->removeClass($this->class);
    }
}
