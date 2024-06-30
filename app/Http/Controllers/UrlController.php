<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UrlController extends Controller
{
    //
    public function create(Request $request){
        try {
            DB::beginTransaction();
                $validator = Validator::make($request->all(), [
                    'url' => ['required', 'url']
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $data = $validator->validated();
                $data['code'] = Url::generateCode(6);
                $url = Url::create($data);
            DB::commit();
            return redirect()->back()->with('success', 'URL shortened successfully!')->with('url_path',url('/short-url/' . $url->code));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'server error');
        }

    }

    public function redirectUrl($code){
        $url = Url::where('code', $code)->first();
        if (!$url) {
            abort(404);
        }
        return redirect($url->url);
    }
    public function update(Request $request,$id){
        try {
            DB::beginTransaction();
                $request->validate([
                    'code' => ['required','string','min:6',Rule::unique('urls')->where(function ($query) use ($id) {
                        return $query->where('id', '!=', $id)->whereNull('deleted_at');
                    })],
                ]);
                $url = Url::find($id);
                if (!$url) {
                    return redirect()->back()->with('error', 'URL not found.');
                }
                $url->code = $request->input('code');
                $url->save();
            DB::commit();
            return redirect()->back()->with('success', 'URL updated successfully.');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function delete($id){
        try {
            DB::beginTransaction();
                $url = Url::find($id);
                if (!$url) {
                    return redirect()->back()->with('error', 'URL not found.');
                }
                $url->delete();
            DB::commit();
            return redirect()->back()->with('success', 'delete URL success!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
