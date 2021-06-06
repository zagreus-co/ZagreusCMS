@extends(panelLayout())

@section('content')

<div class="grid grid-cols-1 gap-6 xl:grid-cols-1">
    
    @panelView('errors-alert')

    <div class="card hidden" id='disallow_page'>
        <div class="card-header">{{ __("Disallow a page") }}</div>
        <div class="card-body">
            <form action="" method="post">
                @csrf
                <input type="hidden" name="name" value="disallow_page">
                <div class="form-group">
                    <label for="page_url">{{__("Page url")}}:</label>
                    <input type="text" name="data" placeholder='/livewire/*' class="form-control">
                </div>

                <div class="flex justify-end">
                    <button class="btn-success mt-4">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header flex justify-between">
            <strong class="pt-2">{{ __('Disallowed pages for analytic') }}</strong>
            <button onclick='document.querySelector("#disallow_page").classList.toggle("hidden")' class="btn p-2 px-3 btn-bs-secondary">{{__('Create')}}</button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse">
                <thead class="">
                    <tr class="bg-gray-800 text-white text-lg">
                        <th class="px-16 py-2 font-5">{{__('Name')}}</th>
                        <th class="px-16 py-2 font-5">{{__('Data')}}</th>
                        <th class="px-16 py-2">#</th>
                    </tr>
                </thead>
                <tbody class="text-lg">
                    @foreach($rule->whereName('disallow_page')->orderBy('id', 'desc')->get() as $row)
                    <tr class="bg-white border-4 border-gray-200">
                        <td class="px-16 py-2">{{ $row->name }}</td>
                        <td class="px-16 py-2">{{ $row->data }}</td>
                        <td class="px-16 py-2">
                            <button class="btn-danger p-2">X</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection