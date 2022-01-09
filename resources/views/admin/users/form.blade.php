@csrf
<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" id="name"
           class="form-control @error('name') is-invalid @enderror"
           placeholder="Name"
           minlength="3"
           required
           value="{{ old('name', $user->name ?? '') }}">
    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="email">E-mail</label>
    <input type="email" name="email" id="email"
           class="form-control @error('email') is-invalid @enderror"
           placeholder="example@example.com"
           required
           value="{{ old('email', $user->email ?? '') }}">
    @error('email')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" id="password"
           class="form-control @error('password') is-invalid @enderror"
           placeholder="password"
           minlength="3"
           required
    @error('password')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="row ml-1 pt-2">
    <div class="form-group mr-5">
        <label for="active" class="form-check-label">Active</label>
        <input type="checkbox" name="active" id="active" value="active" class="form-check-input ml-4">
    </div>
    <div class="form-group ml-4">
        <label for="admin" class="form-check-label">Admin</label>
        <input type="checkbox" name="admin" id="admin" value="admin" class="form-check-input ml-4">
    </div>
</div>

<button type="submit" class="btn btn-success mt-4">Save user</button>
