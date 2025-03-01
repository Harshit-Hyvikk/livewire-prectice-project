<div>
    <!-- Bulk Actions -->
    <div class="mb-4 d-flex justify-content-between">
        <div class="d-flex align-items-center gap-4">
            @if(!empty($selectedRows))
                <button
                    wire:click="bulkDelete"
                    class="btn btn-danger"
                    onclick="confirm('Are you sure you want to delete these items?') || event.stopImmediatePropagation()"
                >
                    Delete Selected ({{ count($selectedRows) }})
                </button>

                <button
                    wire:click="export"
                    class="btn btn-success"
                >
                    Export Selected
                </button>
            @endif
        </div>

        <!-- Import Section -->
        <div class="d-flex align-items-center gap-4">
            <form wire:submit.prevent="import" class="d-flex align-items-center gap-2">
                <input
                    type="file"
                    wire:model="importFile"
                    class="form-control"
                    accept=".csv"
                >
                <button
                    type="submit"
                    class="btn btn-primary"
                    wire:loading.attr="disabled"
                >
                    Import
                </button>
            </form>
        </div>
    </div>

    <!-- Import Results -->
    @if(!empty($importResults))
        <div class="mb-4">
            <h3 class="fw-bold">Import Results:</h3>
            <p>Successful: {{ $importResults['success'] }}</p>
            <p>Failed: {{ $importResults['failed'] }}</p>
            @if(!empty($importResults['errors']))
                <div class="mt-2">
                    <h4 class="fw-bold text-danger">Errors:</h4>
                    <ul class="list-unstyled ps-4">
                        @foreach($importResults['errors'] as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endif

    <!-- Existing Table Code -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-light text-start">
                    <input
                        type="checkbox"
                        wire:model="selectAll"
                        class="form-check-input"
                    >
                </th>
                <!-- Your existing column headers -->
            </tr>
        </thead>
        <tbody class="table-light">
            @foreach($data as $row)
                <tr>
                    <td class="px-6 py-4">
                        <input
                            type="checkbox"
                            value="{{ $row->id }}"
                            wire:model="selectedRows"
                            class="form-check-input"
                        >
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
