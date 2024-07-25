@props(['label', 'name', 'placeholder' => '', 'rows' => 3])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    @endif
    <textarea name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder }}" rows="{{ $rows }}" class="mt-1 block w-full border border-gray-600 rounded-md shadow-sm bg-black text-white placeholder-gray-400 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"></textarea>
    @error($name) <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
</div>
