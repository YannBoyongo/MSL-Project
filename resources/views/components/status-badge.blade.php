@props([
    'status',
    'type' => 'claim',
])

@php
    use App\Enums\BorderStatus;
    use App\Enums\ClaimStatus;

    $value = $status instanceof ClaimStatus || $status instanceof BorderStatus
        ? $status->value
        : (string) $status;

    $label = $status instanceof ClaimStatus || $status instanceof BorderStatus
        ? $status->label()
        : (string) $status;

    $claimStyles = [
        ClaimStatus::Submitted->value => 'bg-blue-50 text-blue-700 ring-blue-600/20',
        ClaimStatus::UnderReview->value => 'bg-amber-50 text-amber-700 ring-amber-600/20',
        ClaimStatus::Pending->value => 'bg-orange-50 text-orange-700 ring-orange-600/20',
        ClaimStatus::Resolved->value => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        ClaimStatus::Rejected->value => 'bg-red-50 text-red-700 ring-red-600/20',
        ClaimStatus::Closed->value => 'bg-gray-100 text-gray-600 ring-gray-500/20',
    ];

    $borderStyles = [
        BorderStatus::Open->value => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        BorderStatus::Restricted->value => 'bg-amber-50 text-amber-700 ring-amber-600/20',
        BorderStatus::TemporarilyClosed->value => 'bg-orange-50 text-orange-700 ring-orange-600/20',
        BorderStatus::Closed->value => 'bg-red-50 text-red-700 ring-red-600/20',
    ];

    $styles = $type === 'border' ? $borderStyles : $claimStyles;
    $class = $styles[$value] ?? 'bg-gray-100 text-gray-600 ring-gray-500/20';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {$class}"]) }}>
    {{ $label }}
</span>
