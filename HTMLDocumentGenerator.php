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

    public function saveDocument(): void
    {
        $filePath = 'generated_documents/output.html';

        $htmlContent = '<h1>Generated HTML Document</h1>';

        file_put_contents($filePath, $htmlContent);
        
        echo "HTML document saved to {$filePath}\n";
    }
}
?>
