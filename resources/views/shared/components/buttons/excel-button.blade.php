<form action="{{ $excelUrl }}" method="POST">
    @csrf
    <button class="btn excel-btn">
        <img src="{{ asset('assets/images/icon/excel.png') }}" alt="">
    </button>
</form>


