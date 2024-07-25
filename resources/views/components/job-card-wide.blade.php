@props(['job'])

<x-panel class="flex gap-x-6">
    <div>
        <x-employer-logo :employer="$job->employer" />
    </div>

    <div class="flex-1 flex flex-col">
        <a href="#" class="self-start text-sm text-gray-400 transition-colors duration-300">{{ $job->employer->name }}</a>

        <h3 class="font-bold text-xl mt-3 group-hover:text-blue-800">
            <a href="{{ $job->url }}" target="_blank">
                {{ $job->title }}
            </a>
        </h3>

        <p class="text-sm text-gray-400 mt-auto">{{ $job->salary }}</p>
    </div>
    @auth
        @if (Auth::id() !== $job->employer_id)
            <a href="{{ route('jobs.apply', $job->id) }}" class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded">
                Apply
            </a>
        @endif
    @endauth
    <div>
        @foreach($job->tags as $tag)
            <x-tag :$tag />
        @endforeach
    </div>
</x-panel>
