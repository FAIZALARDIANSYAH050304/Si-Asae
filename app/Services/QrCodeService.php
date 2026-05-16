<?php

namespace App\Services;

use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;

class QrCodeService
{
    /**
     * Generate QR code as SVG string
     */
    public function generate(string $data, int $size = 200): string
    {
        $qrCode = new QrCode(
            data: $data,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Medium,
            size: $size,
            margin: 10
        );

$svgWriter = new SvgWriter();
        return $svgWriter->write($qrCode)->getString();
    }

    /**
     * Generate QR code as HTML img tag with base64 PNG
     */
    public function generateHtml(string $data, int $size = 200): string
    {
        $dataUri = $this->generatePng($data, $size);
        return '<img src="' . $dataUri . '" alt="QR Code" />';
    }

    /**
     * Generate QR code as PNG data URI
     */
    public function generatePng(string $data, int $size = 200): string
    {
        $qrCode = new QrCode(
            data: $data,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Medium,
            size: $size,
            margin: 10
        );

$pngWriter = new PngWriter();
        $pngData = $pngWriter->write($qrCode)->getString();
        return 'data:image/png;base64,' . base64_encode($pngData);
    }
}
