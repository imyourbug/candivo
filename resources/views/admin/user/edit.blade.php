@extends('admin.layout')

@section('title', 'Edit user – Di-tool Admin')

@section('content')
    <header class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-slate-500 hover:text-primary font-medium mb-2 inline-flex items-center gap-1">
                <span class="material-symbols-outlined text-lg">arrow_back</span> Back to users
            </a>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Edit user</h2>
            <p class="text-slate-500 text-sm">{{ $user->name }} · {{ $user->email }}</p>
        </div>
    </header>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden max-w-xl">
        <form action="{{ route('admin.users.update', $user) }}" method="post" class="p-6 md:p-8">
            @csrf
            @method('PUT')
            @include('admin.user._form', ['user' => $user])
            <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800 flex flex-wrap items-center gap-3">
                <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-lg font-bold flex items-center gap-2 transition-all">
                    <span class="material-symbols-outlined text-xl">save</span>
                    Save changes
                </button>
                <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    Cancel
                </a>
                @if($user->id !== auth()->id())
                    <button type="submit" form="delete-user-form"
                        class="ml-auto px-6 py-2.5 rounded-lg border border-rose-200 dark:border-rose-900 text-rose-600 dark:text-rose-400 font-medium hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors">
                        Delete user
                    </button>
                @endif
            </div>
        </form>
        @if($user->id !== auth()->id())
            <form id="delete-user-form" action="{{ route('admin.users.destroy', $user) }}" method="post" class="hidden"
                onsubmit="return confirm('Delete this user? They will no longer be able to sign in.');">
                @csrf
                @method('DELETE')
            </form>
        @endif
    </div>
@endsection
