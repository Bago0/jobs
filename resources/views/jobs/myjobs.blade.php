<x-layout>
    <div class="space-y-10">
        <section class="pt-10">
            <x-section-heading>Featured Jobs</x-section-heading>

            <div class="grid lg:grid-cols-3 gap-8 mt-6">
                @foreach($featuredJobs as $job)
                    <x-job-card :$job />
                @endforeach
            </div>
        </section>
        <section>
            <x-section-heading>Ordinary jobs</x-section-heading>
            <div class="mt-6 space-y-6">
                @foreach($jobs as $job)
                    <x-job-card-wide :$job />
                @endforeach
            </div>
        </section>
    </div>
</x-layout>
