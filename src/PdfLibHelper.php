<?php

namespace RebelWalls\PdfLibHelper;

use PDFlib;
use RebelWalls\PdfLibHelper\Helpers\PdfPosition;
use RebelWalls\PdfLibHelper\Concerns\CanDrawCell;
use RebelWalls\PdfLibHelper\Concerns\CanDrawGraphic;
use RebelWalls\PdfLibHelper\Concerns\CanDrawImage;
use RebelWalls\PdfLibHelper\Concerns\CanDrawKeyValueTable;
use RebelWalls\PdfLibHelper\Concerns\CanDrawLine;
use RebelWalls\PdfLibHelper\Concerns\CanDrawTable;
use RebelWalls\PdfLibHelper\Helpers\PdfText;

/**
 * @property PdfLib pdf
 */
abstract class PdfLibHelper
{
    protected $additionalFonts;
    protected $color;
    protected $defaultFont;
    protected $defaultFontSize;
    protected $documentCreator;
    protected $fontList;
    protected $pdf;
    protected $pos;
    protected $text;

    use CanDrawCell;
    use CanDrawGraphic;
    use CanDrawImage;
    use CanDrawKeyValueTable;
    use CanDrawLine;
    use CanDrawTable;

    /**
     * PdfBaseTemplate constructor.
     *
     * @param array $options
     */
    public function __construct()
    {
        $this->pdf = new PdfLib();

        $this->pos = new PdfPosition();
        $this->text = new PdfText($this->pdf);
    }
}
