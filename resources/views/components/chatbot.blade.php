@props(['settings'])
@php $faqs = \App\Models\Faq::published()->take(8)->get(); @endphp
<div x-data="chatbot()" class="fixed bottom-4 left-4 z-50 md:bottom-8">
    <button @click="open = !open" class="flex h-12 w-12 items-center justify-center rounded-full bg-forest text-white shadow-lg" aria-label="Chat assistant">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
    </button>
    <div x-show="open" x-cloak class="absolute bottom-14 left-0 w-80 rounded-sm border border-charcoal/10 bg-white shadow-xl">
        <div class="border-b border-charcoal/10 p-4">
            <p class="font-serif text-lg">Acremann Assistant</p>
            <p class="text-xs text-muted">How can we help you today?</p>
        </div>
        <div class="max-h-72 overflow-y-auto p-4 space-y-2" x-show="step === 'menu'">
            <button @click="step='faq'" class="w-full rounded-sm border border-charcoal/10 px-3 py-2 text-left text-sm hover:border-forest">Project information</button>
            <button @click="step='title'" class="w-full rounded-sm border border-charcoal/10 px-3 py-2 text-left text-sm hover:border-forest">Title & process questions</button>
            <button @click="journey='site_visit'; step='lead'" class="w-full rounded-sm border border-charcoal/10 px-3 py-2 text-left text-sm hover:border-forest">Book a site visit</button>
            <button @click="journey='financing'; step='lead'" class="w-full rounded-sm border border-charcoal/10 px-3 py-2 text-left text-sm hover:border-forest">Pricing & financing</button>
            <a href="{{ $settings->whatsappUrl() }}" target="_blank" class="block w-full rounded-sm bg-[#25D366] px-3 py-2 text-center text-sm text-white">Chat on WhatsApp</a>
        </div>
        <div class="p-4" x-show="step === 'faq'">
            @foreach($faqs as $faq)
                <details class="mb-2 text-sm"><summary class="cursor-pointer font-medium">{{ $faq->question }}</summary><p class="mt-1 text-muted">{{ $faq->answer }}</p></details>
            @endforeach
            <button @click="step='menu'" class="mt-2 text-sm text-forest">← Back</button>
        </div>
        <div x-show="step === 'title'" class="p-4 text-sm text-muted">
            <p>Every Acremann project comes with verified documentation and a transparent conveyancing process. Our team guides you from reservation to title registration.</p>
            <a href="{{ route('faqs') }}" class="mt-2 inline-block text-forest">View all FAQs →</a>
            <button @click="step='menu'" class="mt-3 block text-sm text-forest">← Back</button>
        </div>
        <form x-show="step === 'lead'" @submit.prevent="submitLead" class="acremann-form space-y-3 p-4">
            <input type="text" x-model="form.name" placeholder="Your name" class="form-control" required>
            <input type="tel" x-model="form.phone" placeholder="Phone" class="form-control" required>
            <input type="email" x-model="form.email" placeholder="Email (optional)" class="form-control">
            <textarea x-model="form.message" placeholder="Message" class="form-control" rows="3"></textarea>
            <label class="form-check"><input type="checkbox" x-model="form.consent" required class="form-check-input"><span class="form-check-label">I consent to Acremann contacting me.</span></label>
            <button type="submit" class="btn btn-primary w-full">Submit</button>
            <p x-show="submitted" class="text-sm text-forest">Thank you! We'll be in touch.</p>
        </form>
    </div>
</div>
@push('scripts')
<script>
function chatbot() {
    return {
        open: false, step: 'menu', journey: 'general', submitted: false,
        form: { name: '', phone: '', email: '', message: '', consent: false },
        async submitLead() {
            await fetch('{{ route('chatbot.store') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ ...this.form, journey: this.journey, consent_callback: this.form.consent ? '1' : '' })
            });
            this.submitted = true;
        }
    }
}
</script>
@endpush


