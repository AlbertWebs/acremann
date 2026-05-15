@props(['settings'])
<div x-data="cookieConsent()" x-show="show" x-cloak class="fixed inset-x-0 bottom-0 z-[60] border-t border-charcoal/10 bg-white p-4 shadow-2xl md:p-6">
    <div class="container-site">
        <p class="text-sm font-medium">We value your privacy</p>
        <p class="mt-1 text-xs text-muted">We use cookies for necessary site functions, analytics, and marketing. <a href="{{ route('privacy') }}" class="underline">Privacy notice</a></p>
        <div x-show="!manage" class="mt-4 flex flex-wrap gap-2">
            <button @click="acceptAll()" class="btn-primary text-xs">Accept all</button>
            <button @click="rejectNonEssential()" class="btn-outline text-xs">Reject non-essential</button>
            <button @click="manage = true" class="text-xs underline">Manage preferences</button>
        </div>
        <div x-show="manage" class="mt-4 space-y-3 text-sm">
            <label class="flex items-center gap-2"><input type="checkbox" checked disabled> Necessary (required)</label>
            <label class="flex items-center gap-2"><input type="checkbox" x-model="prefs.analytics"> Analytics</label>
            <label class="flex items-center gap-2"><input type="checkbox" x-model="prefs.marketing"> Marketing</label>
            <button @click="savePrefs()" class="btn-primary text-xs">Save preferences</button>
        </div>
    </div>
</div>
@push('scripts')
<script>
function cookieConsent() {
    const stored = localStorage.getItem('acremann_cookies');
    return {
        show: !stored, manage: false,
        prefs: { analytics: false, marketing: false },
        init() { if (stored) this.loadScripts(JSON.parse(stored)); },
        acceptAll() { this.save({ analytics: true, marketing: true }); },
        rejectNonEssential() { this.save({ analytics: false, marketing: false }); },
        savePrefs() { this.save(this.prefs); },
        save(prefs) {
            localStorage.setItem('acremann_cookies', JSON.stringify(prefs));
            this.loadScripts(prefs);
            this.show = false;
        },
        loadScripts(prefs) {
            @if($settings->gtm_container_id)
            if (prefs.analytics || prefs.marketing) {
                (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});
                var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;
                j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','{{ $settings->gtm_container_id }}');
            }
            @endif
            @if($settings->meta_pixel_id)
            if (prefs.marketing) {
                !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');
                fbq('init','{{ $settings->meta_pixel_id }}');fbq('track','PageView');
            }
            @endif
        }
    }
}
</script>
@endpush


