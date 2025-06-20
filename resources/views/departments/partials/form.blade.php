
<form action="{{ $action }}" method="POST">
    @csrf

    @if($method === 'PUT')
        @method('PUT')
    @endif

    <div class="form-group">
        <label class="form-label">Department Name </label>
        <input class="form-control" type="text" name="department_name" value="{{ old('department_name', $department->department_name ?? '') }}" placeholder="Name">
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
</form>