<?php

class PDFDocumentGenerator extends DocumentGenerator
{
    protected function openDocument(): void
    {
        echo "Opening PDF document...\n";
    }

    protected function addHeader(): void
    {
        echo "Adding header to PDF...\n";
    }

    protected function addContent(): void
    {
        echo "Adding content to PDF...\n";
    }

    protected function closeDocument(): void
    {
        echo "Closing PDF document...\n";
    }
}
?>
