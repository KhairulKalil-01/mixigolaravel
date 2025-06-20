
<form action="{{ $action }}" method="POST">
    @csrf

    @if($method === 'PUT')
        @method('PUT')
    @endif

    <div class="form-group">
        <label class="form-label">Designation Name </label>
        <input class="form-control" type="text" name="designation_name" value="{{ old('designation_name', $designation->designation_name ?? '') }}" placeholder="Name">
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
</form>