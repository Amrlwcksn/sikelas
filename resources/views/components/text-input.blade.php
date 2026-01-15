@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-200 focus:border-blue-600 focus:ring-blue-600 rounded-xl shadow-sm bg-white transition-all']) }}>
