<x-layout>
    @auth
        <x-page-heading>Apply for {{ $job->title }}</x-page-heading>

        <x-forms.form method="POST" action="{{ route('jobs.storeApplication', $job->id) }}" enctype="multipart/form-data">
            @csrf

            <x-forms.input label="Name" name="name" placeholder="John" />
            
            <x-forms.input label="Surname" name="surname" placeholder="Doe" />

            <x-forms.input label="Email" name="email" type="email" placeholder="john.doe@example.com" />

            <x-forms.input label="Upload CV" name="cv" type="file" />

            <x-forms.textarea label="Motivational Letter" name="motivational_letter" placeholder="Write your motivational letter here..." rows="6" />

            <x-forms.button>Submit Application</x-forms.button>
        </x-forms.form>
    @else
        <p class="text-center text-red-600">You must be logged in to apply for a job.</p>
    @endauth
</x-layout>
