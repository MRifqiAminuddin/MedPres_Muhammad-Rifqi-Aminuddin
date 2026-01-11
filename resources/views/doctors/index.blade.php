@extends('layout.app')

@section('title')
    Manajemen Dokter
@endsection

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4 p-2">
                    <div class="card-header p-2">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">All Document Type</h5>
                            </div>
                            @if (auth()->user()->hasPermission('Change Data Master'))
                                <button type="button" class="btn bg-gradient-primary btn-block mb-3" data-bs-toggle="modal"
                                    data-bs-target="#createDocumentTypeModal">
                                    <i class="fas fa-plus"></i>&nbsp;&nbsp;Create Document Type
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="card-body px-2 pt-0 pb-2">
                        <div class="table-responsive">
                            <table id="documentType-table" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Poli</th>
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
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            showAll();
        });

        function showAll() {
            // Jika DataTable sudah ada, hancurkan dulu
            if ($.fn.dataTable.isDataTable('#documentType-table')) {
                $('#documentType-table').DataTable().clear().destroy();
            }

            // Inisialisasi DataTables
            var table = $('#documentType-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('management.doctor.index') }}",
                columns: [{
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: 28,
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'station',
                        name: 'station'
                    },
                ],
                // Tambahkan event xhr di sini
                xhr: function() {
                    // Fungsi dipanggil setelah data selesai dimuat
                    hideLoader();
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
