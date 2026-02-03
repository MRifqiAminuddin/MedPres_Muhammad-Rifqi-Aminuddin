@if (request()->routeIs('encounter.index'))
    <center>
        <button class="btn bg-gradient-success" onclick="showEdit('{{ $identity }}')">
            <i class="fa-solid fa-pencil text-white"></i>
        </button>
        <button class="btn bg-gradient-secondary"
            onclick="showConfirm('{{ addslashes($name) }}', '{{ $identity }}', 'Anda ingin memanggil {{ addslashes($name) }}?', call)">
            <i class="fa-solid fa-bullhorn text-white"></i>
            Panggil
        </button>
    </center>
@elseif(request()->routeIs('encounter.search.patient') || request()->routeIs('encounter.search.doctor'))
    <center>
        <button class="btn bg-gradient-info"
            onclick="selectUser('{{ $mode }}', '{{ $name }}', '{{ $identity }}')">
            <i class="fa-solid fa-check text-white"></i>
            Pilih
        </button>
    </center>
@elseif(request()->routeIs('consultation.index') || request()->routeIs('consultation.history'))
    <center>
        <button class="btn bg-gradient-primary"
            onclick="window.location.href = '{{ route('consultation.detail', $identity) }}';">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            {{ request()->routeIs('consultation.index') ? 'Periksa' : 'Ubah' }}
        </button>
    </center>
@elseif(request()->routeIs('consultation.medicine.list'))
    <center>
        <button class="btn bg-gradient-primary" onclick="selectMedicine('{{ $id }}', '{{ $name }}')">
            <i class="fa-solid fa-check text-white"></i>
            Pilih
        </button>
    </center>
@elseif(request()->routeIs('pharmacy.index'))
    <center>
        @if ($pharmacy_id == null)
            <button class="btn bg-gradient-primary" onclick="showTask('{{ $identity }}', 'pick')">
                <i class="fa-solid fa-mortar-pestle text-white"></i>
                Racik Obat
            </button>
        @endif
    </center>
@elseif(request()->routeIs('pharmacy.history'))
    <center>
        <button class="btn bg-gradient-primary"
            onclick="window.open('{{ route('pharmacy.receipt', $identity) }}', '_blank');">
            <i class="fa-solid fa-print text-white"></i>
            Cetak Kwitansi
        </button>
    </center>
@else
    <center>
        <button class="btn bg-gradient-success" onclick="showEdit('{{ $identity }}')">
            <i class="fa-solid fa-pencil text-white"></i>
        </button>

        <button class="btn bg-gradient-danger" onclick="alertDelete('{{ $name }}', '{{ $identity }}')">
            <i class="fa-solid fa-trash text-white"></i>
        </button>
    </center>
@endif
