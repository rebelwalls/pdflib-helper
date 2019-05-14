<?php

namespace RebelWalls\PdfLibHelper;

use Illuminate\Support\Facades\Storage;

abstract class PdfLibBaseTemplate extends PdfLibHelper
{
    public $documentCreator = 'Rebel Walls - PdfLib Helper';
    public $documentTitle = 'Document Title';

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
        $this->pdf->set_option('errorpolicy=exception');
        $this->pdf->set_option('stringformat=' . config('pdflib-helper.string-format'));
        $this->pdf->set_option('SearchPath={{' . config('pdflib-helper.resource-path') . '}}');

        if ($this->pdf->begin_document('', '') === 0) {
            die("Error: " . $this->pdf->get_errmsg());
        }

        $this->pdf->set_info("Creator", $this->documentCreator);
        $this->pdf->set_info("Title", $this->documentTitle);

        $this->beginPage();

        $this->text->initFonts($this->defaultFont, $this->additionalFonts, $this->defaultFontSize);
    }

    protected function beginPage()
    {
        $this->pageCount++;
        $this->pdf->begin_page_ext(0,0, 'width=a4.width height=a4.height topdown=true userunit=mm');
        $this->pdf->scale(2.83464567, 2.83464567);
    }

    protected function newPage()
    {
        $this->beginPage();
        $this->pos->moveToTop();
        $this->pos->moveToFarLeft();
    }

    /**
     * @param string $fileName
     */
    protected function writeOutput(string $fileName)
    {
        for ($pageNumber = 1; $pageNumber <= $this->pageCount; $pageNumber++) {
            $this->pdf->resume_page('pagenumber ' . $pageNumber);
            $this->pdf->end_page_ext("");
        }

        $this->pdf->end_document("");

        $buffer = $this->pdf->get_buffer();
        $bufferLength = strlen($buffer);

        header("Content-type: application/pdf");
        header("Content-Length: $bufferLength");
        header("Content-Disposition: inline; filename=" . $fileName);

        print $buffer;
    }

    /**
     * @param string $fileName
     */
    protected function writeFile(string $fileName, $path = null)
    {
        // @todo: Implement $path

        $this->pdf->end_page_ext("");
        $this->pdf->end_document("");

        $fileContent = $this->pdf->get_buffer();

        Storage::disk('local')->put($fileName, $fileContent);
    }
}
