<?php

namespace RebelWalls\PdfLibHelper\Helpers;

use RebelWalls\PdfLibHelper\PdfLibAdapter;

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
     * @var PdfLibAdapter
     */
    private $adapter;

    /**
     * PdfText constructor.
     *
     * @param PdfLibAdapter $adapter
     */
    public function __construct(PdfLibAdapter $adapter)
    {
        $this->adapter = $adapter;
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
                $this->loadedFonts[$font] = $this->adapter->loadFont($font, 'unicode', 'embedding');
                $this->loadedFonts[$font . '-B'] = $this->adapter->loadFont($font, 'unicode', 'embedding fontstyle=bold');
                $this->loadedFonts[$font . '-I'] = $this->adapter->loadFont($font, 'unicode', 'embedding  fontstyle=italic');
                $this->loadedFonts[$font . '-BI'] = $this->adapter->loadFont($font, 'unicode', 'embedding fontstyle=bolditalic');
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

        $this->adapter->setFont($this->defaultFontNo, $this->defaultFontSize);

//        dd($this->defaultFontSize);


        $this->adapter->setColor('stroke', $blackColor->colorSpace, $blackColor->c1, $blackColor->c2, $blackColor->c3, $blackColor->c4);
        $this->adapter->setColor('fill', $blackColor->colorSpace, $blackColor->c1, $blackColor->c2, $blackColor->c3, $blackColor->c4);

        return $this;
    }
}
