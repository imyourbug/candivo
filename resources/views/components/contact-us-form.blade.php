<h3 class="text-2xl font-bold text-slate-900 tracking-tight mb-8">Technical Inquiry Form</h3>
<form id="contactInquiryForm" class="space-y-6" method="POST" action="{{ route('contact-us.send') }}" novalidate>
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-1.5" data-contact-field-wrap="full_name">
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300" for="contact_full_name">Full Name</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">person</span>
            <input id="contact_full_name" name="full_name"
                class="contact-form-input w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-slate-900 dark:text-slate-100 placeholder:text-slate-400"
                placeholder="John Doe" type="text" value="{{ old('full_name') }}" autocomplete="name" maxlength="120" />
            </div>
            <p class="contact-client-error hidden text-xs text-red-600 mt-1" data-contact-client-error="full_name" role="alert"></p>
            @error('full_name')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="space-y-1.5" data-contact-field-wrap="email">
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300" for="contact_email">Email Address</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">mail</span>
            <input id="contact_email" name="email"
                class="contact-form-input w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-slate-900 dark:text-slate-100 placeholder:text-slate-400"
                placeholder="j.doe@precision.com" type="email" value="{{ old('email') }}" autocomplete="email" maxlength="190" required />
            </div>
            <p class="contact-client-error hidden text-xs text-red-600 mt-1" data-contact-client-error="email" role="alert"></p>
            @error('email')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="space-y-1.5" data-contact-field-wrap="subject">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300" for="contact_subject">Subject</label>
        <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">title</span>
        <input id="contact_subject" name="subject"
            class="contact-form-input w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-slate-900 dark:text-slate-100 placeholder:text-slate-400"
            placeholder="Inquiry about Di-tool Systems" type="text" value="{{ old('subject') }}" maxlength="190" required />
        </div>
        <p class="contact-client-error hidden text-xs text-red-600 mt-1" data-contact-client-error="subject" role="alert"></p>
        @error('subject')
            <p class="text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>
    <div class="space-y-1.5" data-contact-field-wrap="message">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300" for="contact_message">Message</label>
        <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-3 text-slate-400 text-xl">description</span>
        <textarea id="contact_message" name="message"
            class="contact-form-input w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-slate-900 dark:text-slate-100 placeholder:text-slate-400 resize-none"
            placeholder="Describe your technical requirements..." rows="5" maxlength="4000" required>{{ old('message') }}</textarea>
        </div>
        <p class="contact-client-error hidden text-xs text-red-600 mt-1" data-contact-client-error="message" role="alert"></p>
        @error('message')
            <p class="text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>
    <button id="contactSubmitBtn"
        class="contact-submit-btn w-full text-white font-bold py-4 rounded-lg transition-all flex items-center justify-center gap-2 group disabled:opacity-70 disabled:cursor-not-allowed disabled:hover:transform-none"
        type="submit">
        <span class="contact-submit-label inline-flex items-center justify-center gap-2">
            <span>Submit Inquiry</span>
            <span class="material-symbols-outlined text-xl group-hover:translate-x-1 transition-transform">arrow_forward</span>
        </span>
        <span class="contact-submit-loading hidden items-center justify-center gap-2" aria-hidden="true">
            <span class="material-symbols-outlined text-xl animate-spin">progress_activity</span>
            <span>Sending…</span>
        </span>
    </button>
</form>
