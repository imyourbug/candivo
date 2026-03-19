@extends('admin.layout-guest')

@section('title', 'Di-tool Admin Login')

@push('admin-styles')
    <style>
        .circuit-bg {
            background-image: radial-gradient(circle at 2px 2px, rgba(19, 127, 236, 0.05) 1px, transparent 0);
            background-size: 24px 24px;
        }
    </style>
@endpush

@section('main-class', 'circuit-bg')

@section('content')
    <div class="w-full max-w-md">
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-2xl border border-slate-200 dark:border-slate-800 p-8 md:p-10">
            <div class="text-center mb-10">
                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4 border border-primary/20">
                    <span class="material-symbols-outlined text-primary text-3xl">precision_manufacturing</span>
                </div>
                <h1 class="text-2xl font-black text-slate-900 dark:text-slate-100 mb-2">Welcome Back</h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm">Sign in to the high-tech engineering portal</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-500/10 border border-red-500/20 text-red-600 dark:text-red-400 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form id="admin-login-form" method="POST" action="{{ route('admin.login') }}" class="space-y-6" novalidate>
                @csrf
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300" for="email">Email Address</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-4 text-slate-400 text-[20px]">mail</span>
                        <input
                            class="w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none @error('email') border-red-500 @enderror"
                            id="email"
                            name="email"
                            type="text"
                            inputmode="email"
                            value="{{ old('email') }}"
                            placeholder="e.g. admin@di-tool.com"
                            autocomplete="email"
                            autofocus
                        />
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300" for="password">Password</label>
                        <a class="text-xs font-medium text-primary hover:underline" href="#">Forgot password?</a>
                    </div>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-4 text-slate-400 text-[20px]">lock</span>
                        <input
                            class="w-full pl-11 pr-12 py-3.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none @error('password') border-red-500 @enderror"
                            id="password"
                            name="password"
                            type="password"
                            placeholder="••••••••"
                            autocomplete="current-password"
                        />
                        <button type="button" class="absolute right-4 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 toggle-password" aria-label="Toggle password visibility">
                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                        </button>
                    </div>
                </div>
                <div class="flex items-center">
                    <input
                        class="w-4 h-4 rounded border-slate-300 dark:border-slate-700 text-primary focus:ring-primary bg-white dark:bg-slate-800"
                        id="remember"
                        name="remember"
                        type="checkbox"
                    />
                    <label class="ml-2 text-sm text-slate-600 dark:text-slate-400 select-none" for="remember">Remember this device for 30 days</label>
                </div>
                <button
                    type="submit"
                    class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-lg shadow-lg shadow-primary/20 transition-all active:scale-[0.98] flex items-center justify-center gap-2"
                >
                    <span>Sign In to Dashboard</span>
                    <span class="material-symbols-outlined text-xl">login</span>
                </button>
            </form>
            <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800 text-center">
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    Don't have access? <a class="text-primary font-semibold hover:underline" href="#">Request an invite</a>
                </p>
            </div>
        </div>
        @include('admin.partials.guest-footer')
    </div>
@endsection

@push('admin-scripts')
<script>
    $(function() {
        $('.toggle-password').on('click', function() {
            const input = document.getElementById('password');
            const icon = $(this).find('.material-symbols-outlined')[0];
            if (!input || !icon) return;
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        });

        const $form = $('#admin-login-form');
        const $email = $('#email');
        const $password = $('#password');
        const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        function setLoginErr($field, msg) {
            $field.toggleClass('border-red-500', !!msg);
            const $wrap = $field.closest('.space-y-2');
            let $p = $wrap.find('.js-login-client-error');
            if (!$p.length) {
                $p = $('<p class="js-login-client-error text-sm text-red-500 mt-1"></p>');
                $wrap.append($p);
            }
            $p.text(msg || '');
            if (!msg) { $p.remove(); }
        }

        function validateLoginFields() {
            let ok = true;
            const em = ($email.val() || '').trim();
            if (!em) {
                setLoginErr($email, 'Email is required.');
                ok = false;
            } else if (!emailRe.test(em)) {
                setLoginErr($email, 'Please enter a valid email address.');
                ok = false;
            } else {
                setLoginErr($email, '');
            }
            const pw = $password.val() || '';
            if (!pw) {
                setLoginErr($password, 'Password is required.');
                ok = false;
            } else {
                setLoginErr($password, '');
            }
            return ok;
        }

        $email.on('input blur', function() {
            const em = ($email.val() || '').trim();
            if (!em) setLoginErr($email, 'Email is required.');
            else if (!emailRe.test(em)) setLoginErr($email, 'Please enter a valid email address.');
            else setLoginErr($email, '');
        });
        $password.on('input blur', function() {
            const pw = $password.val() || '';
            setLoginErr($password, pw ? '' : 'Password is required.');
        });

        $form.on('submit', function(e) {
            if (!validateLoginFields()) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
@endpush
