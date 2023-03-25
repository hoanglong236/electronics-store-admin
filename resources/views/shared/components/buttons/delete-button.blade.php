<form method="post" action="{{ $deleteUrl }}" onsubmit="return confirm('Are you sure?');">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-danger btn-sm">
        <i class="fa fa-trash-o"></i> Delete
    </button>
</form>
