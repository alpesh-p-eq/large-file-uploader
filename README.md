# This is my package large-file-uploader

[![Latest Version on Packagist](https://img.shields.io/packagist/v/alpeshequest/large-file-uploader.svg?style=flat-square)](https://packagist.org/packages/alpeshequest/large-file-uploader)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/alpeshequest/large-file-uploader/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/alpeshequest/large-file-uploader/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/alpeshequest/large-file-uploader/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/alpeshequest/large-file-uploader/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/alpeshequest/large-file-uploader.svg?style=flat-square)](https://packagist.org/packages/alpeshequest/large-file-uploader)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.


You can install the package via composer:

```bash
composer require alpeshequest/large-file-uploader
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="large-file-uploader-config"
```

This is the contents of the published config file:

```php
return [
    'chunk_path' => storage_path('app/chunks/'),
    'upload_path' => storage_path('app/uploads/'),
];
```

You must publish the components using

```bash
php artisan vendor:publish --tag="large-file-uploader-components"
```

You must publish the assets using

```bash
php artisan vendor:publish --tag="large-file-uploader-components"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="large-file-uploader-views"
```

## Usage

### Component Usage

```Blade
        <x-chunk-file-upload-input :suffix="'1'" :containerClass="'extra-class'" />
```
### Javascript 
```Js

<script src="{{assets('vendor/large-file-uploader/js/chunkUploader.js')}}"></script>
<script>
    const chunkUploader = new ChunkUploader({
        form: document.getElementById('uploadForm'),
        fileInput: document.getElementById('dropzone-file-1'),
        uploadUrl: '{{route('upload-chunks')}}',
        mergeUrl: '{{route('merge-chunks')}}',
        chunkSize: 1024 * 1024,
        parallelUploads: 3,
        retries: 3,
        retryTimeout: 1000,
        onProgress: (progress) => {
            document.getElementById('progress-1').innerText = `Upload Processing ${progress}%`;
            document.getElementById('progress-1').style.width = `${progress}%`;
        },
        onSuccess: (response) => {
            document.getElementById('progress-1').innerText = 'Upload Complete';
        },
        onError: (error) => {
            console.error(error);
        }
    });

    document.getElementById('uploadForm').addEventListener('submit', (e) => {
        e.preventDefault();
        chunkUploader.upload();
    });
</script>
   
```

### Laravel basic example 

```php

Route::post('upload-chunks', function (Request $request, LargeFileUploader $largeFileUploader) {
    return $largeFileUploader->uploadChunk($request);
})->name('upload-chunks');

Route::post('merge-chunks', function (Request $request, LargeFileUploader $largeFileUploader) {
    return $largeFileUploader->mergeChunks($request);
})->name('merge-chunks');

Route::get('file-upload', function () {
    return view('large-file-uploader::file-upload');
})->name('file-upload');

```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Alpesh Patel](https://github.com/AlpeshEquest)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
