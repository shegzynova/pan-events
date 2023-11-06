<?php

namespace App\Http\Controllers;

use App\Http\Requests\FullPaperRequest;
use App\Models\AbstractModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbstractController extends Controller
{
    public function index()
    {
        $abstracts = AbstractModel::select('abstracts.*')->join('attendances as at', 'abstracts.attendance_id', '=', 'at.id')
            ->where('at.user_id', auth()->id())
            ->paginate(10);

        return view('user.abstracts.index', compact('abstracts'));
    }

    public function show($id)
    {
        $abstract = AbstractModel::whereId($id)->first();

        return view('user.abstracts.show', compact('abstract'));
    }

    public function fullPaper($id, Request $request)
    {
        $abstract = AbstractModel::find($id);

        if (!$abstract) {
            return redirect()->route('user.abstracts.show', $id)->with('error', 'Unable to find abstract');
        }

        if(!$request->hasFile('full_paper') && !$request->hasFile('presentation') && !$request->hasFile('abstract')){
            return redirect()->route('user.abstracts.show', $id)->with('error', 'Please select file');
        }

        if($request->hasFile('full_paper')){
            $file = $request->file('full_paper');

            if ($file && $file->isValid()) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('abstracts/full_paper/', $fileName, 'public');
                $abstract->full_paper = 'abstracts/full_paper/' . $fileName;
                $abstract->full_paper_status = 'p';
            }
        }

        if($request->hasFile('presentation')){
            $file = $request->file('presentation');

            if ($file && $file->isValid()) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('abstracts/presentation/', $fileName, 'public');
                $abstract->presentation = 'abstracts/presentation/' . $fileName;
                $abstract->presentation_status = 'p';
            }
        }

        if($request->hasFile('abstract')){
            $file = $request->file('abstract');

            if ($file && $file->isValid()) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = public_path('abstracts');
                $file->move($filePath, $fileName);

                $abstract->presentation = 'abstracts/'.$fileName;
                $abstract->status = 'p';
            }
        }

        $abstract->save();

        return redirect()->route('user.abstracts.show', $id)->with('success', 'File Successfully Uploaded');
    }
}
