<x-curve-layout :title="__('Rich select')">
    <div class="max-w-4xl mx-auto p-6 space-y-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Rich Select Component Examples</h1>

        <!-- Basic Single Select -->
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Basic Single Select</h2>
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Country</label>
                    <x-rich-select
                        name="country"
                        placeholder="Choose a country..."
                        :options="[
                            ['value' => 'us', 'label' => 'United States', 'description' => 'North America'],
                            ['value' => 'ca', 'label' => 'Canada', 'description' => 'North America'],
                            ['value' => 'uk', 'label' => 'United Kingdom', 'description' => 'Europe'],
                            ['value' => 'de', 'label' => 'Germany', 'description' => 'Europe'],
                            ['value' => 'fr', 'label' => 'France', 'description' => 'Europe'],
                            ['value' => 'jp', 'label' => 'Japan', 'description' => 'Asia'],
                            ['value' => 'au', 'label' => 'Australia', 'description' => 'Oceania'],
                        ]"
                        selected="us" />
                </div>
            </form>
        </div>

        <!-- Multiple Select -->
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Multiple Select</h2>
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Categories</label>
                    <x-rich-select
                        name="categories[]"
                        placeholder="Choose categories..."
                        :options="[
                            ['value' => 'tech', 'label' => 'Technology'],
                            ['value' => 'design', 'label' => 'Design'],
                            ['value' => 'marketing', 'label' => 'Marketing'],
                            ['value' => 'business', 'label' => 'Business'],
                            ['value' => 'lifestyle', 'label' => 'Lifestyle'],
                            ['value' => 'travel', 'label' => 'Travel'],
                            ['value' => 'food', 'label' => 'Food & Cooking'],
                        ]"
                        :selected="['tech', 'design']"
                        :multiple="true"
                        maxItems="5" />
                </div>
            </form>
        </div>

        <!-- AJAX Search Example -->
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">AJAX Search</h2>
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search Users</label>
                    <x-rich-select
                        name="user"
                        placeholder="Search for a user..."
                        searchPlaceholder="Type to search users..."
                        ajaxUrl="/api/users/search"
                        :ajaxParams="['limit' => 10]"
                        minSearchLength="2"
                        debounceMs="500" />
                </div>
            </form>
        </div>

        <!-- Disabled State -->
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Disabled State</h2>
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Disabled Select</label>
                    <x-rich-select
                        name="disabled_select"
                        placeholder="This is disabled..."
                        :options="[
                            ['value' => 'option1', 'label' => 'Option 1'],
                            ['value' => 'option2', 'label' => 'Option 2'],
                        ]"
                        :disabled="true" />
                </div>
            </form>
        </div>

        <!-- With Error State -->
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Error State</h2>
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select with Error</label>
                    <x-rich-select
                        name="error_select"
                        placeholder="Choose an option..."
                        :options="[
                            ['value' => 'option1', 'label' => 'Option 1'],
                            ['value' => 'option2', 'label' => 'Option 2'],
                        ]"
                        error="This field is required"
                        helpText="Please select an option to continue" />
                </div>
            </form>
        </div>

        <!-- Non-searchable Select -->
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Non-searchable Select</h2>
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Simple Dropdown</label>
                    <x-rich-select
                        name="simple_select"
                        placeholder="Choose an option..."
                        :options="[
                            ['value' => 'yes', 'label' => 'Yes'],
                            ['value' => 'no', 'label' => 'No'],
                            ['value' => 'maybe', 'label' => 'Maybe'],
                        ]"
                        :searchable="false" />
                </div>
            </form>
        </div>

        <!-- Non-clearable Select -->
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Non-clearable Select</h2>
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Required Field</label>
                    <x-rich-select
                        name="required_select"
                        placeholder="This field is required..."
                        :options="[
                            ['value' => 'option1', 'label' => 'Option 1'],
                            ['value' => 'option2', 'label' => 'Option 2'],
                            ['value' => 'option3', 'label' => 'Option 3'],
                        ]"
                        :clearable="false"
                        :required="true" />
                </div>
            </form>
        </div>
    </div>
    @livewireScripts
    <script>
        // Example of how to handle form submission
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');

            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    const data = {};

                    for (let [key, value] of formData.entries()) {
                        if (key.includes('[]')) {
                            // Handle array inputs
                            const arrayKey = key.replace('[]', '');
                            if (!data[arrayKey]) {
                                data[arrayKey] = [];
                            }
                            try {
                                const parsedValue = JSON.parse(value);
                                data[arrayKey] = Array.isArray(parsedValue) ? parsedValue : [
                                    parsedValue
                                ];
                            } catch {
                                data[arrayKey] = [value];
                            }
                        } else {
                            data[key] = value;
                        }
                    }

                    console.log('Form data:', data);
                    alert('Form submitted! Check console for data.');
                });
            });
        });
    </script>
</x-curve-layout>
