<!-- resources/views/applications/index.blade.php -->
<x-layout>
    <x-page-heading>Your Job Applications</x-page-heading>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Job Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Surname</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Motivational Letter</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">CV</th>
                </tr>
            </thead>
            <tbody class="bg-black divide-y divide-gray-200">
                @foreach($applications as $application)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ $application->job->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $application->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $application->surname }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $application->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                            @if(strlen($application->motivational_letter) > 100)
                                <div x-data="{ open: false }">
                                    <p x-show="!open" class="truncate">{{ Str::limit($application->motivational_letter, 100) }}</p>
                                    <button x-show="!open" @click="open = true" class="text-blue-600 hover:text-blue-800">Read More</button>
                                    <p x-show="open">{{ $application->motivational_letter }}</p>
                                    <button x-show="open" @click="open = false" class="text-blue-600 hover:text-blue-800">Show Less</button>
                                </div>
                            @else
                                {{ $application->motivational_letter }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                            @if(Auth::user()->id === $application->job->employer_id)
                            <a href="{{ route('applications.download-cv', $application->id) }}" class="text-blue-600 hover:text-blue-800">Download CV</a>
                        </td>
                            @else
                                <span class="text-gray-500">N/A</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
