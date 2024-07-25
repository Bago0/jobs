<x-layout>
    <x-page-heading>New Job</x-page-heading>

    <x-forms.form method="POST" action="/jobs">
        @csrf

        <x-forms.input label="Title" name="title" placeholder="CEO" />
        
        <x-forms.input label="Salary" name="salary" placeholder="$90,000 USD" type="number" step="0.01" />

        <x-forms.input label="Location" name="location" placeholder="Winter Park, Florida" />

        <x-forms.select label="Schedule" name="schedule">
            <option value="Part Time">Part Time</option>
            <option value="Full Time">Full Time</option>
        </x-forms.select>

        <x-forms.input label="URL" name="url" placeholder="https://acme.com/jobs/ceo-wanted" type="url" />

        <x-forms.input label="Expiration Date" name="expiration_date" placeholder="YYYY-MM-DD" type="date" />

        <x-forms.checkbox label="Feature (Costs Extra)" name="featured" />

        <x-forms.divider />

        <x-forms.input label="Tags (comma separated)" name="tags" placeholder="laracasts, video, education" />

        <x-forms.button>Publish</x-forms.button>
    </x-forms.form>
</x-layout>
