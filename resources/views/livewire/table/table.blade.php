<div>
    <div class="overflow-scroll">
        @include('livewire.table.hidden-dropdown')

        <table class="w-full">
            <thead class="border-b {{ app()->getLocale() == 'fa' ? 'text-right' : 'text-left' }}">
                <tr>
                    @foreach ($columns as $key => $column)
                        @if (isset($column['hidden']) && $column['hidden'])
                            @continue
                        @endif
                        <th class="text-sm font-medium text-gray-900 px-6 py-4 cursor-pointer">
                            {{ $column['remark'] }}
                        </th>
                    @endforeach

                    @if (count($actions) > 1)
                        <th class="text-sm font-medium text-gray-900 px-6 py-4">
                            *
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody class='{{ app()->getLocale() == 'fa' ? 'text-right' : 'text-left' }}'>
                @foreach ($datas as $data)
                    <tr class="border-b hover:bg-gray-50 transition duration-75">
                        @foreach ($columns as $key => $column)
                            @if (isset($column['hidden']) && $column['hidden'])
                                @continue
                            @endif
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                @if (isset($column['callback']))
                                    {{ unserialize($column['callback'])->getClosure()($data) }}
                                @else
                                    {{ $data->{$key} }}
                                @endif
                            </td>
                        @endforeach

                        @if (count($actions) > 0)
                            <td
                                class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap flex items-center space-x-1">
                                @foreach ($actions as $key => $value)
                                    {!! unserialize($value)->getClosure()($data) !!}
                                @endforeach
                                {{-- <button wire:click="deleteModel({{ $data->id }})"
                                    class="btn btn-sm {{ $data->id == $selected_id ? 'btn-danger' : 'btn-warning' }}">
                                    <ion-icon class="hydrated" name="trash-outline"></ion-icon>
                                </button> --}}
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $datas->links() }}
    </div>
</div>
