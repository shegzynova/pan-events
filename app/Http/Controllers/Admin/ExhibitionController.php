<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateExhibitionRequest;
use App\Http\Requests\UpdateExhibitionRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\ExhibitionType;
use App\Repositories\Admin\ExhibitionRepository;
use Illuminate\Http\Request;
use Flash;

class ExhibitionController extends AppBaseController
{
    /** @var ExhibitionRepository $exhibitionRepository*/
    private $exhibitionRepository;

    public function __construct(ExhibitionRepository $exhibitionRepo)
    {
        $this->middleware('permission:read exhibition|create exhibition|update exhibition|delete exhibition', ['only' => ['index','store']]);
        $this->middleware('permission:create exhibition', ['only' => ['create','store']]);
        $this->middleware('permission:update exhibition', ['only' => ['edit','update']]);
        $this->middleware('permission:delete exhibition', ['only' => ['destroy']]);
        $this->exhibitionRepository = $exhibitionRepo;
    }

    /**
     * Display a listing of the Exhibition.
     */
    public function index(Request $request)
    {
        $exhibitions = $this->exhibitionRepository->paginate(10);

        return view('admin.exhibitions.index')
            ->with('exhibitions', $exhibitions);
    }

    /**
     * Show the form for creating a new Exhibition.
     */
    public function create()
    {
        $exhibition_types = ExhibitionType::latest('id')->pluck('type', 'id')->toArray();
        return view('admin.exhibitions.create', compact('exhibition_types'));
    }

    /**
     * Store a newly created Exhibition in storage.
     */
    public function store(CreateExhibitionRequest $request)
    {
        $input = $request->all();

        $exhibition = $this->exhibitionRepository->create($input);

        Flash::success('Exhibition saved successfully.');

        return redirect(route('admin.exhibitions.index'));
    }

    /**
     * Display the specified Exhibition.
     */
    public function show($id)
    {
        $exhibition = $this->exhibitionRepository->find($id);

        if (empty($exhibition)) {
            Flash::error('Exhibition not found');

            return redirect(route('admin.exhibitions.index'));
        }

        return view('admin.exhibitions.show')->with('exhibition', $exhibition);
    }

    /**
     * Show the form for editing the specified Exhibition.
     */
    public function edit($id)
    {
        $exhibition = $this->exhibitionRepository->find($id);

        if (empty($exhibition)) {
            Flash::error('Exhibition not found');

            return redirect(route('admin.exhibitions.index'));
        }
        $exhibition_types = ExhibitionType::latest('id')->pluck('type', 'id')->toArray();

        return view('admin.exhibitions.edit')->with('exhibition', $exhibition)->with('exhibition_types', $exhibition_types);
    }

    /**
     * Update the specified Exhibition in storage.
     */
    public function update($id, UpdateExhibitionRequest $request)
    {
        $exhibition = $this->exhibitionRepository->find($id);

        if (empty($exhibition)) {
            Flash::error('Exhibition not found');

            return redirect(route('admin.exhibitions.index'));
        }

        $exhibition = $this->exhibitionRepository->update($request->all(), $id);

        Flash::success('Exhibition updated successfully.');

        return redirect(route('admin.exhibitions.index'));
    }

    /**
     * Remove the specified Exhibition from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $exhibition = $this->exhibitionRepository->find($id);

        if (empty($exhibition)) {
            Flash::error('Exhibition not found');

            return redirect(route('admin.exhibitions.index'));
        }

        $this->exhibitionRepository->delete($id);

        Flash::success('Exhibition deleted successfully.');

        return redirect(route('admin.exhibitions.index'));
    }
}
