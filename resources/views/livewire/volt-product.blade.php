<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Computed};
use App\Models\User;
use Livewire\WithPagination;

new #[Layout('layouts.app')] class extends Component {
    use WithPagination;
    #[Computed]
    public function showTodos()
    {
        return User::paginate(5);
    }
}; ?>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold">Users</h1>
    <div class="flex space-x-4 gap-5">
        <flux:select placeholder="Choose industry..." class=" max-w-48 border border-gray-700">
            <flux:select.option>Photography</flux:select.option>
            <flux:select.option>Design services</flux:select.option>
            <flux:select.option>Web development</flux:select.option>
            <flux:select.option>Accounting</flux:select.option>
            <flux:select.option>Legal services</flux:select.option>
            <flux:select.option>Consulting</flux:select.option>
            <flux:select.option>Other</flux:select.option>
        </flux:select>
        <flux:textarea rows="2" label="Note"
            class="bg-zinc-800 dark:bg-zinc-400 hover:bg-zinc-700 dark:hover:bg-zinc-300" />


        <flux:modal.trigger name="edit-profile">
            <flux:button>Edit profile</flux:button>
        </flux:modal.trigger>

        <flux:modal name="edit-profile" class="md:w-96">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Update profile</flux:heading>
                    <flux:subheading>Make changes to your personal details.</flux:subheading>
                </div>

                <flux:input label="Name" placeholder="Your name" />

                <flux:input label="Date of birth" type="date" />

                <div class="flex">
                    <flux:spacer />

                    <flux:button type="submit" variant="primary">Save changes</flux:button>
                </div>
            </div>
        </flux:modal>
    </div>

    <div class="flex justify-end">




        {{-- <a href="{{ route('volt.create') }}"
            class="border border-indigo-500 px-5 py-2 rounded-md bg-indigo-500 text-white">
            Create User
        </a> --}}
        <table class="table-auto w-full">
            <thead>
                <tr class="bg-gray-500 text-white">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->showTodos as $todo)
                    <tr class="border-b border-indigo-500">
                        <td class="px-4 py-2">{{ $todo->id }}</td>
                        <td class="px-4 py-2">{{ $todo->name }}</td>
                        <td class="px-4 py-2">{{ $todo->email }}</td>
                        <td class="px-4 py-2">
                            <button wire:click="deleteTodo({{ $todo->id }})"
                                class="border border-red-500 px-5 rounded-md bg-red-300 text-white">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $this->showTodos->links('vendor.pagination.custome') }}
</div>
