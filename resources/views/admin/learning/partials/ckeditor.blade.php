<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
<script>
    class LaravelUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }

        compressImage(file) {
            // Biarkan GIF apa adanya agar animasi tidak hilang
            if (!file.type.startsWith('image/') || file.type === 'image/gif') {
                return Promise.resolve(file);
            }

            return new Promise((resolve) => {
                const maxDimension = 1200;
                const objectUrl = URL.createObjectURL(file);
                const img = new Image();

                img.onload = () => {
                    URL.revokeObjectURL(objectUrl);

                    let { width, height } = img;
                    const needsResize = width > maxDimension || height > maxDimension;

                    if (needsResize) {
                        const ratio = Math.min(maxDimension / width, maxDimension / height);
                        width = Math.round(width * ratio);
                        height = Math.round(height * ratio);
                    }

                    const canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;

                    const ctx = canvas.getContext('2d');
                    if (!ctx) {
                        resolve(file);
                        return;
                    }

                    ctx.drawImage(img, 0, 0, width, height);

                    const baseName = (file.name || 'image').replace(/\.[^.]+$/, '');
                    const tryEncode = (mime, ext, quality, fallback) => {
                        canvas.toBlob((blob) => {
                            if (!blob) {
                                fallback ? fallback() : resolve(file);
                                return;
                            }
                            if (mime === 'image/webp' && blob.type !== 'image/webp' && fallback) {
                                fallback();
                                return;
                            }
                            // Pakai hasil kompresi jika lebih kecil atau ukuran dimensi diperkecil
                            if (blob.size < file.size || needsResize) {
                                resolve(new File([blob], `${baseName}.${ext}`, { type: blob.type }));
                            } else {
                                resolve(file);
                            }
                        }, mime, quality);
                    };

                    tryEncode('image/webp', 'webp', 0.78, () => {
                        tryEncode('image/jpeg', 'jpg', 0.80, null);
                    });
                };

                img.onerror = () => {
                    URL.revokeObjectURL(objectUrl);
                    resolve(file);
                };

                img.src = objectUrl;
            });
        }

        upload() {
            return this.loader.file
                .then(file => this.compressImage(file))
                .then(compressedFile => new Promise((resolve, reject) => {
                    const formData = new FormData();
                    formData.append('upload', compressedFile, compressedFile.name);

                    fetch('{{ route('admin.learning.upload-image') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(async response => {
                        const data = await response.json().catch(() => ({}));
                        if (!response.ok || !data.url) {
                            const message = data.message || (data.error && data.error.message) || 'Gagal mengunggah gambar.';
                            throw new Error(message);
                        }
                        resolve({ default: data.url });
                    })
                    .catch(error => {
                        reject(error.message || 'Gagal mengunggah gambar.');
                    });
                }));
        }

        abort() {}
    }

    function LaravelUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new LaravelUploadAdapter(loader);
        };
    }

    ClassicEditor
        .create(document.querySelector('#content'), {
            extraPlugins: [LaravelUploadAdapterPlugin],
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'imageUpload', 'undo', 'redo']
        })
        .catch(error => {
            console.error(error);
        });
</script>
