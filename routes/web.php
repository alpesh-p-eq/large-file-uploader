<?php

use AlpeshEquest\LargeFileUploader\LargeFileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('upload-chunks', function (Request $request, LargeFileUploader $largeFileUploader) {
    return $largeFileUploader->uploadChunk($request);
})->name('upload-chunks');

Route::post('merge-chunks', function (Request $request, LargeFileUploader $largeFileUploader) {
    return $largeFileUploader->mergeChunks($request);
})->name('merge-chunks');

Route::get('file-upload', function () {
    return view('large-file-uploader::file-upload');
})->name('file-upload');
