<form action="{{ $excelUrl }}" method="POST">
    @csrf
    @foreach ($conditionFields as $fieldName => $fieldValue)
        <input type="hidden" name="{{ $fieldName }}" value="{{ $fieldValue }}">
    @endforeach
    <button class="btn excel-btn">
        <img src="{{ asset('assets/images/icon/excel.png') }}" alt="">
    </button>
</form>
