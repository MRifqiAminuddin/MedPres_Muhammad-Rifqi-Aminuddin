@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    @if (auth()->user() && auth()->user()->hasPermission('Read License'))
        <div>
            <!-- Konten untuk pengguna dengan permission 'license' -->
            <p>Anda memiliki izin untuk mengakses License.</p>
        </div>
    @else
        <p>Anda tidak memiliki izin untuk mengakses License.</p>
    @endif
    <div class="row mt-4 d-flex">
        <div class="col-lg-6 col-md-12 col-12 h-100 mb-lg-4 mb-4">
            <div class="card z-index-2">
                <div class="card-header pb-0">
                    <h6>Field</h6>
                    <p class="text-sm">
                        <i class="fas fa-chart-pie text-info"></i>
                        <span class="font-weight-bold">Showing licenses per field</span> in {{ date('d-m-Y H:i:s') }}
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="pieChartField" class="chart-canvas" height="300px"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-12 h-100 mb-lg-4 mb-4">
            <div class="card z-index-2">
                <div class="card-header pb-0">
                    <div class="row">
                        <h6 class="col-12 col-md-6 col-lg-8">Categories</h6>
                        <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-end" id="btnCloseCategory"
                            style="display: none!important">
                            <button class="btn bg-gradient-danger btn-block mb-3" type="button"
                                onclick="hideCategory(this)">
                                <i class="fa-solid fa-x text-white"></i>&nbsp;&nbsp;Close
                            </button>
                        </div>
                    </div>
                    <p class="text-sm">
                        <i class="fas fa-chart-pie text-info"></i>
                        <span class="font-weight-bold">Showing licenses per categories</span> in
                        {{ date('d-m-Y H:i:s') }}
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <h5 class="text-dark" id="selectFirst" style="height: 300px">
                            <center>
                                <b>
                                    Select a slice on Chart Field beside first!
                                </b>
                            </center>
                        </h5>
                        <canvas id="pieChartCategory" class="chart-canvas" height="300px" style="display: none"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-12 h-100 mb-lg-4 mb-4">
            <div class="card z-index-2">
                <div class="card-header pb-0">
                    <h6>Document Type</h6>
                    <p class="text-sm">
                        <i class="fas fa-chart-pie text-info"></i>
                        <span class="font-weight-bold">Showing licenses per document type</span> in
                        {{ date('d-m-Y H:i:s') }}
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="pieChartDocumentType" class="chart-canvas" height="300px"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-12 h-100 mb-lg-4 mb-4">
            <div class="card z-index-2">
                <div class="card-header pb-0">
                    <h6>Will end in 1 year</h6>
                    <p class="text-sm">
                        <i class="fas fa-chart-pie text-info"></i>
                        <span class="font-weight-bold">Displays licenses that will expire </span> until
                        {{ date('d-m-Y H:i:s', strtotime('+11 month', strtotime(date('d-m-Y H:i:s')))) }}
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="lineChartExpire" class="chart-canvas" height="300px"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-12 h-100 mb-lg-4 mb-4">
            <div class="card z-index-2">
                <div class="card-header pb-0">
                    <h6>Expired date</h6>
                    <p class="text-sm">
                        <i class="fas fa-chart-pie text-info"></i>
                        <span class="font-weight-bold">Showing licenses with nearest exp date</span> until
                        {{ date('d-m-Y H:i:s', strtotime('+11 month', strtotime(date('d-m-Y H:i:s')))) }}
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table id="tableExpire" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Remember Date</th>
                                    <th>Process Date</th>
                                    <th>End Date</th>
                                    <th style="text-align: center!important">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <a class="btn bg-gradient-primary" href="#">
                        <i class="fa-solid fa-angles-right"></i>&nbsp;&nbsp;Details
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @section('js')
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            showLoader();
            let pieChartField;
            let pieChartCategory;
            let pieChartDocumentType;
            let lineChartExpire;
            let done = 0;

            chartField();
            chartFieldData();
            chartDocumentType();
            chartDocumentTypeData();
            chartExpire();
            chartExpireData();
            tableExpire();

            // Fungsi untuk menghasilkan warna acak
            function getRandomColor() {
                const letters = '0123456789ABCDEF';
                let color = '#';
                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }

            // Chart field
            function chartField() {
                // Pie Chart Field
                var chartField = document.getElementById("pieChartField").getContext("2d");

                if (pieChartField) {
                    pieChartField.destroy();
                }

                // Buat chart kosong
                pieChartField = new Chart(chartField, {
                    type: "polarArea",
                    data: {
                        labels: [], // Awalnya kosong
                        datasets: [{
                            label: "Projects",
                            data: [], // Awalnya kosong
                            borderWidth: 1, // Border di sekitar setiap slice
                            backgroundColor: [], // Akan diisi dengan warna acak
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw + ' Document';
                                    }
                                }
                            }
                        },
                        onClick: function(event, elements) {
                            if (elements.length > 0) {
                                // Ambil indeks elemen yang diklik
                                const index = elements[0].index;

                                // Ambil label berdasarkan indeks
                                const label = this.data.labels[index];
                                const identity = this.data.identitys[index];

                                // Tampilkan di console
                                chartCategory();
                                chartCategoryData(identity);
                            }
                        }
                    }
                });
            }

            function chartFieldData() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });

                $.ajax({
                    url: "{{ route('dashboard.chart.field') }}",
                    method: "POST",
                    dataType: "json",
                   success: function(response) {
                        // Validasi respons
                        if (response && response.data.labels && response.data.datas) {
                            const randomColors = response.data.labels.map(() => getRandomColor());

                            // Update data chart
                            pieChartField.data.labels = response.data.labels;
                            pieChartField.data.identitys = response.data.identitys;
                            pieChartField.data.datasets[0].data = response.data.datas;
                            pieChartField.data.datasets[0].backgroundColor = randomColors;

                            // Update chart
                            pieChartField.update();
                            done = done + 1;
                            hideLoad();
                        } else {
                            console.error("Respons API tidak sesuai format yang diharapkan");
                        }
                    },
                    error: function(error) {
                        console.error("Error fetching data:", error);
                    }
                });
            }

            // Chart category
            function chartCategory() {
                showLoader();
                // Pie Chart Category
                var chartCategory = document.getElementById("pieChartCategory").getContext("2d");

                if (pieChartCategory) {
                    pieChartCategory.destroy();
                }

                // Buat chart kosong
                pieChartCategory = new Chart(chartCategory, {
                    type: "polarArea",
                    data: {
                        labels: [], // Awalnya kosong
                        datasets: [{
                            label: "Projects",
                            data: [], // Awalnya kosong
                            borderWidth: 1, // Border di sekitar setiap slice
                            backgroundColor: [], // Akan diisi dengan warna acak
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw + ' Document';
                                    }
                                }
                            }
                        },
                        onClick: function(event, elements) {
                            if (elements.length > 0) {
                                // Ambil indeks elemen yang diklik
                                const index = elements[0].index;

                                // Ambil label berdasarkan indeks
                                const label = this.data.labels[index];
                                const identity = this.data.identitys[index];
                            }
                        }
                    }
                });
            }

            function chartCategoryData(identity) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });

                $.ajax({
                    url: "{{ route('dashboard.chart.category', 'harusGanti') }}".replace('harusGanti',
                        identity),
                    method: "POST",
                    dataType: "json",
                   success: function(response) {
                        // Validasi respons
                        if (response && response.data.labels && response.data.datas) {
                            const randomColors = response.data.labels.map(() => getRandomColor());

                            // Update data chart
                            pieChartCategory.data.labels = response.data.labels;
                            pieChartCategory.data.identitys = response.data.identitys;
                            pieChartCategory.data.datasets[0].data = response.data.datas;
                            pieChartCategory.data.datasets[0].backgroundColor = randomColors;

                            // Update chart
                            pieChartCategory.update();
                            document.getElementById('selectFirst').style.setProperty('display', 'none',
                                'important');
                            document.getElementById('pieChartCategory').style.setProperty('display',
                                'block', 'important');
                            document.getElementById('btnCloseCategory').style.setProperty('display',
                                'flex', 'important');

                            hideLoader();
                        } else {
                            console.error("Respons API tidak sesuai format yang diharapkan");
                        }
                    },
                    error: function(error) {
                        console.error("Error fetching data:", error);
                    }
                });
            }

            // Chart Document Type
            function chartDocumentType() {
                // Pie Chart Field
                var chartDocumentType = document.getElementById("pieChartDocumentType").getContext("2d");

                if (pieChartDocumentType) {
                    pieChartDocumentType.destroy();
                }

                // Buat chart kosong
                pieChartDocumentType = new Chart(chartDocumentType, {
                    type: "polarArea",
                    data: {
                        labels: [], // Awalnya kosong
                        datasets: [{
                            label: "Projects",
                            data: [], // Awalnya kosong
                            borderWidth: 1, // Border di sekitar setiap slice
                            backgroundColor: [], // Akan diisi dengan warna acak
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw + ' Document';
                                    }
                                }
                            }
                        },
                    }
                });
            }

            function chartDocumentTypeData() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });

                $.ajax({
                    url: "{{ route('dashboard.chart.document.type') }}",
                    method: "POST",
                    dataType: "json",
                   success: function(response) {
                        // Validasi respons
                        if (response && response.data.labels && response.data.datas) {
                            const randomColors = response.data.labels.map(() => getRandomColor());

                            // Update data chart
                            pieChartDocumentType.data.labels = response.data.labels;
                            pieChartDocumentType.data.identitys = response.data.identitys;
                            pieChartDocumentType.data.datasets[0].data = response.data.datas;
                            pieChartDocumentType.data.datasets[0].backgroundColor = randomColors;

                            // Update chart
                            pieChartDocumentType.update();
                            done = done + 1;
                            hideLoad();
                        } else {
                            console.error("Respons API tidak sesuai format yang diharapkan");
                        }
                    },
                    error: function(error) {
                        console.error("Error fetching data:", error);
                    }
                });
            }

            // Chart Expire
            function chartExpire() {
                // Line Chart Expire
                var chartExpire = document.getElementById("lineChartExpire").getContext("2d");

                if (lineChartExpire) {
                    lineChartExpire.destroy();
                }

                // Buat chart kosong
                lineChartExpire = new Chart(chartExpire, {
                    type: "line",
                    data: {
                        labels: [], // Awalnya kosong
                        datasets: [{
                                label: "Unfinished",
                                data: [], // Awalnya kosong
                                borderWidth: 1, // Border di sekitar setiap slice
                                tension: 0.4,
                                borderWidth: 0,
                                pointRadius: 2,
                                pointBackgroundColor: "#FF0000",
                                borderColor: "#FF0000",
                                borderWidth: 3,
                                backgroundColor: '#FF0000',
                                maxBarThickness: 6
                            },
                            {
                                label: "Finished",
                                data: [], // Awalnya kosong
                                borderWidth: 1, // Border di sekitar setiap slice
                                tension: 0.4,
                                borderWidth: 0,
                                pointRadius: 2,
                                pointBackgroundColor: "#00FF00",
                                borderColor: "#00FF00",
                                borderWidth: 3,
                                backgroundColor: '#00FF00',
                                maxBarThickness: 6
                            }, {
                                label: "Total",
                                data: [], // Awalnya kosong
                                borderWidth: 1, // Border di sekitar setiap slice
                                tension: 0.4,
                                borderWidth: 0,
                                pointRadius: 2,
                                pointBackgroundColor: "#0000FF",
                                borderColor: "#0000FF",
                                borderWidth: 3,
                                backgroundColor: '#0000FF',
                                maxBarThickness: 6
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                enabled: true,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.raw !== null) {
                                            label += context.raw + ' document';
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        scales: {
                            y: {
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    drawOnChartArea: true,
                                    drawTicks: false,
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    display: true,
                                    padding: 10,
                                    color: '#b2b9bf',
                                    font: {
                                        size: 11,
                                        family: "Open Sans",
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                }
                            },
                            x: {
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    drawOnChartArea: true,
                                    drawTicks: true,
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    display: true,
                                    color: '#b2b9bf',
                                    padding: 10,
                                    font: {
                                        size: 11,
                                        family: "Open Sans",
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                }
                            },
                        },

                    }
                });
            }

            function chartExpireData() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });

                $.ajax({
                    url: "{{ route('dashboard.chart.expire') }}",
                    method: "POST",
                    dataType: "json",
                   success: function(response) {
                        // Validasi respons
                        if (response && response.data.labels) {
                            // Update data chart
                            lineChartExpire.data.labels = response.data.labels;
                            lineChartExpire.data.datasets[0].data = response.data.unfinished;
                            lineChartExpire.data.datasets[1].data = response.data.finished;
                            lineChartExpire.data.datasets[2].data = response.data.total;

                            // Update chart
                            lineChartExpire.update();
                            done = done + 1;
                            hideLoad();
                        } else {
                            console.error("Respons API tidak sesuai format yang diharapkan");
                        }
                    },
                    error: function(error) {
                        console.error("Error fetching data:", error);
                    }
                });
            }

            // Table Expire
            function tableExpire() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
                // Jika DataTable sudah ada, hancurkan dulu
                if ($.fn.dataTable.isDataTable('#tableExpire')) {
                    $('#tableExpire').DataTable().clear().destroy();
                }

                // Inisialisasi DataTables
                var table = $('#tableExpire').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('dashboard.table.expire') }}",
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        error: function(xhr, error, thrown) {
                            console.error('Error loading data:', error);
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            width: 28
                        },
                        {
                            data: 'name_en',
                            name: 'name_en'
                        },
                        {
                            data: 'remember_date',
                            name: 'remember_date'
                        },
                        {
                            data: 'process_start_date',
                            name: 'process_start_date'
                        },
                        {
                            data: 'end_date',
                            name: 'end_date'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                   success: function(response) {
                        done = done + 1;
                        hideLoad();
                    },
                    createdRow: function(row, data, dataIndex) {
                        if (data.status === 'Unfinished') {
                            $(row).addClass('bg-gradient-danger text-white');
                        } else if (data.status === 'Finished') {
                            $(row).addClass('bg-gradient-success text-white');
                        }
                    }
                });
            }

            function hideLoad() {
                if (done >= 3) {
                    hideLoader();
                }
            }
        });

        function hideCategory(button) {
            document.getElementById('selectFirst').style.setProperty('display', 'block', 'important');
            document.getElementById('pieChartCategory').style.setProperty('display', 'none', 'important');
            document.getElementById('btnCloseCategory').style.setProperty('display', 'none', 'important');
        }

        // window.onload = function() {


        //     // Pie chart
        //     var ctx42 = document.getElementById("pie-chart2").getContext("2d");
        //     new Chart(ctx42, {
        //         type: "pie",
        //         data: {
        //             labels: ['Facebook', 'Direct', 'Organic', 'Referral'],
        //             datasets: [{
        //                 label: "Projects",
        //                 weight: 9,
        //                 cutout: 0,
        //                 tension: 0.9,
        //                 pointRadius: 2,
        //                 borderWidth: 2,
        //                 backgroundColor: ['#17c1e8', '#e3316e', '#3A416F', '#a8b8d8'],
        //                 data: [15, 20, 12, 60],
        //                 fill: false
        //             }],
        //         },
        //         options: {
        //             responsive: true,
        //             maintainAspectRatio: false,
        //             plugins: {
        //                 legend: {
        //                     display: false,
        //                 }
        //             },
        //             interaction: {
        //                 intersect: false,
        //                 mode: 'index',
        //             },
        //             scales: {
        //                 y: {
        //                     grid: {
        //                         drawBorder: false,
        //                         display: false,
        //                         drawOnChartArea: false,
        //                         drawTicks: false,
        //                     },
        //                     ticks: {
        //                         display: false
        //                     }
        //                 },
        //                 x: {
        //                     grid: {
        //                         drawBorder: false,
        //                         display: false,
        //                         drawOnChartArea: false,
        //                         drawTicks: false,
        //                     },
        //                     ticks: {
        //                         display: false,
        //                     }
        //                 },
        //             },
        //         },
        //     });

        //     // Pie chart
        //     var ctx43 = document.getElementById("pie-chart3").getContext("2d");
        //     new Chart(ctx43, {
        //         type: "pie",
        //         data: {
        //             labels: ['Facebook', 'Direct', 'Organic', 'Referral'],
        //             datasets: [{
        //                 label: "Projects",
        //                 weight: 9,
        //                 cutout: 0,
        //                 tension: 0.9,
        //                 pointRadius: 2,
        //                 borderWidth: 2,
        //                 backgroundColor: ['#17c1e8', '#e3316e', '#3A416F', '#a8b8d8'],
        //                 data: [15, 20, 12, 60],
        //                 fill: false
        //             }],
        //         },
        //         options: {
        //             responsive: true,
        //             maintainAspectRatio: false,
        //             plugins: {
        //                 legend: {
        //                     display: false,
        //                 }
        //             },
        //             interaction: {
        //                 intersect: false,
        //                 mode: 'index',
        //             },
        //             scales: {
        //                 y: {
        //                     grid: {
        //                         drawBorder: false,
        //                         display: false,
        //                         drawOnChartArea: false,
        //                         drawTicks: false,
        //                     },
        //                     ticks: {
        //                         display: false
        //                     }
        //                 },
        //                 x: {
        //                     grid: {
        //                         drawBorder: false,
        //                         display: false,
        //                         drawOnChartArea: false,
        //                         drawTicks: false,
        //                     },
        //                     ticks: {
        //                         display: false,
        //                     }
        //                 },
        //             },
        //         },
        //     });
        // }
    </script>
@endsection --}}
