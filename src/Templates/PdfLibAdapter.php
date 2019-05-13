<?php

namespace Pdf;

use Illuminate\Contracts\Support\Arrayable;
use PDFlib;
use PDFlibException;

class PdfLibAdapter
{
    const SCOPE_OBJECT = 'object';
    const SCOPE_DOCUMENT = 'document';
    const SCOPE_GLYPH = 'glyph';
    const SCOPE_FONT = 'font';
    const SCOPE_PATTERN = 'pattern';
    const SCOPE_TEMPLATE = 'template';
    const SCOPE_PAGE = 'page';
    const SCOPE_PATH = 'path';

    /**
     * The PDFlib instance.
     *
     * @var PDFlib
     */
    protected $lib;

    /**
     * The default options.
     *
     * @var array
     */
    protected static $defaults = [
        'errorPolicy' => 'exception',
        'stringFormat' => 'utf8',
    ];

    /**
     * Create a new adapter instance.
     *
     * @param PDFlib|null $lib
     */
    public function __construct(PDFlib $lib = null)
    {
        $this->lib = $lib ?: new PDFlib;

        $this->applyDefaults();
    }

    /**
     * Set the specified default option.
     *
     * @param string $key
     * @param mixed $value
     */
    public static function setDefault($key, $value)
    {
        static::$defaults[$key] = $value;
    }

    /**
     * Apply default options.
     */
    protected function applyDefaults()
    {
        foreach (static::$defaults as $key => $value) {
            $this->setOption($key, $value);
        }
    }

    /**
     * Wrapper for PDFlib::set_option.
     *
     * @param string $key
     * @param mixed $value
     */
    public function setOption($key, $value = true)
    {
        $this->lib->set_option($key . '=' . $this->formatOptionListValue($value));
    }

    /**
     * Wrapper for PDFlib::get_option.
     *
     * @param string $key
     * @param array $options
     * @return mixed
     */
    public function getOption($key, $options = [])
    {
        return $this->lib->get_option($key, $this->createOptionList($options));
    }

    /**
     * Wrapper for PDFlib::get_string.
     *
     * @param int $index
     * @param array $options
     * @return string
     */
    public function getString($index, $options = [])
    {
        return $this->lib->get_string($index, $this->createOptionList($options));
    }

    /**
     * Determine if an option exists.
     *
     * @param string $key
     * @return bool
     * @throws PDFlibException
     */
    public function optionExists($key)
    {
        try {
            $this->getOption($key);
        } catch (PDFlibException $e) {
            if ($e->getCode() === 1202) {
                return false;
            }

            throw $e;
        }

        return true;
    }

    /**
     * Gets the current scope.
     *
     * @return string
     */
    public function getScope()
    {
        return $this->getString($this->getOption('scope'));
    }

    /**
     * Determine if the specified scope matches the current scope.
     *
     * @param string $scope
     * @return bool
     */
    public function isScope($scope)
    {
        return $scope == $this->getScope();
    }

    /**
     * Wrapper for PDFlib::scale.
     *
     * @param float $scaleX
     * @param float $scaleY
     */
    public function scale($scaleX, $scaleY)
    {
        $this->lib->scale($scaleX, $scaleY);
    }

    /**
     * Wrapper for PDFlib::begin_document.
     *
     * @param string $filename
     * @param array $options
     */
    public function beginDocument($filename = null, $options = [])
    {
        $this->lib->begin_document($filename, $this->createOptionList($options));
    }

    /**
     * Wrapper for PDFlib::end_document.
     *
     * @param array $options
     */
    public function endDocument($options = [])
    {
        $this->lib->end_document($this->createOptionList($options));
    }

    /**
     * Wrapper for PDFlib::begin_page_ext.
     *
     * @param int $width
     * @param int $height
     * @param array $options
     */
    public function beginPage($width = 0, $height = 0, $options = [])
    {
        $this->lib->begin_page_ext($width, $height, $this->createOptionList($options));
    }

    /**
     * Wrapper for PDFlib::suspend_page.
     *
     * @param array $options
     */
    public function endPage($options = [])
    {
        $this->lib->end_page_ext($this->createOptionList($options));
    }

    /**
     * Wrapper for PDFlib::resume_page.
     *
     * @param array $options
     */
    public function suspendPage($options = [])
    {
        $this->lib->suspend_page($this->createOptionList($options));
    }

    /**
     * Wrapper for PDFlib::end_page_ext.
     *
     * @param array $options
     */
    public function resumePage($options = [])
    {
        $this->lib->resume_page($this->createOptionList($options));
    }


    /**
     * Format values for PDFlib option list.
     *
     * @param $value
     *
     * @return string
     */
    protected function formatOptionListValue($value)
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if ($value instanceof Arrayable) {
            $value = $value->toArray();
        }

        if (is_array($value)) {
            return '{' . $this->createOptionList($value) . '}';
        }

        if (preg_match('/\s|=/', $value)) {
            return '{' . $value . '}';
        }

        return $value;
    }

    /**
     * Convert an array to a PDFlib option list.
     *
     * @param array $options
     * @param array $defaults
     *
     * @return string
     */
    protected function createOptionList(array $options, array $defaults = [])
    {
        $options = array_merge($defaults, $options);
        foreach ($options as $key => &$value) {
            if (is_int($key)) {
                $value = $this->formatOptionListValue($value);
            } else {
                $value = $key . '=' . $this->formatOptionListValue($value);
            }
        }
        return implode(' ', $options);
    }

    /**
     * Fetch PDF document data from memory.
     *
     * @return string
     */
    public function getBuffer()
    {
        return $this->lib->get_buffer();
    }
}
