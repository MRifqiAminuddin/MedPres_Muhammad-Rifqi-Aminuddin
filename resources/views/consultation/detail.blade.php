@extends('layout.app')

@section('title', 'Konsultasi')

@section('content')
    <a class="btn bg-gradient-secondary btn-block mb-3" href="{{ route('consultation.index') }}">
        <i class="fas fa-arrow-left text-white"></i>&nbsp;&nbsp;Kembali
    </a>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4 p-2">
                <div class="card-header p-2">
                    <h5 class="mb-0">Data Pasien</h5>
                </div>

                <div class="card-body px-2 pt-0 pb-2">
                    <div class="row">
                        @php
                            $items = [
                                'No. RM' => $encounter->patient->medical_record_number,
                                'Nama Pasien' => $encounter->patient->name,
                                'Jenis Kelamin' => $encounter->patient->gender,
                                'Tinggi Badan' => $encounter->body_height . ' Cm',
                                'Berat Badan' => $encounter->body_weight . ' Kg',
                                'Tensi Darah' => $encounter->systole . '/' . $encounter->diastole . ' mmHg',
                                'Denyut Jantung' => $encounter->heart_rate . ' bpm',
                                'Frekuensi Napas' => $encounter->respiration_rate . ' bpm',
                                'Suhu Tubuh' => $encounter->body_temperature . ' °C',
                                'Keluhan' => $encounter->anamnesis,
                                'Tanggal Berobat' => $encounter->encounter_date,
                            ];
                        @endphp

                        @foreach ($items as $label => $value)
                            <div class="col-12 col-md-6 col-lg-4 row mb-2">
                                <div class="col-5 fw-bold">{{ $label }}</div>
                                <div class="col-7 d-flex">
                                    <span class="me-2">:</span>
                                    <div>{{ $value }}</div>
                                </div>
                            </div>
                        @endforeach

                        <div class="col-12 col-md-6 col-lg-4 row mb-2">
                            <div class="col-5 fw-bold">Dokumen Lainnya</div>
                            <div class="col-7 d-flex">
                                <span class="me-2">:</span>
                                <button type="button" class="btn bg-gradient-dark btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalImagePreview">
                                    <i class="fa-solid fa-up-right-from-square text-white"></i>
                                    Lihat Gambar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card mb-4 mx-4 p-2">
                <div class="card-header p-2">
                    <h5 class="mb-0">Form Konsultasi</h5>
                </div>

                <div class="card-body px-2 pt-0 pb-2">
                    <form id="formConsultation" class="row">
                        <div class="form-group col-12 mb-3">
                            <input type="hidden" name="identity" value="{{ $encounter->identity }}">
                            <label>Diagnosa</label>
                            <textarea name="diagnosa" id="diagnosa" class="form-control" rows="6" placeholder="Isi diagnosa"></textarea>
                        </div>

                        <div class="form-group col-12">
                            <label>Obat</label>

                            <button type="button" class="btn bg-gradient-primary w-100 mb-2"
                                onclick="openMedicineModal();">
                                <i class="fas fa-pills"></i>&nbsp;&nbsp;Pilih Obat
                            </button>
                            <div id="medicineDiv"></div>
                        </div>
                        <div class="form-group col-12">
                            <button type="button" class="btn bg-gradient-success" onclick="saveAll()">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="searchMedicineModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Obat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="fa-solid fa-x text-dark"></i></button>
                </div>

                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="searchMedicineTable" class="table w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Obat</th>
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

    <div class="modal fade" id="modalImagePreview" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content bg-transparent border-0">
                <div class="d-flex justify-content-end mb-2">
                    <button type="button" class="btn bg-gradient-secondary btn-sm" data-bs-dismiss="modal" id="btnCloseCreateModal">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </button>
                </div>

                <img src="{{ asset('assets/upload/other-documents/' . $encounter->other_document) }}"
                    class="img-fluid rounded shadow border border-2 border-white">
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let medicineTable;
        let medicineModal;

        document.addEventListener('DOMContentLoaded', function() {
            medicineModal = new bootstrap.Modal(
                document.getElementById('searchMedicineModal'), {
                    backdrop: 'static',
                    keyboard: false
                }
            );
        });

        function openMedicineModal() {
            medicineModal.show();

            if (!medicineTable) {
                medicineTable = $('#searchMedicineTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('consultation.medicine.list') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        }
                    ]
                });
            } else {
                medicineTable.ajax.reload(null, false);
            }
        }

        let selectedMedicines = new Set();

        function selectMedicine(id, name) {
            if (selectedMedicines.has(id)) {
                alert('Obat sudah dipilih');
                return;
            }

            selectedMedicines.add(id);

            const container = document.getElementById('medicineDiv');

            const html = `
            <div class="row g-2 mb-2 medicine-item" data-id="${id}">
                <input type="hidden" name="medicine_ids[]" value="${id}">

                <div class="col-md-4">
                    <input type="text" class="form-control" value="${name}" readonly>
                </div>

                <div class="col-md-3">
                    <select name="dosage[]" class="form-select">
                        <option value="1x1">1x1</option>
                        <option value="2x1">2x1</option>
                        <option value="3x1">3x1</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="rule[]" class="form-select">
                        <option value="Sesudah Makan">Sesudah Makan</option>
                        <option value="Sebelum Makan">Sebelum Makan</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="button"
                        class="btn btn-danger w-100"
                        onclick="removeMedicine('${id}')">
                        Hapus
                    </button>
                </div>
            </div>
        `;

            container.insertAdjacentHTML('beforeend', html);

            bootstrap.Modal.getInstance(
                document.getElementById('searchMedicineModal')
            )?.hide();
        }

        function removeMedicine(id) {
            selectedMedicines.delete(id);

            const item = document.querySelector(
                `.medicine-item[data-id="${id}"]`
            );

            if (item) item.remove();
        }

        function saveAll() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            // Ambil data dari form
            const formData = $('#formConsultation').serialize();
            // Kirim data ke server dengan AJAX
            $.ajax({
                url: "{{ route('consultation.prescription.create') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);
                    success("Berhasil menambahkan data");
                    $('#btnCloseCreateModal').click();
                    window.location.href = "{{ route('consultation.index') }}";
                },
                error: function(xhr) {
                    // Tampilkan pesan error
                    fail(xhr.responseJSON ? xhr.responseJSON.message : 'Server tidak merespons');
                }
            });
        }
    </script>
@endsection
