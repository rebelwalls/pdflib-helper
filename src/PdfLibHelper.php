<?php

namespace RebelWalls\PdfLibHelper;

use PDFlib;
use RebelWalls\PdfLibHelper\Concerns\CanDrawCircle;
use RebelWalls\PdfLibHelper\Concerns\CanDrawPdfDocument;
use RebelWalls\PdfLibHelper\Concerns\CanDrawRectangle;
use RebelWalls\PdfLibHelper\Concerns\CanDrawTextFlow;
use RebelWalls\PdfLibHelper\Helpers\PdfColor;
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
 * @property int $pageCount
 * @property array $additionalFonts
 * @property string $defaultFont
 * @property float $defaultFontSize
 * @property string $documentCreator
 *
 * @property PdfPosition $pos
 * @property PdfText $text
 */
abstract class PdfLibHelper
{
    protected int $pageCount = 0;
    protected array $additionalFonts;
    protected string $defaultFont;
    protected float $defaultFontSize;
    protected string $documentCreator;
    protected array $fontList;
    protected PdfColor $color;
    protected PDFlib $pdf;
    protected PdfPosition $pos;
    protected PdfText $text;

    use CanDrawCell;
    use CanDrawCircle;
    use CanDrawGraphic;
    use CanDrawImage;
    use CanDrawKeyValueTable;
    use CanDrawLine;
    use CanDrawRectangle;
    use CanDrawTable;
    use CanDrawPdfDocument;
    use CanDrawTextFlow;

    /**
     * PdfBaseTemplate constructor.
     */
    public function __construct()
    {
        $this->pdf = new PdfLib();

        $this->pos = new PdfPosition();
        $this->text = new PdfText($this->pdf);
    }
}
