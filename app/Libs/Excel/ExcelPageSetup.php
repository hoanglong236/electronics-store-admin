<?php

namespace App\Libs\Excel;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter;
use PhpOffice\PhpSpreadsheet\Worksheet\PageMargins;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class ExcelPageSetup
{
    private $pageSetup;
    private $pageMargins;
    private $headerFooter;
    private $printGridLines;

    public function __construct()
    {
        $this->pageSetup = new PageSetup();
        $this->pageMargins = new PageMargins();
        $this->headerFooter = new HeaderFooter();
    }

    /**
     * Set orientation at the page setup
     *
     * @param string $orientation See ExcelPageSetupConstants::ORIENTATION_*
     *
     * @return $this
     */
    public function setOrientation(string $orientation)
    {
        $this->pageSetup->setOrientation($orientation);
        return $this;
    }

    /**
     * Set print scaling. Valid values range from 10 to 400
     * This setting is overridden when setFitToPage are in use.
     *
     * @param int $scale
     *
     * @return $this
     */
    public function setPrintScale(int $scale)
    {
        $this->pageSetup->setScale($scale);
        return $this;
    }

    /**
     * Set fit to page.
     * This setting is overridden when setScale are in use.
     *
     * @param int $pageWide
     * @param int $pageTall
     *
     * @return $this
     */
    public function setFitToPage(int $pageWide, int $pageTall)
    {
        $this->pageSetup->setFitToWidth($pageWide);
        $this->pageSetup->setFitToHeight($pageTall);
        return $this;
    }

    /**
     * Set paper size at the page setup
     *
     * @param string $paperSize See ExcelPageSetupConstants::PAPER_SIZE_*
     *
     * @return $this
     */
    public function setPaperSize($paperSize)
    {
        $this->pageSetup->setPaperSize($paperSize);
        return $this;
    }

    public function setLeftMargin(float $leftMargin)
    {
        $this->pageMargins->setLeft($leftMargin);
        return $this;
    }

    public function setRightMargin(float $rightMargin)
    {
        $this->pageMargins->setRight($rightMargin);
        return $this;
    }

    public function setTopMargin(float $topMargin)
    {
        $this->pageMargins->setTop($topMargin);
        return $this;
    }

    public function setBottomMargin(float $bottomMargin)
    {
        $this->pageMargins->setBottom($bottomMargin);
        return $this;
    }

    public function setHeaderMargin(float $headerMargin)
    {
        $this->pageMargins->setHeader($headerMargin);
        return $this;
    }

    public function setFooterMargin(float $footerMargin)
    {
        $this->pageMargins->setFooter($footerMargin);
        return $this;
    }

    public function setHorizontalCentered(bool $bool = true)
    {
        $this->pageSetup->setHorizontalCentered($bool);
        return $this;
    }

    public function setVerticalCentered(bool $bool = true)
    {
        $this->pageSetup->setVerticalCentered($bool);
        return $this;
    }

    public function setHeader(string $header)
    {
        $this->headerFooter->setOddHeader($header);
        return $this;
    }

    public function setFooter(string $footer)
    {
        $this->headerFooter->setOddFooter($footer);
        return $this;
    }

    public function setScaleWithDocument(bool $bool = true)
    {
        $this->headerFooter->setScaleWithDocument($bool);
        return $this;
    }

    public function setAlignWithPageMargins(bool $bool = true)
    {
        $this->headerFooter->setAlignWithMargins($bool);
        return $this;
    }

    public function setRepeatRows($rowStart, $rowEnd)
    {
        $this->pageSetup->setRowsToRepeatAtTopByStartAndEnd($rowStart, $rowEnd);
        return $this;
    }

    public function setRepeatColumns($colStart, $colEnd)
    {
        $colStartString = Coordinate::stringFromColumnIndex($colStart);
        $colEndString = Coordinate::stringFromColumnIndex($colEnd);

        $this->pageSetup->setColumnsToRepeatAtLeftByStartAndEnd($colStartString, $colEndString);
        return $this;
    }

    public function setPrintGridLines(bool $bool = true)
    {
        $this->printGridLines = $bool;
        return $this;
    }

    /**
     * Set the print page order.
     *
     * @param string $pageOrder See ExcelPageSetupConstants::PAGE_ORDER_*
     */
    public function setPageOrder(string $pageOrder)
    {
        $this->pageSetup->setPageOrder($pageOrder);
        return $this;
    }

    public function getPageSetup()
    {
        return $this->pageSetup;
    }

    public function getPageMargins()
    {
        return $this->pageMargins;
    }

    public function getHeaderFooter()
    {
        return $this->headerFooter;
    }

    public function getPrintGridLines()
    {
        return $this->printGridLines;
    }
}
