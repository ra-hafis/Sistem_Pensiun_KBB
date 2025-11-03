document.addEventListener("DOMContentLoaded", () => {
    const jenisSelect = document.getElementById('jenis');
    const dokumenSection = document.getElementById('dokumen-section');
    const dokumenPerJenis = window.dokumenPerJenis;

    function renderDokumen(jenis) {
        if (!dokumenSection) return;

        dokumenSection.innerHTML = '';

        if (dokumenPerJenis[jenis]) {
            dokumenPerJenis[jenis].forEach((dok, idx) => {
                const div = document.createElement('div');
                div.classList.add('mb-3');

                div.innerHTML = `
                    <label class="form-label fw-medium ${dok.wajib == 1 ? 'text-danger' : ''}">
                        ${dok.nama} ${dok.wajib == 1 ? '<span class="text-danger">*</span>' : ''}
                    </label>
                    <input type="hidden" name="dokumen[]" value="${dok.nama}">
                    <input type="hidden" name="dokumen_wajib[]" value="${dok.wajib}">
                    <input type="file" name="dokumen_file[${idx}]" class="form-control file-upload" 
                        ${dok.wajib == 1 ? 'required' : ''} accept="application/pdf">
                `;

                dokumenSection.appendChild(div);

                // Validasi file PDF dan ukuran maksimal 2MB
                const fileInput = div.querySelector('input[type="file"]');
                fileInput.addEventListener('change', function () {
                    const file = this.files[0];
                    if (file) {
                        const ext = file.name.split('.').pop().toLowerCase();
                        if (ext !== 'pdf') {
                            alert('Hanya file PDF yang diperbolehkan!');
                            this.value = '';
                        } else if (file.size > 2 * 1024 * 1024) {
                            alert('Ukuran maksimal 2MB!');
                            this.value = '';
                        }
                    }
                });
            });
        }
    }

    // Render default saat load
    renderDokumen(jenisSelect.value);

    // Update saat ganti jenis pengajuan
    jenisSelect.addEventListener('change', () => {
        renderDokumen(jenisSelect.value);
    });
});
