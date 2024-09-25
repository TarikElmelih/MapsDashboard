<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>  

        <!-- Code -->
        <div class="mt-4">
            <x-input-label for="code" :value="__('Code')" />
            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code')" required autocomplete="code" />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <!-- Training -->
        <div class="mt-4">
            <x-input-label for="training" :value="__('Training')" />
            <select id="training" class="block mt-1 w-full" name="training" required>
                <option value="Backend">Backend</option>
                <option value="Frontend">Frontend</option>
                <option value="UI/UX">UI/UX</option>
                <option value="Graphic Design">Graphic Design</option>
            </select>
            <x-input-error :messages="$errors->get('training')" class="mt-2" />
        </div>

        <!-- Trainer -->
        <div class="mt-4">
            <x-input-label for="trainer" :value="__('Trainer')" />
            <select id="trainer" class="block mt-1 w-full" name="trainer" required>
                <option value="Huzaifa">Huzaifa</option>
                <option value="Omar">Omar</option>
                <option value="Shorook">Shorook</option>
                <option value="Sultan">Sultan</option>
            </select>
            <x-input-error :messages="$errors->get('trainer')" class="mt-2" />
        </div>

        <!-- Facilitator -->
        <div class="mt-4">
            <x-input-label for="facilitator" :value="__('Facilitator')" />  
            <select id="facilitator" class="block mt-1 w-full" name="facilitator" required>
                <option value="Tarik Elmelih">Tarik Elmelih</option>
                <option value="Husien Alhassan">Husien Alhassan</option>
                <option value="Abdulbasit">Abdulbasit</option>
                <option value="Yahia Jaqmour">Yahia Jaqmour</option>
            </select>
            <x-input-error :messages="$errors->get('facilitator')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
