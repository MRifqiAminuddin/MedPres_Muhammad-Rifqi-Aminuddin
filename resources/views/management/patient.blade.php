@extends('layout.app')

@section('title')
    Manajemen Pasien
@endsection

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4 p-2">
                    <div class="card-header p-2">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Daftar Pasien</h5>
                            </div>
                            <button type="button" class="btn bg-gradient-primary btn-block mb-3" data-bs-toggle="modal"
                                data-bs-target="#createPatientModal">
                                <i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Pasien
                            </button>
                        </div>
                    </div>
                    <div class="card-body px-2 pt-0 pb-2">
                        <div class="table-responsive">
                            <table id="patientTable" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Rekam Medis</th>
                                        <th>Nama</th>
                                        <th>TTL</th>
                                        <th>Jenis Kelamin</th>
                                        <th style="text-align: center!important">Aksi</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="createPatientModal" tabindex="-1" role="dialog" aria-labelledby="createPatientModalTitle"
        aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPatientModalTitle"><b>Tambah Pasien</b></h5>
                    <button type="button" id="btnCloseCreateModal" class="btn-close text-dark" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">
                            <i class="fa-solid fa-x"></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="formCreatePatient" enctype="multipart/form-data" class="row">
                        <input type="hidden" name="_token" id="tokenCreate" value="{{ csrf_token() }}"
                            autocomplete="off">
                        <div class="form-group col-xl-6 col-md-6 col-sm-12">
                            <label for="medicalRecordNumberCreate" class="col-form-label">No. Rekam Medis:</label>
                            <input type="number" class="form-control" name="medicalRecordNumber" id="medicalRecordNumberCreate"
                                placeholder="Masukkan nama">
                        </div>
                        <div class="form-group col-xl-6 col-md-6 col-sm-12">
                            <label for="nameCreate" class="col-form-label">Nama:</label>
                            <input type="text" class="form-control" name="name" id="nameCreate"
                                placeholder="Masukkan nama">
                        </div>
                        <div class="form-group col-xl-6 col-md-6 col-sm-12">
                            <label for="birthDateCreate" class="col-form-label">Tanggal Lahir:</label>
                            <input type="date" class="form-control" name="birthDate" id="birthDateCreate"
                                placeholder="Masukkan Tanggal Lahir">
                        </div>
                        <div class="form-group col-xl-6 col-md-6 col-sm-12">
                            <label class="form-label d-block">Jenis Kelamin</label>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="genderMaleCreate"
                                    value="Laki Laki">
                                <label class="form-check-label" for="genderMaleCreate">
                                    Laki-laki
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="genderFemaleCreate"
                                    value="Perempuan">
                                <label class="form-check-label" for="genderFemaleCreate">
                                    Perempuan
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-danger" data-bs-dismiss="modal">Batal</button>
                            <button type="button" id="btnCreate" class="btn bg-gradient-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <button type="button" id="btnOpenEditModal" data-bs-toggle="modal" data-bs-target="#editPatientModal"
        style="display: none"></button>
    <div class="modal fade " id="editPatientModal" tabindex="-1" role="dialog"
        aria-labelledby="editPatientModalTitle" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPatientModalTitle"><b>Edit Pasien</b></h5>
                    <button type="button" id="btnCloseEditModal" class="btn-close text-dark" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">
                            <i class="fa-solid fa-x"></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="formEditPatient" enctype="multipart/form-data"
                        class="row">
                        <input type="hidden" name="_token" id="tokenEdit" value="{{ csrf_token() }}"
                            autocomplete="off">                            
                        <div class="form-group col-xl-6 col-md-6 col-sm-12">
                            <label for="medicalRecordNumberEdit" class="col-form-label">No. Rekam Medis:</label>
                            <input type="number" class="form-control" name="medicalRecordNumber" id="medicalRecordNumberCreate"
                                placeholder="Masukkan nama">
                        </div>
                        <div class="form-group col-xl-6 col-md-6 col-sm-12">
                            <label for="nameEdit" class="col-form-label">Nama:</label>
                            <input type="text" class="form-control" name="name" id="nameEdit"
                                placeholder="Masukkan nama">
                        </div>
                        <div class="form-group col-xl-6 col-md-6 col-sm-12">
                            <label for="birthDateEdit" class="col-form-label">Tanggal Lahir:</label>
                            <input type="date" class="form-control" name="birthDate" id="birthDateEdit"
                                placeholder="Masukkan Tanggal Lahir">
                        </div>
                        <div class="form-group col-xl-6 col-md-6 col-sm-12">
                            <label class="form-label d-block">Jenis Kelamin</label>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="genderMaleEdit"
                                    value="Laki Laki">
                                <label class="form-check-label" for="genderMaleEdit">
                                    Laki-laki
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="genderFemaleEdit"
                                    value="Perempuan">
                                <label class="form-check-label" for="genderFemaleEdit">
                                    Perempuan
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-danger" data-bs-dismiss="modal">Batal</button>
                            <button type="button" id="btnEdit" class="btn bg-gradient-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            showAll();
        });

        $('#btnCreate')
            .off('click')
            .on('click', function() {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah data sudah benar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                }).then((result) => {
                    if (result.isConfirmed) {
                        createData();
                    }
                });
            });


        function resetInput() {
            // Pilih semua elemen input dalam form
            const inputs = document.querySelectorAll("form input, form select, form textarea");

            // Iterasi dan kosongkan nilainya
            inputs.forEach(input => {
                if (input.type === "checkbox" || input.type === "radio") {
                    input.checked = false; // Uncheck checkbox atau radio button
                } else {
                    input.value = ""; // Kosongkan nilai untuk input, select, dan textarea
                }
            });
        }

        function showAll() {
            // Jika DataTable sudah ada, hancurkan dulu
            if ($.fn.dataTable.isDataTable('#patientTable')) {
                $('#patientTable').DataTable().clear().destroy();
            }

            // Inisialisasi DataTables
            var table = $('#patientTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('management.patient.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: 28,
                    },
                    {
                        data: 'medical_record_number',
                        name: 'medical_record_number'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'birth_date',
                        name: 'birth_date'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                ],
                // Tambahkan event xhr di sini
                xhr: function() {
                    // Fungsi dipanggil setelah data selesai dimuat
                    hideLoader();
                }
            });
        }

        function createData() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            // Ambil data dari form
            const formData = $('#formCreatePatient').serialize();
            // Kirim data ke server dengan AJAX
            $.ajax({
                url: "{{ route('management.patient.store') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    success("Berhasil menambahkan data");
                    $('#btnCloseCreateModal').click();
                    showAll();
                },
                error: function(xhr) {
                    // Tampilkan pesan error
                    fail(xhr.responseJSON ? xhr.responseJSON.message : 'Server tidak merespons');
                }
            });
        }

        function showEdit(identity) {
            showLoader();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            // Kirim data ke server dengan AJAX
            $.ajax({
                url: "{{ route('management.patient.show', 'harusGanti') }}".replace('harusGanti', identity),
                type: 'POST',
                success: function(response) {
                    $('#medicalRecordNumberEdit').val(response.data.medical_record_number);
                    $('#nameEdit').val(response.data.name);
                    $('#birthDateEdit').val(response.data.birth_date);
                    $(`input[name="gender"][value="${response.data.gender}"]`)
                        .prop('checked', true);

                    $('#btnEdit').off('click').on('click', function() {
                        showConfirm(
                            response.data.name,
                            response.data.identity,
                            'Apakah data sudah benar?',
                            edit
                        );
                    });

                    $('#btnOpenEditModal').click();
                    hideLoader();
                },
                error: function(xhr) {
                    // Tampilkan pesan error
                    fail(xhr.responseJSON ? xhr.responseJSON.message : 'Server tidak merespons');
                }
            });

        }

        function edit(text, identity) {
            // Ambil data dari form
            const formData = $('#formEditPatient').serialize();

            // Kirim data ke server dengan AJAX
            $.ajax({
                url: "{{ route('management.patient.update', 'harusGanti') }}".replace('harusGanti', identity),
                type: 'POST',
                data: formData,
                success: function(response) {
                    success("Data <b>" + text + "</b> telah diperbarui");
                    $('#btnCloseEditModal').click();
                    showAll();
                },
                error: function(xhr) {
                    // Tampilkan pesan error
                    fail(xhr.responseJSON ? xhr.responseJSON.message : 'Server tidak merespons');
                }
            });

        }

        function deleteData(text, identity) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            // Kirim data ke server dengan AJAX
            $.ajax({
                url: "{{ route('management.patient.delete', 'harusGanti') }}".replace('harusGanti', identity),
                type: 'POST',
                success: function(response) {
                    success("Data <b>" + text + "</b> telah dihapus");
                    showAll();
                },
                error: function(xhr) {
                    // Tampilkan pesan error
                    fail(xhr.responseJSON ? xhr.responseJSON.message : 'Server tidak merespons');
                }
            });
        }

        var navbarColorOnResize = function() {
            if ($(window).width() > 991) {
                if ($('.main-content .fixed-plugin > .card').length != 0) {
                    $('.main-content .fixed-plugin > .card').removeClass('blur');
                }
            }
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', navbarColorOnResize);
        } else {
            navbarColorOnResize();
        }
    </script>
@endsection
