<form method="post" action="{{ $deleteUrl }}" onsubmit="return confirm('Are you sure?');">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-danger text-btn--medium">
        <i class="fa fa-trash-o"></i> Delete
    </button>
</form>
