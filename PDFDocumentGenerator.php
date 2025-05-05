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

    public function saveDocument(): void
    {
        $filePath = 'generated_documents/output.pdf';

        $pdfContent = '%PDF-1.4
        1 0 obj
        <</Type /Catalog /Pages 2 0 R>>
        endobj
        2 0 obj
        <</Type /Pages /Count 1 /Kids [3 0 R]>>
        endobj
        3 0 obj
        <</Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R>>
        endobj
        4 0 obj
        <</Length 44>>
        stream
        BT
        /F1 24 Tf
        100 700 Td
        (Generated PDF Document) Tj
        ET
        endstream
        endobj
        xref
        0 5
        0000000000 65535 f
        0000000010 00000 n
        0000000081 00000 n
        0000000132 00000 n
        0000000193 00000 n
        trailer
        <</Size 5 /Root 1 0 R>>
        startxref
        290
        %%EOF';

        file_put_contents($filePath, $pdfContent);

        echo "PDF document saved to {$filePath}\n";
    }
}
