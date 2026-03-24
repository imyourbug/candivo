@extends('layouts.main')

@section('title', 'Contact Us - Di-tool')

@push('styles')
    <style type="text/tailwindcss">
        .contact-submit-btn {
            background: linear-gradient(135deg, var(--accent-blue), #004AEE);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 102, 255, 0.35);
        }

        .contact-submit-btn:hover {
            box-shadow: 0 6px 25px rgba(0, 102, 255, 0.5);
            transform: translateY(-1px);
        }
    </style>
@endpush

@section('content')
    <section class="relative w-full h-[500px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-slate-900/60 z-10"></div>
        <div class="absolute inset-0 bg-cover bg-center"
            style='background-image: url("{{ asset('images/contact-us.jpg') }}");'>
        </div>
        <div class="container mx-auto px-6 relative z-20 text-left max-w-4xl">
            <h1 class="text-white text-4xl md:text-6xl font-black leading-tight tracking-[-0.033em] mb-6">
                Contact Our Engineering Team
            </h1>
            <p class="text-white/90 text-lg md:text-xl font-normal leading-relaxed mb-8 max-w-2xl text-left">
                Reach out for product support, licensing questions, and tailored automation consultation.
            </p>
            <a href="#contact-form"
                class="bg-[#1e79dc] text-white px-8 py-4 rounded-lg font-bold text-lg hover:brightness-110 transition-all shadow-lg inline-flex items-center">
                Send Us a Message
            </a>
        </div>
    </section>

    <section id="contact-form" class="py-16 md:py-24 bg-[#d7e2ed]">
        <div class="container mx-auto px-6 max-w-[900px]">
            <div class="bg-white p-8 md:p-10 rounded-2xl border border-slate-200 shadow-sm">
                @if (session('success'))
                    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif
                @include('components.contact-us-form')
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (function() {
            var $form = $('#contactInquiryForm');
            var $btn = $('#contactSubmitBtn');
            if (!$form.length || !$btn.length) return;

            var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            function clearClientErrors() {
                $form.find('[data-contact-field-wrap]').each(function() {
                    var $wrap = $(this);
                    var name = $wrap.data('contact-field-wrap');
                    $wrap.find('.contact-client-error[data-contact-client-error="' + name + '"]').addClass('hidden').text('');
                    $wrap.find('.contact-form-input').removeClass('border-red-500 ring-1 ring-red-500');
                });
            }

            function setFieldError(field, message) {
                var $wrap = $form.find('[data-contact-field-wrap="' + field + '"]');
                var $err = $wrap.find('.contact-client-error[data-contact-client-error="' + field + '"]');
                var $input = $wrap.find('.contact-form-input');
                if (message) {
                    $err.text(message).removeClass('hidden');
                    $input.addClass('border-red-500 ring-1 ring-red-500');
                } else {
                    $err.addClass('hidden').text('');
                    $input.removeClass('border-red-500 ring-1 ring-red-500');
                }
            }

            function validateContactForm() {
                clearClientErrors();
                var ok = true;

                var fullName = String($form.find('[name="full_name"]').val() || '').trim();
                if (fullName.length > 120) {
                    setFieldError('full_name', 'Name must be at most 120 characters.');
                    ok = false;
                }

                var email = String($form.find('[name="email"]').val() || '').trim();
                if (!email) {
                    setFieldError('email', 'Please enter your email address.');
                    ok = false;
                } else if (!emailRe.test(email)) {
                    setFieldError('email', 'Please enter a valid email address.');
                    ok = false;
                } else if (email.length > 190) {
                    setFieldError('email', 'Email must be at most 190 characters.');
                    ok = false;
                }

                var subject = String($form.find('[name="subject"]').val() || '').trim();
                if (!subject) {
                    setFieldError('subject', 'Please enter a subject.');
                    ok = false;
                } else if (subject.length > 190) {
                    setFieldError('subject', 'Subject must be at most 190 characters.');
                    ok = false;
                }

                var message = String($form.find('[name="message"]').val() || '').trim();
                if (!message) {
                    setFieldError('message', 'Please enter your message.');
                    ok = false;
                } else if (message.length > 4000) {
                    setFieldError('message', 'Message must be at most 4000 characters.');
                    ok = false;
                }

                return ok;
            }

            function setSubmitLoading(loading) {
                if (loading) {
                    $btn.prop('disabled', true);
                    $btn.find('.contact-submit-label').addClass('hidden');
                    $btn.find('.contact-submit-loading').removeClass('hidden').addClass('flex');
                } else {
                    $btn.prop('disabled', false);
                    $btn.find('.contact-submit-label').removeClass('hidden');
                    $btn.find('.contact-submit-loading').addClass('hidden').removeClass('flex');
                }
            }

            $form.on('submit', function(e) {
                if (!validateContactForm()) {
                    e.preventDefault();
                    var $firstErr = $form.find('.contact-client-error:not(.hidden)').first();
                    if ($firstErr.length) {
                        var el = $firstErr[0];
                        if (el.scrollIntoView) el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }
                    return;
                }
                setSubmitLoading(true);
            });

            $form.on('input change', '.contact-form-input', function() {
                var $input = $(this);
                var name = $input.attr('name');
                if (!name) return;
                setFieldError(name, '');
            });
        })();
    </script>
@endpush
