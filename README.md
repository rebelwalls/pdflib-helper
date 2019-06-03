# rebelwalls/pdflib-builder
Laravel package for building PDF files with PdfLib package.

A standalone laravel package for handling PDF-generation.

There are three subfolders in the folder structure:
- Assets
- Helpers
- Templates

**Assets**

These are "dumb" assets that know nothing about the rest of the PDF and they know nothing about how they are rendered. They are just containers of information pertaining that specific Asset. Each type of asset can have its own set of properties. Here is an example of making a text-cell asset. An object with raw properties are returned.

```
PdfCell::make('My sample text')
    ->font($myFont)
    ->caps()
    ->size(7)
    ->align('right')
    ->style('I')
```

The values given to each method are just stored in the PdfCell object.

Current list of possible Assets:
- PdfCell
- PdfGraphic
- PdfImage
- PdfKeyValue (might not refactored away and replaced with table)
- PdfLine
- PdfTable

**Helpers**

Helpers are used in the generation process. A helper can for instance be the PositionHelper. The position helper is in charge of moving the cursor to different locations. Here are some usage examples of the PdfPosition helper.
```
$this->pos->setX(50);
$this->pos->addX(20);
$this->pos->moveToFarLeft();
$this->pos->moveToFarRight();

$this->pos->setY(50);
$this->pos->addY(20);
$this->pos->moveToTop);
$this->pos->moveToBottom();
```
Another example of a helper is the PdfColor helper, keeping track of the current stroke and fill colors.

**Templates**

This is where the actual PDF files are generated and the structure for the files are created. Each template extends the PdfBaseTemplate from where it inherits its methods and base functionality.

Each template needs to have a generate() method. This is the main entry point for the PDF building.

*Note: These templates have a tendency to become quite large, therefore it is important to keep a good structure in this file.*
```
public function generate()
{
    $this->titleFont = 'Tungsten';

    $this->drawLogo();
    $this->drawTitle();
    $this->drawBody($this->invoice);
    $this->drawFooter();
}

private function drawLogo()
{
    $this->pos->moveToFarRight();
    $this->pos->moveToTop();

    $this->drawGraphic(
        PdfGraphic::make('RebelWallsLogo.svg')
            ->scale(.19)
            ->alignX('right')
    );
}
```
