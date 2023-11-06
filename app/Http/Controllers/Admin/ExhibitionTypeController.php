<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateExhibitionTypeRequest;
use App\Http\Requests\UpdateExhibitionTypeRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\ExhibitionTypeRepository;
use Illuminate\Http\Request;
use Flash;

class ExhibitionTypeController extends AppBaseController
{
    /** @var ExhibitionTypeRepository $exhibitionTypeRepository*/
    private $exhibitionTypeRepository;

    public function __construct(ExhibitionTypeRepository $exhibitionTypeRepo)
    {
        $this->middleware('permission:read exhibitiontype|create exhibitiontype|update exhibitiontype|delete exhibitiontype', ['only' => ['index','store']]);
        $this->middleware('permission:create exhibitiontype', ['only' => ['create','store']]);
        $this->middleware('permission:update exhibitiontype', ['only' => ['edit','update']]);
        $this->middleware('permission:delete exhibitiontype', ['only' => ['destroy']]);
        $this->exhibitionTypeRepository = $exhibitionTypeRepo;
    }

    /**
     * Display a listing of the ExhibitionType.
     */
    public function index(Request $request)
    {
        $exhibitionTypes = $this->exhibitionTypeRepository->paginate(10);

        return view('admin.exhibition_types.index')
            ->with('exhibitionTypes', $exhibitionTypes);
    }

    /**
     * Show the form for creating a new ExhibitionType.
     */
    public function create()
    {
        return view('admin.exhibition_types.create');
    }

    /**
     * Store a newly created ExhibitionType in storage.
     */
    public function store(CreateExhibitionTypeRequest $request)
    {
        $input = $request->all();

        $exhibitionType = $this->exhibitionTypeRepository->create($input);

        Flash::success('Exhibition Type saved successfully.');

        return redirect(route('admin.exhibitionTypes.index'));
    }

    /**
     * Display the specified ExhibitionType.
     */
    public function show($id)
    {
        $exhibitionType = $this->exhibitionTypeRepository->find($id);

        if (empty($exhibitionType)) {
            Flash::error('Exhibition Type not found');

            return redirect(route('admin.exhibitionTypes.index'));
        }

        return view('admin.exhibition_types.show')->with('exhibitionType', $exhibitionType);
    }

    /**
     * Show the form for editing the specified ExhibitionType.
     */
    public function edit($id)
    {
        $exhibitionType = $this->exhibitionTypeRepository->find($id);

        if (empty($exhibitionType)) {
            Flash::error('Exhibition Type not found');

            return redirect(route('admin.exhibitionTypes.index'));
        }

        return view('admin.exhibition_types.edit')->with('exhibitionType', $exhibitionType);
    }

    /**
     * Update the specified ExhibitionType in storage.
     */
    public function update($id, UpdateExhibitionTypeRequest $request)
    {
        $exhibitionType = $this->exhibitionTypeRepository->find($id);

        if (empty($exhibitionType)) {
            Flash::error('Exhibition Type not found');

            return redirect(route('admin.exhibitionTypes.index'));
        }

        $exhibitionType = $this->exhibitionTypeRepository->update($request->all(), $id);

        Flash::success('Exhibition Type updated successfully.');

        return redirect(route('admin.exhibitionTypes.index'));
    }

    /**
     * Remove the specified ExhibitionType from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $exhibitionType = $this->exhibitionTypeRepository->find($id);

        if (empty($exhibitionType)) {
            Flash::error('Exhibition Type not found');

            return redirect(route('admin.exhibitionTypes.index'));
        }

        $this->exhibitionTypeRepository->delete($id);

        Flash::success('Exhibition Type deleted successfully.');

        return redirect(route('admin.exhibitionTypes.index'));
    }
}
