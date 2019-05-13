<?php

namespace RebelWalls\PdfLibHelper\Templates;

abstract class PdfBaseTemplate extends PdfBaseBuilder
{
    protected $contentService;

    /**
     * PdfBaseTemplate constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->initialize();
    }

    protected abstract function generate();

    private function initialize()
    {
        $this->adapter->setOption('errorpolicy', 'exception');
        $this->adapter->setOption('stringformat', 'utf8');
        $this->adapter->setOption('SearchPath', '{{' . config('pdf.resource-path') . '}}');
        $this->adapter->setOption('errorpolicy', 'exception');
//        $this->pdf->set_option("stringformat=utf8");
//        $this->pdf->set_option("SearchPath=");
        if ($this->pdf->begin_document('', "") == 0) {
            die("Error: " . $this->pdf->get_errmsg());
        }

        $this->pdf->set_info("Creator", "PDFlib starter sample");
        $this->pdf->set_info("Title", "starter_basic");

        $this->beginPage();

        $this->text->initFonts($this->defaultFont, $this->additionalFonts, $this->defaultFontSize);
    }

    protected function beginPage()
    {
        $this->pdf->begin_page_ext(0,0, "width=a4.width height=a4.height topdown=true userunit=mm");
        $this->pdf->scale(2.83464567, 2.83464567);
    }

    protected function getOutput(string $fileName)
    {
        $this->pdf->end_page_ext("");
        $this->pdf->end_document("");

        $buffer = $this->pdf->get_buffer();
        $bufferLength = strlen($buffer);

        header("Content-type: application/pdf");
        header("Content-Length: $bufferLength");
        header("Content-Disposition: inline; filename=" . $fileName);

        return $buffer;
    }
}
