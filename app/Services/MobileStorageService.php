<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class MobileStorageService
{
    private const PDF_DIR = 'mobile_pdfs';

    /**
     * Save a PDF binary string to local storage.
     * Returns the absolute file path.
     */
    public function savePdf(string $pdfContent, string $filename): string
    {
        $relativePath = self::PDF_DIR . '/' . $filename;

        Storage::disk('local')->put($relativePath, $pdfContent);

        return storage_path('app/' . $relativePath);
    }

    /**
     * Check if a PDF file already exists (to avoid regenerating).
     */
    public function exists(string $filename): bool
    {
        return Storage::disk('local')->exists(self::PDF_DIR . '/' . $filename);
    }

    /**
     * Get the absolute path to a stored PDF (returns null if missing).
     */
    public function getPath(string $filename): ?string
    {
        $rel = self::PDF_DIR . '/' . $filename;

        if (Storage::disk('local')->exists($rel)) {
            return storage_path('app/' . $rel);
        }

        return null;
    }

    /**
     * Delete a specific PDF by filename.
     */
    public function delete(string $filename): void
    {
        Storage::disk('local')->delete(self::PDF_DIR . '/' . $filename);
    }

    /**
     * Delete all PDFs older than the given number of hours.
     * Call this from a scheduled command to keep storage clean.
     *
     * @return int Number of files deleted
     */
    public function cleanOlderThan(int $hours = 24): int
    {
        $files   = Storage::disk('local')->files(self::PDF_DIR);
        $cutoff  = now()->subHours($hours)->timestamp;
        $deleted = 0;

        foreach ($files as $file) {
            if (Storage::disk('local')->lastModified($file) < $cutoff) {
                Storage::disk('local')->delete($file);
                $deleted++;
            }
        }

        return $deleted;
    }
}
