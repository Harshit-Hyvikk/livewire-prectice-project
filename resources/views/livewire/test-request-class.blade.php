<div>
    <!-- resources/views/livewire/user-form.blade.php -->
<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submit">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" wire:model="name" name="name">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" wire:model="email">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" class="form-control" wire:model="phone">
            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" wire:model="password">
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" class="form-control" wire:model="password_confirmation">
        </div> --}}

        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>
</div>
