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
    <script src="{{asset('vendor/large-file-uploader/js/chunkUploader.js')}}"></script>
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
</body>
</html>
