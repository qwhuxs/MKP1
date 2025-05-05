<?php

require_once 'CommandInterface.php';

class SetAttributeCommand implements CommandInterface
{
    private LightElementNode $element;
    private string $name;
    private string $value;

    public function __construct(LightElementNode $element, string $name, string $value)
    {
        $this->element = $element;
        $this->name = $name;
        $this->value = $value;
    }

    public function execute(): void
    {
        $this->element->setAttribute($this->name, $this->value);
    }
}
