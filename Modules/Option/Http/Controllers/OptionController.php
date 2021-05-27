<?php

namespace Modules\Option\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Option\Entities\Option;

class OptionController extends Controller
{

    public function index(Request $request)
    {
        if (! checkGate('manage_options') ) abort(403);

        if (class_exists('\SEO')) \SEO::setTitle(__('Manage options'));
        return view('option::index');
    }

    public function handle(Request $request) {
        if (! checkGate('manage_options') ) abort(403);

        $request->validate([
            'name'=> ['required'],
        ]);
        if ($request->method == 'store') {
            return $this->store($request->all());
        } elseif ($request->method == 'update') {
            $request->validate([
                'option_id'=> ['required', 'exists:option__options,id']
            ]);
            return $this->update($request->all());
        }

        return response()->json(['result'=> true, 'message'=> __('Incorrect method!')]);
    }

    protected function store($data) {
        if (! checkGate('manage_options') ) abort(403);

        Option::create([
            'tag'=> $data['tag'],
            'name'=> $data['name'],
            'data'=> $data['data'] ?? ''
        ]);
        return response()->json(['result'=> true, 'message'=> __('Option created successfully.')]);
    }
    protected function update($data) {
        if (! checkGate('manage_options') ) abort(403);

        $r = update_option(intval($data['option_id']), [
            'name'=> $data['name'],
            'data'=> $data['data'] ?? ''
        ]);

        if (!$r)
            return response()->json(['result'=> false, 'message'=> "The option not updated during an unknown error!"], 400);

        return response()->json(['result'=> true, 'message'=> __('Option updated successfully.')]);
    }

    public function delete(Option $option) {
        if (! checkGate('manage_options') ) abort(403);

        $option->delete();
        return response()->json([
            'result'=> true,
            'message'=> __('Option deleted successfully.')
        ]);
    }
}
