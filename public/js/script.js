document.addEventListener('DOMContentLoaded', function () {
    // Mendapatkan elemen input file
    const fileInput = document.getElementById('formFile');
    const deleteButtons = document.querySelectorAll('.deletetemporary');
    const update = document.querySelectorAll('.update_document');

    // Mendapatkan elemen pratinjau gambar
    const pdfPreview = document.getElementById('pdfPreview');
    const filename = document.getElementById('filename');

    document.getElementById('sorting').addEventListener('change', function (e) {
        if (e.target.value == 'document_terlama') {
            e.preventDefault();
        } else {
            document.getElementById('form-sorting').submit();
        }
    });

    // Menambahkan event change pada input file
    fileInput.addEventListener('change', function (event) {
        // Mendapatkan file yang dipilih
        const selectedFile = event.target.files[0];
        console.log(selectedFile);
        // Mengecek apakah file yang dipilih adalah PDF
        if (selectedFile && selectedFile.type === 'application/pdf') {
            // Membaca file dan menetapkan sumber gambar ke pratinjau
            if (selectedFile.size <= 307200) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    pdfPreview.style.display = 'block';
                    filename.style.display = 'block';
                    filename.innerHTML = selectedFile.name;
                    pdfPreview.src = "{{ asset('img/pdf_icon.png')}}";
                };
                reader.readAsDataURL(selectedFile);
            } else {
                filename.style.display = 'block';
                filename.classList.add('text-danger');
                filename.style.fontWeight = 'bold';
                filename.innerHTML = 'Ukuran PDF minimal 300 KB';
            }
        } else {
            // Menyembunyikan pratinjau jika file bukan PDF
            pdfPreview.style.display = 'none';
            filename.style.display = 'block';
            filename.classList.add('text-danger');
            filename.style.fontWeight = 'bold';
            filename.innerHTML = 'Jenis file tidak diijinkan';
        }
    });

    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const user = this.getAttribute('data-user');
            const kodeDocument = this.getAttribute('data-kode-document');
            Swal.fire({
                title: 'Ingin menghapus data?',
                text: "Data masih dapat dipulihkan di halaman Trash",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Deleted!',
                        'Data berhasil dihapus',
                        'success'
                    )
                    window.location.href = `{{ url('pembatalan_transaksi/delete') }}/${user}/${kodeDocument}`;
                }
            })
        });
    });

    update.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const id = this.getAttribute('data-id');
            const kodeDocument = this.getAttribute('data-kode-document');
            const input = document.createElement('input');
            const coverpdf = this.getAttribute('data-img');
            const csrf = this.getAttribute('data-csrf');
            input.type = 'file';
            input.accept = '.pdf';

            input.onchange = function (e) {
                const file = e.target.files[0];
                const myfile = e.target.files;
                const reader = new FileReader();

                reader.onload = function (e) {
                    Swal.fire({
                        title: 'Your uploaded document',
                        html: `
                        <p>${file.name}</p>
                        <img src="${coverpdf}" alt="PDF Icon" style="max-width: 100; height: 100;">
                    `,
                        showCancelButton: true,
                        cancelButtonText: 'Cancel',
                        confirmButtonText: 'Update',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                                'Updated!',
                                'Data berhasil diupdate',
                                'success'
                            );

                            // Create a dynamic form
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.enctype = 'multipart/form-data';
                            form.action = `pembatalan_transaksi/update/${id}/${kodeDocument}`;
                            form.style.display = 'none'; // Hide the form

                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = csrf;

                            const inputId = document.createElement('input');
                            inputId.type = 'hidden';
                            inputId.name = 'id';
                            inputId.value = id;

                            const inputKode = document.createElement('input');
                            inputKode.type = 'hidden';
                            inputKode.name = 'kode_document';
                            inputKode.value = kodeDocument;

                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(new File([file], file.name));

                            const inputFile = document.createElement('input');
                            inputFile.type = 'file';
                            inputFile.name = 'pdf_update';
                            inputFile.files = dataTransfer.files;

                            // Append the input to the form
                            form.appendChild(csrfInput);
                            form.appendChild(inputId);
                            form.appendChild(inputKode);
                            form.appendChild(inputFile);

                            // Append the form to the document body
                            document.body.appendChild(form);

                            // Submit the form
                            form.submit();
                        }
                    });
                };

                reader.readAsDataURL(file);
            };

            input.click();
        });
    });


});