<?php

namespace AlpeshEquest\LargeFileUploader;

use Illuminate\Http\Request;

class LargeFileUploader {
    // Handle individual chunk uploads
    public function uploadChunk(Request $request)
    {
        $chunk = $request->file('chunk');
        $fileName = $request->input('file_name');
        $chunkNumber = $request->input('chunk_number');

        // Store each chunk in a temporary directory
        $tempDir = config('large-file-uploader.chunk_path');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $chunk->move($tempDir, "{$fileName}.part{$chunkNumber}");

        return response()->json(['status' => 'Chunk uploaded successfully']);
    }

    // Merge chunks into a single file
    public function mergeChunks(Request $request)
    {
        $fileName = $request->input('file_name');
        $totalChunks = $request->input('total_chunks');

        $tempDir = config('large-file-uploader.chunk_path');
        $finalPath = config('large-file-uploader.upload_path') . $fileName;

        if (!is_dir(config('large-file-uploader.upload_path'))) {
            mkdir(config('large-file-uploader.upload_path'), 0755, true);
        }

        $finalFile = fopen($finalPath, 'wb');

        for ($i = 1; $i <= $totalChunks; $i++) {
            $chunkPath = $tempDir . "{$fileName}.part{$i}";

            if (!file_exists($chunkPath)) {
                return response()->json(['error' => "Missing chunk {$i}"], 400);
            }

            fwrite($finalFile, file_get_contents($chunkPath));
            unlink($chunkPath); // Clean up chunk
        }

        fclose($finalFile);

        return response()->json(['status' => 'File merged successfully','file_path' => $finalPath]);
    }
}
