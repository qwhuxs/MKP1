<?php
abstract class DocumentGenerator
{
    public function generateDocument(): void
    {
        $this->openDocument();
        $this->addHeader();
        $this->addContent();
        $this->closeDocument();
    }

    abstract protected function openDocument(): void;
    abstract protected function addHeader(): void;
    abstract protected function addContent(): void;
    abstract protected function closeDocument(): void;
}
?>
