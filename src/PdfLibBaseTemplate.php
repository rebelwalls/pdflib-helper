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
        if (config('pdflib-helper.license-key')) {
            $this->pdf->set_option('license=' . config('pdflib-helper.license-key'));
        }

        $this->pdf->set_option('errorpolicy=exception');
        $this->pdf->set_option('stringformat=' . config('pdflib-helper.string-format'));
        $this->pdf->set_option('SearchPath={{' . config('pdflib-helper.resource-path') . '}}');

        if ($this->pdf->begin_document('', '') === 0) {
            die("Error: " . $this->pdf->get_errmsg());
        }

        $this->pdf->set_info("Creator", $this->documentCreator);
        $this->pdf->set_info("Title", $this->documentTitle);

        if (isset($this->defaultLineHeight)) {
            $this->pos->setDefaultLineHeight($this->defaultLineHeight);
        }

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

    public function endDocument()
    {
        for ($pageNumber = 1; $pageNumber <= $this->pageCount; $pageNumber++) {
            $this->pdf->resume_page('pagenumber ' . $pageNumber);
            $this->pdf->end_page_ext("");
        }

        $this->pdf->end_document("");

        return $this;
    }

    /**
     * Returns the file content string
     *
     * @return string
     */
    public function getFileContent()
    {
        return $this->pdf->get_buffer();
    }

    /**
     * Outputs the file to the browser, including headers
     *
     * @param string $fileName
     */
    public function writeOutput(string $fileName)
    {
        $buffer = $this->pdf->get_buffer();
        $bufferLength = strlen($buffer);

        header("Content-type: application/pdf");
        header("Content-Length: $bufferLength");
        header("Content-Disposition: inline; filename=" . $fileName);

        print $buffer;
    }

    /**
     * Writes the file to a specific filename in the public storage
     *
     * @param string $fileName
     */
    public function writeFile(string $fileName, $path = null)
    {
        // @todo: Implement $path

        $fileContent = $this->pdf->get_buffer();

        Storage::disk('public')->put($fileName, $fileContent);
    }
}
