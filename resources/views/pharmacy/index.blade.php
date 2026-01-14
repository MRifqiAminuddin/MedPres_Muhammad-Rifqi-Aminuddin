@extends('layout.app')

@section('title', 'Konsultasi')

@section('head')
    <style>
        .task-card {
            min-width: 280px;
            max-width: 280px;
            flex-shrink: 0;
        }

        .medicine-list {
            max-height: 220px;
            overflow-y: auto;
        }
    </style>

@endsection

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="px-5 mb-3">
                    <h5 class="mb-0">Tugas Saya</h5>
                </div>

                <div class="d-flex flex-row gap-3 px-5 pb-3 mb-4 overflow-auto" id="divTaskList">
                    <div class="card task-card shadow-sm position-relative">
                        <div class="text-end p-2">
                            <button type="button" class="btn btn-sm btn-danger btn-close-task text-white mb-0"
                                style="width: 10px!important">
                                &times;
                            </button>
                        </div>

                        <div class="card-body py-0">
                            <div class="mb-3 border-bottom pb-2">
                                <h6 class="mb-0 fw-bold">Siti Aisyah</h6>
                                <small class="text-muted">Umur: 32 Tahun</small>
                            </div>

                            <div class="medicine-list">
                                <div class="mb-2 p-2 rounded bg-light">
                                    <div class="fw-semibold">Cetirizine</div>
                                    <small class="text-muted">
                                        1x1 • Sesudah Makan
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-transparent border-0 text-end py-0 px-2" style="height: 43px;">
                            <button class="btn btn-sm btn-success">
                                Selesai
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card mb-4 mx-4 p-2">
                    <div class="card-header p-2">
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0">Antrian Obat</h5>
                        </div>
                    </div>
                    <div class="card-body px-2 pt-0 pb-2">
                        <div class="table-responsive">
                            <table id="pharmacyTable" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Pasien</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Umur</th>
                                        <th>Poli</th>
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
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            showAll();
        });

        function showAll() {
            // Jika DataTable sudah ada, hancurkan dulu
            if ($.fn.dataTable.isDataTable('#pharmacyTable')) {
                $('#pharmacyTable').DataTable().clear().destroy();
            }

            // Inisialisasi DataTables
            var table = $('#pharmacyTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('pharmacy.index') }}",
                columns: [{
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: 28,
                    },
                    {
                        data: 'prescription_date',
                        name: 'prescription_date',
                    },
                    {
                        data: 'patient_name',
                        name: 'patient_name'
                    },
                    {
                        data: 'patient_birth_date',
                        name: 'patient_birth_date',
                    },
                    {
                        data: 'patient_age',
                        name: 'patient_age',
                        className: 'text-center',
                    },
                    {
                        data: 'station',
                        name: 'station',
                    },
                    {
                        data: 'status',
                        name: 'status',
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

        function initTable() {
            consultationTable = $('#pharmacyTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('consultation.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: 28
                    },
                    {
                        data: 'prescription_date',
                        name: 'prescription_date',
                    },
                    {
                        data: 'patient_name',
                        name: 'patient_name'
                    },
                    {
                        data: 'patient_birth_date',
                        name: 'patient_birth_date',
                    },
                    {
                        data: 'station',
                        name: 'station',
                    },
                    {
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                drawCallback: function() {
                    if (typeof hideLoader === "function") hideLoader();
                }
            });
        }
    </script>
@endsection
