<?php

namespace App\Http\Controllers\Panel\Contest;

use App\Http\Requests\ContestUpdateRequest;
use App\Models\Contest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContestController
{
    public function index()
    {
        return view('panel.contest.index', [
            'contests' => Contest::latest()->get()
        ]);
    }

    public function create()
    {
        $contest = Contest::create([
            'user_id' => Auth::id()
        ]);

        return redirect()->route('panel.contest.edit', $contest);
    }

    public function edit(Contest $contest)
    {
        return view('panel.contest.edit', ['contest' => $contest]);
    }

    public function update(ContestUpdateRequest $request, Contest $contest)
    {
        $contest->fill($request->all());
        $contest->save();
        if($request->image){
            $contest->addMedia($request->image)->usingName(md5_file($request->image->getRealPath()))
                ->usingFileName($request->image->hashName())->toMediaCollection('image');
        }
        return redirect()->back()->with('success', 'Конкурс успешно обновлён');

    }
}
