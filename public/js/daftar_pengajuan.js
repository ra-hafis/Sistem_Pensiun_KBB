document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchInput");
    const filterJenis = document.getElementById("filterJenis");
    const filterDinas = document.getElementById("filterDinas");
    const table = document.getElementById("pengajuanTable");
    const rows = table.getElementsByTagName("tr");

    // ======== 🔍 FILTER TABEL ========
    function filterTable() {
        const searchValue = searchInput.value.toLowerCase();
        const jenisValue = filterJenis.value.toLowerCase();
        const dinasValue = filterDinas.value.toLowerCase();

        for (let i = 1; i < rows.length; i++) { // lewati header
            const cols = rows[i].getElementsByTagName("td");
            if (!cols.length) continue;

            const nama = cols[2].innerText.toLowerCase();
            const jenis = cols[5].innerText.toLowerCase();
            const dinas = cols[6].innerText.toLowerCase();

            const matchSearch =
                nama.includes(searchValue) ||
                jenis.includes(searchValue) ||
                dinas.includes(searchValue);

            const matchJenis = !jenisValue || jenis === jenisValue;
            const matchDinas = !dinasValue || dinas === dinasValue;

            rows[i].style.display = (matchSearch && matchJenis && matchDinas) ? "" : "none";
        }
    }

    if (searchInput) searchInput.addEventListener("keyup", filterTable);
    if (filterJenis) filterJenis.addEventListener("change", filterTable);
    if (filterDinas) filterDinas.addEventListener("change", filterTable);

    // ======== 🗑️ HAPUS DENGAN SWEETALERT ========
    document.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data pengajuan ini akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(`${base_url}/admin/hapusdaftarpengajuan/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire('Terhapus!', data.message, 'success');
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            Swal.fire('Gagal!', data.message, 'error');
                        }
                    })
                    .catch(() => Swal.fire('Error!', 'Terjadi kesalahan saat menghapus.', 'error'));
                }
            });
        });
    });
});
