@if (session('success'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        x-init="setTimeout(() => show = false, 3000)"
        class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800"
    >
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M5 13l4 4L19 7"/>
                </svg>

                <span class="font-medium">
                    {{ session('success') }}
                </span>
            </div>

            <button
                type="button"
                @click="show = false"
                class="text-green-700 hover:text-green-900"
            >
                ✕
            </button>
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
        <div class="font-semibold mb-2">
            Please fix the following errors:
        </div>

        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif