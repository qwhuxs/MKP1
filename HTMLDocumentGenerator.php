<?php

class HTMLDocumentGenerator extends DocumentGenerator
{
    protected function openDocument(): void
    {
        echo "Opening HTML document...\n";
    }

    protected function addHeader(): void
    {
        echo "Adding header to HTML...\n";
    }

    protected function addContent(): void
    {
        echo "Adding content to HTML...\n";
    }

    protected function closeDocument(): void
    {
        echo "Closing HTML document...\n";
    }
}
?>
