<center>
    <button class="btn bg-gradient-success"
        onclick="showEdit('{{ $identity }}')">
        <i class="fa-solid fa-pencil text-white"></i>
    </button>

    <button class="btn bg-gradient-danger"
        onclick="alertDelete('{{ $name }}', '{{ $identity }}')">
        <i class="fa-solid fa-trash text-white"></i>
    </button>
</center>
