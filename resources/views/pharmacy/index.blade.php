@extends('layout.app')

@section('title', 'Farmasi')

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

            <div class="col-12">
                <div class="card mb-4 mx-4 p-2">
                    <div class="card-header p-2">
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0">Riwayat Pelayanan Obat</h5>
                        </div>
                    </div>
                    <div class="card-body px-2 pt-0 pb-2">
                        <div class="table-responsive">
                            <table id="historyMedicineTable" class="table align-items-center mb-0">
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

    <div class="modal fade" id="modalCheckPrescription" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <!-- HEADER -->
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title mb-1">Cek Resep</h5>
                        <div class="small text-muted">
                            <span id="modalPatientName">-</span> •
                            Umur <span id="modalPatientAge">-</span> Tahun •
                            ID <span id="modalPrescriptionIdentity">-</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered align-middle">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th style="width:40px">✓</th>
                                    <th class="text-start">Nama Obat</th>
                                    <th>Qty</th>
                                    <th>Dosis</th>
                                    <th>Aturan</th>
                                    <th class="text-end">Harga</th>
                                </tr>
                            </thead>
                            <tbody id="modalMedicineList">
                                <!-- diisi via JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer justify-content-between">
                    <div class="fw-bold fs-5">
                        Total:
                        <span id="modalTotalPrice">Rp 0</span>
                    </div>
                    <button class="btn btn-success" id="btnPayPrescription">
                        Bayar
                    </button>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            showTask('tanpaidentity', 'show');
            showAll();
            historyMedicine();
        });

        let task = new Set();

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
                        data: 'prescription_date_formated',
                        name: 'prescription_date_formated',
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

        function historyMedicine() {
            // Jika DataTable sudah ada, hancurkan dulu
            if ($.fn.dataTable.isDataTable('#pharmacyTable')) {
                $('#pharmacyTable').DataTable().clear().destroy();
            }

            // Inisialisasi DataTables
            var table = $('#pharmacyTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('pharmacy.history') }}",
                columns: [{
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: 28,
                    },
                    {
                        data: 'prescription_date_formated',
                        name: 'prescription_date_formated',
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

        function showTask(identity, mode) {
            if (mode == "pick") {
                showLoader()
            }
            task.add(identity);

            console.log(mode);

            const container = document.getElementById('divTaskList');
            // container.innerHTML = "";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $.ajax({
                url: "{{ route('pharmacy.show', 'harusGanti') }}".replace('harusGanti', identity),
                type: 'POST',
                data: {
                    mode: mode
                },
                success: function(response) {
                    const datas = response.data;

                    datas.forEach(data => {
                        const header = `
                            <div class="card task-card shadow-sm position-relative" id="${data.identity}">
                                <div class="text-end p-2">
                                    <button type="button"
                                        class="btn btn-sm btn-danger btn-close-task text-white mb-0"
                                        style="width: 10px!important" onclick="clickCancel('${data.patient_name}','${data.identity}')">
                                        &times;
                                    </button>
                                </div>

                                <div class="card-body py-0">
                                    <div class="mb-3 border-bottom pb-2">
                                        <h6 class="mb-0 fw-bold">${data.patient_name}</h6>
                                        <small class="text-muted">Umur: ${data.patient_age} Tahun</small>
                                        <input type="hidden" name="identity" value="${data.identity}">
                                    </div>
                                    <div class="medicine-list">
                                `;

                        let detail = '';
                        data.medicines.forEach(medicine => {
                            detail += `
                                        <div class="mb-2 p-2 rounded bg-light">
                                            <div class="fw-semibold">${medicine.name}</div>
                                            <small class="text-muted">
                                               ${medicine.qty} pcs • ${medicine.dosage} • ${medicine.rule}
                                            </small>
                                        </div>
                                        `;
                        });

                        const footer = `
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-0 text-end py-0 px-2" style="height: 43px;">
                                    <button class="btn btn-sm btn-success mt-1"
                                        onclick="doneMixed('${data.identity}')">
                                        Selesai
                                    </button>
                                </div>
                            </div>
                        `;

                        const html = header + detail + footer;
                        container.insertAdjacentHTML('beforeend', html);
                        showAll();
                        if (mode == "pick") {
                            hideLoader()
                        }
                    });
                },
                error: function(xhr) {
                    fail(xhr.responseJSON?.message || 'Server tidak merespons');
                    hideLoader();
                }
            });
        }

        function clickCancel(name, identity) {
            Swal.fire({
                title: "Konfirmasi!",
                html: "Batal meracik resep <b>" + name + "</b>?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Tidak",
                confirmButtonText: "Ya, Batal!"
            }).then((result) => {
                if (result.isConfirmed) {
                    cancelTask(identity);
                }
            });
        }

        function cancelTask(identity) {
            showLoader();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $.ajax({
                url: "{{ route('pharmacy.cancel', 'harusGanti') }}".replace('harusGanti', identity),
                type: 'POST',
                success: function(response) {
                    success("Berhasil membatalkan tugas");
                    // showTask('tanpaidentity', 'show');
                    document.getElementById(identity).remove();
                    console.log('setelah dicancel');
                    showAll();
                    hideLoader();
                },
                error: function(xhr) {
                    fail(xhr.responseJSON?.message || 'Server tidak merespons');
                }
            });
        }

        function doneMixed(identity) {
            showLoader();
            const tbody = document.getElementById('modalMedicineList');
            tbody.innerHTML = "";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $.ajax({
                url: "{{ route('pharmacy.show', 'harusGanti') }}".replace('harusGanti', identity),
                type: 'POST',
                data: {
                    mode: "done"
                },
                success: function(response) {
                    const datas = response.data;

                    datas.forEach(data => {
                        document.getElementById('modalPatientName').textContent = data.patient_name;
                        document.getElementById('modalPatientAge').textContent = data.patient_age;
                        document.getElementById('modalPrescriptionIdentity').textContent = data
                            .identity;
                        data.medicines.forEach(medicine => {
                            const html = `
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox"
                                                class="form-check-input medicine-check"
                                                data-price="${medicine.price}"
                                                data-id="${medicine.id}"
                                                data-qty="${medicine.qty}">
                                        </td>
                                        <td>
                                            <strong>${medicine.name}</strong>
                                        </td>
                                        <td class="text-center">${medicine.qty}</td>
                                        <td class="text-center">${medicine.dosage}</td>
                                        <td class="text-center">${medicine.rule}</td>
                                        <td class="text-end">
                                            Rp ${Number(medicine.price).toLocaleString('id-ID')}
                                        </td>
                                    </tr>
                                `;
                            tbody.insertAdjacentHTML('beforeend', html);
                        });
                    });


                    const modal = new bootstrap.Modal(
                        document.getElementById('modalCheckPrescription')
                    );
                    hideLoader();
                    modal.show();
                },
                error: function(xhr) {
                    fail(xhr.responseJSON?.message || 'Server tidak merespons');
                }
            });
        };


        function updateTotalPrice() {
            let total = 0;

            document.querySelectorAll('.medicine-check:checked').forEach(cb => {
                const price = Number(cb.dataset.price);
                const qty = Number(cb.dataset.qty);

                if (isNaN(price) || isNaN(qty)) {
                    console.error('Invalid price or qty', cb);
                    return;
                }

                total += price * qty;
            });

            document.getElementById('modalTotalPrice').textContent =
                'Rp ' + total.toLocaleString('id-ID');
        }

        document.addEventListener('change', function(e) {
            if (!e.target.classList.contains('medicine-check')) return;
            updateTotalPrice();
        });


        $('#btnPayPrescription').on('click', function() {
            const selectedMedicines = [];
            $('.medicine-check:checked').each(function() {
                selectedMedicines.push($(this).data('id'));
            });

            if (selectedMedicines.length === 0) {
                alert('Pilih minimal satu obat untuk dibayar');
                return;
            }

            const identity = $('#modalPrescriptionIdentity').text().trim();;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $.ajax({
                url: "{{ route('pharmacy.pay', 'harusGanti') }}".replace('harusGanti', identity),
                type: 'POST',
                data: {
                    medicine_ids: selectedMedicines
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    const blob = new Blob([response], {
                        type: 'application/pdf'
                    });
                    const url = window.URL.createObjectURL(blob);

                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'Faktur_Pembelian_Obat.pdf';
                    document.body.appendChild(a);
                    a.click();

                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(url);
                },
                error: function(xhr) {
                    const errorMsg = xhr.responseJSON?.message || 'Server tidak merespons';
                    alert('Gagal: ' + errorMsg);
                    console.error('Detail Error:', xhr.responseText);
                }
            });
        });
    </script>
@endsection
