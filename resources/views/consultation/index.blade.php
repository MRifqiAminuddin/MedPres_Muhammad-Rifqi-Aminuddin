@extends('layout.app')

@section('title', 'Konsultasi')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4 p-2">
                    <div class="card-header p-2">
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0">Pasien Hari Ini</h5>
                        </div>
                    </div>
                    <div class="card-body px-2 pt-0 pb-2">
                        <div class="table-responsive">
                            <table id="consultationTable" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pasien</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Keluhan</th>
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
        let consultationTable;

        $(document).ready(function() {
            initTable();
        });

        function initTable() {
            consultationTable = $('#consultationTable').DataTable({
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
                        data: 'patient_name'
                    },
                    {
                        data: 'patient_gender'
                    },
                    {
                        data: 'anamnesis'
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

        function refreshTable() {
            if (consultationTable) {
                consultationTable.ajax.reload(null, false);
            }
        }
    </script>
@endsection
