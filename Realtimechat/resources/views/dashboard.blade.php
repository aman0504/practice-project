<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    <br><br>
                    <div>
                        <form action="{{route('profileImage')}}" method="post" enctype="multipart/form-data">
                            @csrf
                    <label> Upload Profile image </label> <br>
                    <input type="file" name="image">
                    <button type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div>
                @if($image)
                {{-- to show first image --}}
                <img src="{{ asset($user->getFirstMediaUrl('image')) }}" style="max-width: 100px;">
                <br>
                <br>
                {{-- to show last image --}}
                <img src="{{ asset($image->getUrl()) }}" style="max-width: 100px;">
                    @endif

            </div>
        </div>
    </div>
</x-app-layout>
