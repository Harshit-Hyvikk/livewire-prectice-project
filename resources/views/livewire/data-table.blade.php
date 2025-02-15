<div class="rounded  bg-gray-50 dark:bg-gray-900" >



    @php
        // dd( $this->table->getRecords(),$getStates());
        // $this->table;
    @endphp
    {{ $this->table }}

    <x-filament::dropdown.index placement="bottom-end" teleport :width="'sm'" :size="true" :maxHeight="'300px'"
        :offset="'10'">
        <!-- Trigger (passed as a slot) -->
        <x-slot name="trigger">
            <x-filament::button>Open Dropdown</x-filament::button>
        </x-slot>

        <!-- Dropdown content -->
        <div class="p-4">

            <x-filament-panels::theme-switcher.index />

        </div>
    </x-filament::dropdown.index>
    @push('script')
    {{-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script> --}}

    @endpush
</div>
