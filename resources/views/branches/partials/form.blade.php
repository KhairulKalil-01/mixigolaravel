
<form action="{{ $action }}" method="POST">
    @csrf

    @if($method === 'PUT')
        @method('PUT')
    @endif

    <div class="form-group">
        <label class="form-label">Branch Name </label>
        <input class="form-control" type="text" name="branch_name" value="{{ old('branch_name', $branch->branch_name ?? '') }}" placeholder="Name">
    </div>
    <div class="form-group">
        <label class="form-label">City</label>
        <input class="form-control" type="text" name="city" value="{{ old('city', $branch->city ?? '') }}" placeholder="City">
    </div>
    <div class="form-group">
        <label class="form-label">State</label>
        <input class="form-control" type="text" name="state" value="{{ old('state', $branch->state ?? '') }}" placeholder="State">
    </div>
    <div class="form-group">
        <label class="form-label">Address</label>
        <input class="form-control" type="text" name="address" value="{{ old('address', $branch->address ?? '') }}" placeholder="Address">
    </div>
    <div class="form-group">
        <label class="form-label">Phone number</label>
        <input class="form-control" type="text" name="mobileno" value="{{ old('mobileno', $branch->mobileno ?? '') }}" placeholder="Phone">
    </div>
    <div class="form-group">
        <label class="form-label">Email</label>
        <input class="form-control" type="email" name="email" value="{{ old('email', $branch->email ?? '') }}" placeholder="Email">
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
</form>