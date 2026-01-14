@extends('layout.app')

@section('title', 'Kunjungan')

@section('head')
    <style>
        #video {
            transform: scaleX(-1);
            -webkit-transform: scaleX(-1);
        }
    </style>
@endsection

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4 p-2">
                    <div class="card-header p-2">
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0">Kunjungan Hari Ini</h5>
                            <button type="button" id="btnOpenModal" class="btn bg-gradient-primary" data-bs-toggle="modal"
                                data-bs-target="#encounterModal" onclick="btnOpenModal()">
                                <i class="fas fa-plus"></i>&nbsp;&nbsp;Buat Kunjungan
                            </button>
                        </div>
                    </div>
                    <div class="card-body px-2 pt-0 pb-2">
                        <div class="table-responsive">
                            <table id="encounterTable" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Waktu</th>
                                        <th>Pasien</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Dokter</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="encounterModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-bold" id="encounterModalTitle">Buat Kunjungan</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal">
                        <i class="fa-solid fa-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEncounter" class="row" enctype="multipart/form-data">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" autocomplete="off">
                        <div class="form-group col-xl-8 col-md-6 col-sm-12 row">
                            <div class="form-group col-xl-4 col-md-6 col-sm-12">
                                <label>Data Pasien:</label>
                                <div class="input-group">
                                    <input type="hidden" name="patientIdentity" id="patientIdentity" hidden>
                                    <input type="text" class="form-control" name="patientName" id="patientName"
                                        placeholder="Klik tombol cari" readonly>
                                    <button type="button" id="searchPatient" class="btn bg-gradient-primary mb-0"
                                        onclick="clickSearchPatient()">
                                        <i class="fa-solid fa-magnifying-glass"></i> Cari
                                    </button>
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-md-6 col-sm-12">
                                <label>Data Dokter:</label>
                                <div class="input-group">
                                    <input type="hidden" name="doctorIdentity" id="doctorIdentity" hidden>
                                    <input type="text" class="form-control" name="doctorName" id="doctorName"
                                        placeholder="Klik tombol cari" readonly>
                                    <button type="button" id="searchDoctor" class="btn bg-gradient-primary mb-0"
                                        onclick="clickSearchDoctor()">
                                        <i class="fa-solid fa-magnifying-glass"></i> Cari
                                    </button>
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-md-6 col-sm-12">
                                <label>Tensi Darah:</label>
                                <div class="input-group row">
                                    <div class="col-5">
                                        <input type="number" class="form-control" name="systole" id="systole"
                                            placeholder="Systol">
                                    </div>
                                    <div class="col-1">
                                        <center>
                                            <p>/</p>
                                        </center>
                                    </div>
                                    <div class="col-5">
                                        <input type="number" class="form-control" name="diastole" id="diastole"
                                            placeholder="Diastol">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-md-6 col-sm-12">
                                <label>Tinggi Badan:</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="bodyHeight" id="bodyHeight"
                                        placeholder="(cm)">
                                    &nbsp;cm
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-md-6 col-sm-12">
                                <label>Berat Badan:</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="bodyWeight" id="bodyWeight"
                                        placeholder="(kg)">
                                    &nbsp;Kg
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-md-6 col-sm-12">
                                <label>Denyut Jantung:</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="heartRate" id="heartRate"
                                        placeholder="(Bpm)">
                                    &nbsp;Bpm
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-md-6 col-sm-12">
                                <label>Frekuensi Napas:</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="respirationRate"
                                        id="respirationRate" placeholder="(Bpm)">
                                    &nbsp;Bpm
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-md-6 col-sm-12">
                                <label>Suhu Badan:</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="bodyTemperature"
                                        id="bodyTemperature" placeholder="(℃)">
                                    &nbsp;℃
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-md-6 col-sm-12">
                                <label>Dokumen Lainnya:</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="otherDocument" id="otherDocument"
                                        accept="image/*," capture="environment">
                                    <button type="button" id="btnWebcam" class="btn bg-gradient-primary mb-0">
                                        <i class="fa-solid fa-camera"></i> Kamera
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xl-4 col-md-6 col-sm-12 row">
                            <div class="form-group col-12">
                                <div id="previewArea" class="mt-2 d-none">
                                    <img id="imgPreview" src="" class="img-thumbnail"
                                        style="max-height: 200px;">
                                    <input type="hidden" name="fileNameDocument" id="fileNameDocument">
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label>Keluhan:</label>
                                <div class="input-group">
                                    <textarea name="anamnesis" id="anamnesis" placeholder="(keluhan)" cols="30" rows="10"
                                        class="form-control" style="height: 170px"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-danger" data-bs-dismiss="modal">Batal</button>
                            <button type="button" id="btnCreate" class="btn btn-primary">Simpan</button>
                            <button type="button" id="btnEdit" class="btn btn-warning d-none">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="openDiaologCamera" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Foto Dokumen</b></h5>
                    <button type="button" class="btn-close text-dark" id="closeDialogCamera">
                        <i class="fa-solid fa-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="cameraBox" class="d-none mt-2 text-center">
                        <video id="video" width="100%" autoplay playsinline class="rounded border"></video>
                        <br>
                        <button type="button" id="btnCapture" class="btn btn-success btn-sm mt-2">
                            Ambil Foto
                        </button>
                        <center>
                            <canvas id="canvas" class="d-none"></canvas>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="searchModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleSearchModal"><b></b></h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal">
                        <i class="fa-solid fa-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" id="searchPatientDiv" style="visibility: hidden; display:none">
                        <table id="searchPatientTable" class="table align-items-center mb-0 w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No. RM</th>
                                    <th>Nama</th>
                                    <th>Tgl Lahir</th>
                                    <th>Gender</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="table-responsive" id="searchDoctorDiv" style="visibility: hidden; display:none">
                        <table id="searchDoctorTable" class="table align-items-center mb-0 w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Gender</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            /**
             * Inisialisasi awal saat halaman dimuat.
             */
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            showAll();

            $('#closeDialogCamera').on('click', function() {
                if (video.srcObject) {
                    video.srcObject.getTracks().forEach(track => track.stop());
                    $('#openDiaologCamera').modal('hide');
                }
            });

            $('#btnWebcam').on('click', async function(e) {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        video: true
                    });
                    video.srcObject = stream;
                    $('#cameraBox').removeClass('d-none');


                    e.preventDefault();
                    const openDiaologCamera = new bootstrap.Modal(document.getElementById(
                        'openDiaologCamera'), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    if ($.fn.dataTable.isDataTable('#searchPatientTable')) {
                        $('#searchPatientTable').DataTable().destroy();
                        return;
                    }
                    openDiaologCamera.show();
                } catch (err) {
                    alert("Gagal mengakses kamera: " + err.message);
                }
            });

            $('#btnCapture').on('click', function() {
                if (video.videoWidth === 0) {
                    alert("Kamera belum siap.");
                    return;
                }

                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;

                // --- PROSES MIRRORING PADA HASIL FOTO ---
                context.save(); // Simpan state canvas
                context.translate(canvas.width, 0); // Geser ke kanan
                context.scale(-1, 1); // Balik secara horizontal

                // Gambar frame dari video ke canvas
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                context.restore(); // Kembalikan state canvas
                // ----------------------------------------

                const data = canvas.toDataURL('image/jpeg');
                $('#imgPreview').attr('src', data);

                $('#previewArea').removeClass('d-none');
                $('#cameraBox').addClass('d-none');

                // Matikan aliran kamera untuk menghemat resource
                if (video.srcObject) {
                    video.srcObject.getTracks().forEach(track => track.stop());
                    $('#openDiaologCamera').modal('hide');
                }
            });

            $('#otherDocument').on('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        $('#imgPreview').attr('src', e.target.result);
                        $('#previewArea').removeClass('d-none');
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Tombol Simpan (Confirm SweetAlert)
            $('#btnCreate').on('click', function() {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah data sudah benar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        createData();
                    }
                });
            });
        });

        /**
         * FUNGSI-FUNGSI PENDUKUNG (DI LUAR document.ready)
         */

        // Trigger Modal Cari Pasien (Membuka di atas modal Create)
        function clickSearchPatient() {
            $('#searchDoctorDiv').css('visibility', 'hidden');
            $('#searchDoctorDiv').css('display', 'none');
            $('#searchPatientDiv').css('visibility', 'visible');
            $('#searchPatientDiv').css('display', 'block');

            const searchModal = new bootstrap.Modal(document.getElementById('searchModal'), {
                backdrop: 'static',
                keyboard: false
            });
            if ($.fn.dataTable.isDataTable('#searchDoctorTable')) {
                $('#searchDoctorTable').DataTable().destroy();
            }
            if ($.fn.dataTable.isDataTable('#searchPatientTable')) {
                $('#searchPatientTable').DataTable().destroy();
                return;
            }
            searchModal.show();
            // Inisialisasi DataTable Pasien
            initSearchPatientTable();
        };

        // Trigger Modal Cari Doctor (Membuka di atas modal Create)
        function clickSearchDoctor() {
            $('#searchPatientDiv').css('visibility', 'hidden');
            $('#searchPatientDiv').css('display', 'none');
            $('#searchDoctorDiv').css('visibility', 'visible');
            $('#searchDoctorDiv').css('display', 'block');

            const searchModal = new bootstrap.Modal(document.getElementById('searchModal'), {
                backdrop: 'static',
                keyboard: false
            });
            if ($.fn.dataTable.isDataTable('#searchPatientTable')) {
                $('#searchPatientTable').DataTable().destroy();
            }
            if ($.fn.dataTable.isDataTable('#searchDoctorTable')) {
                $('#searchDoctorTable').DataTable().destroy();
                return;
            }
            searchModal.show();
            // Inisialisasi DataTable Pasien
            initSearchDoctorTable();
        };

        function showAll() {
            if ($.fn.dataTable.isDataTable('#encounterTable')) {
                $('#encounterTable').DataTable().destroy();
            }

            $('#encounterTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('encounter.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        width: 28,
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'time',
                        name: 'time'
                    },
                    {
                        data: 'patient_name',
                        name: 'patient_name'
                    },
                    {
                        data: 'patient_gender',
                        name: 'patient_gender'
                    },
                    {
                        data: 'doctor_name',
                        name: 'doctor_name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    }
                ],
                drawCallback: function() {
                    if (typeof hideLoader === "function") hideLoader();
                }
            });
        }

        function initSearchPatientTable() {
            $('#searchPatientTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('encounter.search.patient') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
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
                        searchable: false,
                    }
                ]
            });
        }

        function initSearchDoctorTable() {
            $('#searchDoctorTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('encounter.search.doctor') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: 28,
                    },
                    {
                        data: 'name',
                        name: 'name'
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
                        searchable: false,
                    }
                ]
            });
        }

        function selectUser(mode, name, identity) {
            if (mode === "patient") {
                $('#patientName').val(name);
                $('#patientIdentity').val(identity);
            } else if (mode === "doctor") {
                $('#doctorName').val(name);
                $('#doctorIdentity').val(identity);
            }
            // Tutup modal menggunakan jQuery
            $('#searchModal').modal('hide');
        }

        function btnOpenModal() {
            $('#btnEdit').addClass('d-none').hide();
            $('#btnCreate')
                .removeClass('d-none')
                .show()
                .html('<i class="fa fa-save"></i> Simpan');
            $('#encounterModalTitle').text('Buat Kunjungan');
        }

        function createData() {
            const form = $('#formEncounter')[0];
            const formData = new FormData(form);

            const imageSrc = $('#imgPreview').attr('src');
            formData.append('captured_image', imageSrc);

            $.ajax({
                url: "{{ route('encounter.store') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    Swal.fire('Berhasil', 'Data kunjungan telah disimpan', 'success');
                    $('#encounterModal').modal('hide');
                    showAll();
                    form.reset();
                    $('#previewArea').addClass('d-none');
                },
                error: function(xhr) {
                    const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan server';
                    Swal.fire('Error', msg, 'error');
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
                url: "{{ route('encounter.show', 'harusGanti') }}".replace('harusGanti', identity),
                type: 'POST',
                success: function(response) {

                    $('#btnCreate').addClass('d-none').hide();
                    $('#btnEdit')
                        .removeClass('d-none')
                        .show()
                        .html('<i class="fa fa-save"></i> Ubah');
                    $('#encounterModalTitle').text('Ubah Kunjungan');

                    $('#patientIdentity').val(response.added.patient_identity);
                    $('#patientName').val(response.added.patient_name);
                    $('#doctorIdentity').val(response.added.doctor_identity);
                    $('#doctorName').val(response.added.doctor_name);
                    $('#systole').val(response.data.systole);
                    $('#diastole').val(response.data.diastole);
                    $('#bodyHeight').val(response.data.body_height);
                    $('#bodyWeight').val(response.data.body_weight);
                    $('#heartRate').val(response.data.heart_rate);
                    $('#respirationRate').val(response.data.respiration_rate);
                    $('#bodyTemperature').val(response.data.body_temperature);
                    $('#anamnesis').val(response.data.anamnesis);
                    if (response.data.other_document == null) {
                        $('#imgPreview').attr('src', '');
                    } else {
                        $('#imgPreview').attr('src', '{{ asset('assets/upload/other-documents') }}' + '/' +
                            response
                            .data.other_document);
                    }

                    $('#previewArea').removeClass('d-none');
                    $('#fileNameDocument').val(response.data.other_document);


                    $('#btnEdit').off('click').on('click', function() {
                        showConfirm(
                            response.added.patient_name,
                            response.data.identity,
                            'Apakah data sudah benar?',
                            edit
                        );
                    });

                    $('#encounterModal').modal('show');
                    hideLoader();
                },
                error: function(xhr) {
                    // Tampilkan pesan error
                    fail(xhr.responseJSON ? xhr.responseJSON.message : 'Server tidak merespons');
                }
            });

        }

        function edit(text, identity) {
            const form = $('#formEncounter')[0];
            const formData = new FormData(form);

            const imageSrc = $('#imgPreview').attr('src');
            formData.append('captured_image', imageSrc);

            // Kirim data ke server dengan AJAX
            $.ajax({
                url: "{{ route('encounter.update', 'harusGanti') }}".replace('harusGanti', identity),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    success("Data <b>" + text + "</b> telah diperbarui");
                    $('#encounterModal').modal('hide');
                    $('#btnCloseEditModal').click();
                    $('#patientIdentity').val();
                    $('#patientName').val();
                    $('#doctorIdentity').val();
                    $('#doctorName').val();
                    $('#systole').val();
                    $('#diastole').val();
                    $('#bodyHeight').val();
                    $('#bodyWeight').val();
                    $('#heartRate').val();
                    $('#respirationRate').val();
                    $('#bodyTemperature').val();
                    $('#anamnesis').val();
                    $('#imgPreview').attr('src', '');
                    $('#previewArea').addClass('d-none');
                    $('#fileNameDocument').val('');
                    showAll();
                },
                error: function(xhr) {
                    // Tampilkan pesan error
                    fail(xhr.responseJSON ? xhr.responseJSON.message : 'Server tidak merespons');
                }
            });

        }

        function call(text, identity) {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('identity', identity);

            // Kirim data ke server dengan AJAX
            $.ajax({
                url: "{{ route('encounter.call', 'harusGanti') }}".replace('harusGanti', identity),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    success("Telah memanggil pasien <b>" + text );
                    showAll();
                },
                error: function(xhr) {
                    // Tampilkan pesan error
                    fail(xhr.responseJSON ? xhr.responseJSON.message : 'Server tidak merespons');
                }
            });

        }
    </script>
@endsection
