<x-app-layout>
    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-8">
        <h3 class="text-2xl font-semibold" style="color: #7F55E0; margin-bottom: 24px;">Update User</h3>
        <section>
            <form method="post" action="{{ route('admin.users.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                @csrf
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <span>{{$error}}</span>
                    @endforeach
                @endif
                <div>
                    <x-input-label for="skills" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="name"  :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" :value="old('email')" required autocomplete="email" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="password" />
                </div>

                <div class="mb-4">
                    <x-input-label for="role" :value="__('Role')" />
                    <select id="role" name="role" class="border border-gray-300 rounded px-4 py-2 w-full">
                        <option value="">Select Role</option>
                        @foreach(\App\Enums\UserRole::cases() as $status)
                            @if($status->value === 'admin')
                                @continue
                            @endif
                            <option value="{{ $status->value }}" {{ old('role') == $status->value ? 'selected' : '' }}>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="profile_image" :value="__('Profile Image')" />
                    <input type="file" name="profile_image" accept="image/*"
                           class="form-input mt-1 block w-full border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 rounded-md">
                </div>

                <div class="flex items-center gap-2">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                    <a href="{{route('admin.users.index')}}" class="py-1 px-4 bg-gray-200 rounded">Cancel</a>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>