@php
    /** @var \App\Models\Property|null $record */
    $summary = $record?->availabilitySummary() ?? [
        'has_plots' => false,
        'total' => 0,
        'available' => 0,
        'reserved' => 0,
        'sold' => 0,
    ];
@endphp

<div class="rounded-xl border border-gray-200 bg-gray-50 p-4 text-sm text-gray-700 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
  @if ($summary['has_plots'])
    <p class="font-medium text-gray-950 dark:text-white">
      {{ $summary['total'] }} plots in this development
    </p>
    <p class="mt-1">
      {{ $summary['available'] }} available · {{ $summary['sold'] }} sold
      @if ($summary['reserved'] > 0)
        · {{ $summary['reserved'] }} reserved
      @endif
    </p>
    <p class="mt-3 text-gray-600 dark:text-gray-400">
      Use <strong>Quick generate</strong> above to rebuild the full inventory. Open the <strong>Plot list</strong> tab to edit individual plots in a paginated table.
    </p>
  @else
    <p>No plots yet. Use <strong>Quick generate</strong> above to create the inventory.</p>
  @endif
</div>
