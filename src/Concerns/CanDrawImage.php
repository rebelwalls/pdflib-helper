<?php

namespace RebelWalls\PdfLibHelper\Concerns;

use RebelWalls\PdfLibHelper\Assets\PdfImage;

trait CanDrawImage
{

    /**
     * @param PdfImage $image
     */
    public function drawImage(PdfImage $image): void
    {
        $loadedImage = $this->pdf->load_image('auto', $image->file, '');

        if (!$image) {
            die("Error: " . $this->pdf->get_errmsg());
        }

        $this->pdf->fit_image($loadedImage, $this->pos->x, $this->pos->y, $this->resolveImageOptionsString($image));
        $this->pdf->close_image($loadedImage);
    }

    /**
     * @param PdfImage $image
     *
     * @return string
     */
    private function resolveImageOptionsString(PdfImage $image): string
    {
        return 'scale=' . $image->scale . ' position={' . $image->positionX . ' ' . $image->positionY . '}';
    }
}
