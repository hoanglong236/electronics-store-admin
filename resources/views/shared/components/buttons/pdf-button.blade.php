<form action="{{ $pdfUrl }}" method="POST">
    @csrf
    @foreach ($conditionFields as $fieldName => $fieldValue)
        <input type="hidden" name="{{ $fieldName }}" value="{{ $fieldValue }}">
    @endforeach
    <button class="btn export-btn">
        <img src="{{ asset('assets/images/icon/pdf.png') }}" alt="">
    </button>
</form>
