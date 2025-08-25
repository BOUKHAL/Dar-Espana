@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-capstone-yellow focus:ring-capstone-yellow focus:ring-2 rounded-lg shadow-sm px-4 py-3 w-full transition duration-200 ease-in-out bg-gray-50 focus:bg-white']) }}>
