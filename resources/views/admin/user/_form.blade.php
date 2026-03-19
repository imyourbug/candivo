@php
    $isEdit = isset($user) && $user;
    $verifiedChecked = old('mark_verified') !== null
        ? old('mark_verified') == '1'
        : (bool) ($isEdit && $user->email_verified_at);
@endphp
<div class="space-y-6">
    <div>
        <label for="name" class="block text-xs font-semibold text-slate-500 mb-1">Full name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" required maxlength="255"
            class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none" />
        @error('name')
            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="email" class="block text-xs font-semibold text-slate-500 mb-1">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" required maxlength="255"
            class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none" />
        @error('email')
            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="password" class="block text-xs font-semibold text-slate-500 mb-1">
            Password
            @if($isEdit)
                <span class="font-normal text-slate-400">(leave blank to keep current)</span>
            @endif
        </label>
        <input type="password" name="password" id="password" {{ $isEdit ? '' : 'required' }} autocomplete="new-password"
            class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none" />
        @error('password')
            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="password_confirmation" class="block text-xs font-semibold text-slate-500 mb-1">Confirm password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" {{ $isEdit ? '' : 'required' }} autocomplete="new-password"
            class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none" />
        @error('password_confirmation')
            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
        @enderror
    </div>
    <div class="flex items-start gap-3">
        <input type="hidden" name="mark_verified" value="0" />
        <input type="checkbox" name="mark_verified" id="mark_verified" value="1"
            class="mt-1 rounded border-slate-300 text-primary focus:ring-primary"
            @checked($verifiedChecked) />
        <div>
            <label for="mark_verified" class="text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">Email verified</label>
            <p class="text-xs text-slate-500 mt-0.5">Treat this address as verified for admin logins (optional).</p>
        </div>
    </div>
</div>
