<?php

interface VisitorInterface
{
    public function visit(LightNode $node): void;
}
