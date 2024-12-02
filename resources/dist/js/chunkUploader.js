class ChunkUploader {
    constructor(options) {
        // Default settings
        this.settings = {
            chunkSize: 1024 * 1024, // 1MB by default
            uploadUrl: '/upload-chunk',
            mergeUrl: '/merge-chunks',
            target: null, // Target element for drag-and-drop
            fileInput: null, // Input element for file selection
            onProgress: null, // Callback for progress
            onSuccess: null, // Callback for success
            onError: null, // Callback for errors
            ...options,
        };

        // Bind event handlers
        if (this.settings.target) {
            this.initDragAndDrop(this.settings.target);
        }

        if (this.settings.fileInput) {
            this.settings.fileInput.addEventListener('change', (e) => this.handleFiles(e.target.files));
        }
    }

    initDragAndDrop(target) {
        const dropArea = document.querySelector(target);
        if (!dropArea) {
            throw new Error("Target element for drag-and-drop not found.");
        }

        dropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropArea.classList.add('dragover');
        });

        dropArea.addEventListener('dragleave', () => dropArea.classList.remove('dragover'));

        dropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dropArea.classList.remove('dragover');
            const files = e.dataTransfer.files;
            this.handleFiles(files);
        });
    }

    async handleFiles(files) {
        for (const file of files) {
            await this.uploadFile(file);
        }
    }

    async uploadFile(file) {
        const totalChunks = Math.ceil(file.size / this.settings.chunkSize);
        const fileName = file.name;

        for (let i = 0; i < totalChunks; i++) {
            const start = i * this.settings.chunkSize;
            const end = Math.min(start + this.settings.chunkSize, file.size);
            const chunk = file.slice(start, end);

            const formData = new FormData();
            formData.append('chunk', chunk);
            formData.append('file_name', fileName);
            formData.append('chunk_number', i + 1);

            try {
                const response = await fetch(this.settings.uploadUrl, {
                    method: 'POST',
                    body: formData,
                });

                if (!response.ok) {
                    throw new Error(`Error uploading chunk ${i + 1}`);
                }

                if (this.settings.onProgress) {
                    this.settings.onProgress(((i + 1) / totalChunks) * 100);
                }
            } catch (error) {
                if (this.settings.onError) {
                    this.settings.onError(error);
                }
                return;
            }
        }

        await this.mergeFile(fileName, totalChunks);
    }

    async mergeFile(fileName, totalChunks) {
        try {
            const response = await fetch(this.settings.mergeUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ file_name: fileName, total_chunks: totalChunks }),
            });

            if (!response.ok) {
                throw new Error('Error merging file');
            }

            if (this.settings.onSuccess) {
                this.settings.onSuccess(fileName);
            }
        } catch (error) {
            if (this.settings.onError) {
                this.settings.onError(error);
            }
        }
    }
}
