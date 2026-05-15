@extends('layouts.app')
@section('content')
<section class="section-padding">
    <div class="container-site max-w-3xl">
        <h1 class="text-4xl">Referrals & loyalty program</h1>
        <p class="mt-6 text-muted">{{ $settings->referral_program }}</p>
        <div class="card mt-8">
            <h2 class="font-serif text-xl">How it works</h2>
            <ol class="mt-4 list-decimal space-y-2 pl-5 text-sm text-muted">
                <li>Refer a friend or family member to Acremann Properties.</li>
                <li>They complete a plot purchase on any active project.</li>
                <li>You receive a loyalty reward — discounts on future purchases or referral bonuses.</li>
            </ol>
        </div>
        <a href="{{ route('contact') }}" class="btn-primary mt-8 inline-flex">Start referring</a>
    </div>
</section>
@endsection
