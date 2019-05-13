<?php

namespace RebelWalls\PdfLibHelper\Helpers;

use PDFlib;

class PdfText
{
    public $defaultFont;
    public $defaultFontSize;
    public $defaultFontNo;

    private $currentFont;
    private $currentFontSize;
    private $currentFontNo;

    public $loadedFonts;

    /**
     * @var PdfLib
     */
    private $pdf;

    /**
     * PdfText constructor.
     *
     * @param PdfLib $pdf
     */
    public function __construct(PdfLib $pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * @param string $defaultFont
     * @param array $fonts
     */
    public function initFonts(string $defaultFont, array $fonts, $defaultFontSize)
    {
        collect($fonts)
            ->prepend($defaultFont)
            ->each(function ($font) {
                $this->loadedFonts[$font] = $this->pdf->load_font($font, 'unicode', 'embedding');
                $this->loadedFonts[$font . '-B'] = $this->pdf->load_font($font, 'unicode', 'embedding fontstyle=bold');
                $this->loadedFonts[$font . '-I'] = $this->pdf->load_font($font, 'unicode', 'embedding  fontstyle=italic');
                $this->loadedFonts[$font . '-BI'] = $this->pdf->load_font($font, 'unicode', 'embedding fontstyle=bolditalic');
            });

        $this->defaultFont = $defaultFont;
        $this->defaultFontNo = $this->loadedFonts[$defaultFont];
        $this->defaultFontSize = $defaultFontSize ?? config('pdf.default-font-size');

        $this->currentFont = $this->defaultFont;
        $this->currentFontNo = $this->defaultFontNo;
        $this->currentFontSize = $this->defaultFontSize;
    }

    /**
     * @return $this
     */
    public function reset()
    {
        $blackColor = new PdfColor();

        $this->pdf->setfont($this->defaultFontNo, $this->defaultFontSize);

//        dd($this->defaultFontSize);


        $this->pdf->setcolor('stroke', $blackColor->colorSpace, $blackColor->c1, $blackColor->c2, $blackColor->c3, $blackColor->c4);
        $this->pdf->setcolor('fill', $blackColor->colorSpace, $blackColor->c1, $blackColor->c2, $blackColor->c3, $blackColor->c4);

        return $this;
    }
}
