<x-dashboard-layout :title="__('Menus')">
    <div class="card">
        <div class="card-header">
            <div class="card-title text-primary flex-space-2">
                <i class="icon fg-plus"></i>
                <span>{{ __('Create menu') }}</span>
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('dashboard.menus.store') }}">
                @csrf
                <div class="input-group sm {{ css_classes(['error' => $errors->has('name')]) }}">
                    <input type="text" name="name"
                        class="form-control {{ css_classes(['error' => $errors->has('name')]) }}"
                        placeholder="{{ __('Menu name') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="icon fg-plus"></i>
                        <span>{{ __('Create') }}</span>
                    </button>
                </div>
                <fgx:error id="name" />
                <fgx:status soft size="xs" class="mt-2" />
            </form>
        </div>
    </div>
    <div class="card mt-4">
        <fgx:status id="delete_status" soft size="xs" class="m-3" />
        <div class="table-container">
            <table class="table table-striped table-divide sm">
                <thead>
                    <tr>
                        <th>{{ __('Id') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Position') }}</th>
                        <th>{{ __('Class name') }}</th>
                        <th>{{ __('Items') }}</th>
                        <th>{{ __('Created at') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($menus && $menus->isNotEmpty())
                        @foreach ($menus as $menu)
                            <tr>
                                <td>{{ $menu->id }}</td>
                                <td>{{ $menu->name }}</td>
                                <td>{{ $menu->position }}</td>
                                <td>{{ $menu->class_name }}</td>
                                <td>{{ $menu->items()->count() }}</td>
                                <td>{{ $menu->created_at->format('d, M Y') }}</td>
                                <td>
                                    <div class="flex-space-2">
                                        <a href="{{ route('dashboard.menus.edit', $menu) }}"
                                            title="{{ __('Edit') }}" class="">
                                            <i class="icon bi-pencil-square"></i>
                                        </a>
                                        <a href="{{ route('dashboard.menus.delete', $menu) }}"
                                            title="{{ __('Delete') }}" class="">
                                            <i class="icon bi-trash-fill"></i>
                                        </a>
                                    </div>

                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">{{ __('No items found') }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @if ($menus && $menus->isNotEmpty())
            <div class="mt-3">
                {{ $menus->links() }}
            </div>
        @endif
    </div>
</x-dashboard-layout>
