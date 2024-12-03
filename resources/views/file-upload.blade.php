<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chunked File Upload</title>
</head>
<body>
    <form id="uploadForm">
        @csrf
        <x-chunk-file-upload-input :suffix="'1'" :containerClass="'exra-class'" />
    </form>
    <script src="{{assets('vendor/large-file-uploader/js/chunkUploader.js')}}"></script>
    <script>
        const chunkUploader = new ChunkUploader({
            form: document.getElementById('uploadForm'),
            url: '{{route('upload')}}',
            chunkSize: 1024 * 1024,
            parallelUploads: 3,
            retries: 3,
            retryTimeout: 1000,
            onProgress: (progress) => {
                console.log(progress);
            },
            onSuccess: (response) => {
                console.log(response);
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
</body>
</html>
