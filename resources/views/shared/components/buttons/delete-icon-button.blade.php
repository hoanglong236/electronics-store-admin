<form method="post" action="{{ $deleteUrl }}" onsubmit="return confirm('Are you sure?');">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-danger icon-btn">
        <i class="fa fa-trash-o"></i>
    </button>
</form>
