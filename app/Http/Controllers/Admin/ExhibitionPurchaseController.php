<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateExhibitionPurchaseRequest;
use App\Http\Requests\UpdateExhibitionPurchaseRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Attendance;
use App\Models\Exhibition;
use App\Models\ExhibitionType;
use App\Repositories\Admin\ExhibitionPurchaseRepository;
use Illuminate\Http\Request;
use Flash;

class ExhibitionPurchaseController extends AppBaseController
{
    /** @var ExhibitionPurchaseRepository $exhibitionPurchaseRepository*/
    private $exhibitionPurchaseRepository;

    public function __construct(ExhibitionPurchaseRepository $exhibitionPurchaseRepo)
    {
        $this->middleware('permission:read exhibitionpurchase|create exhibitionpurchase|update exhibitionpurchase|delete exhibitionpurchase', ['only' => ['index','store']]);
        $this->middleware('permission:create exhibitionpurchase', ['only' => ['create','store']]);
        $this->middleware('permission:update exhibitionpurchase', ['only' => ['edit','update']]);
        $this->middleware('permission:delete exhibitionpurchase', ['only' => ['destroy']]);
        $this->exhibitionPurchaseRepository = $exhibitionPurchaseRepo;
    }

    /**
     * Display a listing of the ExhibitionPurchase.
     */
    public function index(Request $request)
    {
        $exhibitionPurchases = $this->exhibitionPurchaseRepository->paginate(10);

        return view('admin.exhibition_purchases.index')
            ->with('exhibitionPurchases', $exhibitionPurchases);
    }

    /**
     * Show the form for creating a new ExhibitionPurchase.
     */
    public function create()
    {
        $exhibition_types = ExhibitionType::with('exhibitions')->get();
        $raw_attendances = Attendance::latest('id')->get();
        $attendances = [];

        foreach ($raw_attendances as $attendance) {
            $attendances[$attendance->id] = optional(optional($attendance)->user)->first_name. ' for '. $attendance->event->title;
        }

        return view('admin.exhibition_purchases.create', compact('attendances', 'exhibition_types'));
    }

    /**
     * Store a newly created ExhibitionPurchase in storage.
     */
    public function store(CreateExhibitionPurchaseRequest $request)
    {
        $input = $request->all();
        $exhibitions = $input['exhibition'];
        $input['paid'] = $input['paid'] == 'on' ? 'paid' : 'unpaid';


        foreach ($exhibitions AS $exhibition){
            $input['exhibition_id'] = $exhibition;
            $exhibitionPurchase = $this->exhibitionPurchaseRepository->create($input);
            $this->updateExhibitionAmount($exhibitionPurchase, $exhibition);
        }


        Flash::success('Exhibition Purchase saved successfully.');

        return redirect(route('admin.exhibitionPurchases.index'));
    }

    public function updateExhibitionAmount($exhibitionPurchase, $exhibitionId)
    {
        $exhibition = Exhibition::find($exhibitionId);
        if ($exhibition) {
            $exhibitionPurchase->total_amount = $exhibition->amount;
            $exhibitionPurchase->save();
        }

    }

    /**
     * Display the specified ExhibitionPurchase.
     */
    public function show($id)
    {
        $exhibitionPurchase = $this->exhibitionPurchaseRepository->find($id);

        if (empty($exhibitionPurchase)) {
            Flash::error('Exhibition Purchase not found');

            return redirect(route('admin.exhibitionPurchases.index'));
        }

        return view('admin.exhibition_purchases.show')->with('exhibitionPurchase', $exhibitionPurchase);
    }

    /**
     * Show the form for editing the specified ExhibitionPurchase.
     */
    public function edit($id)
    {
        $exhibitionPurchase = $this->exhibitionPurchaseRepository->find($id);

        if (empty($exhibitionPurchase)) {
            Flash::error('Exhibition Purchase not found');

            return redirect(route('admin.exhibitionPurchases.index'));
        }

        $exhibition_types = ExhibitionType::with('exhibitions')->get();
        $raw_attendances = Attendance::latest('id')->get();
        $attendances = [];

        foreach ($raw_attendances as $attendance) {
            $attendances[] = optional(optional($attendance)->user)->full_name. ' for '. optional(optional($attendance)->event)->title;
        }


        return view('admin.exhibition_purchases.edit', compact('attendances', 'exhibition_types'))->with('exhibitionPurchase', $exhibitionPurchase);
    }

    /**
     * Update the specified ExhibitionPurchase in storage.
     */
    public function update($id, UpdateExhibitionPurchaseRequest $request)
    {
        $exhibitionPurchase = $this->exhibitionPurchaseRepository->find($id);

        if (empty($exhibitionPurchase)) {
            Flash::error('Exhibition Purchase not found');

            return redirect(route('admin.exhibitionPurchases.index'));
        }

        $data = $request->all();
        $data['paid'] = $data['paid'] == 'on' ? 'paid' : 'unpaid';

        $exhibitions = $data['exhibition'];

        if(!empty($exhibitions)){
            foreach ($exhibitions AS $exhibition){
                if(!empty($exhibitions)){
                    $data['exhibition_id'] = $exhibition;
                }
                $exhibitionPurchase = $this->exhibitionPurchaseRepository->update($data, $id);
                $this->updateExhibitionAmount($exhibitionPurchase, $exhibition);
            }
        }else{
            $exhibitionPurchase = $this->exhibitionPurchaseRepository->update($data, $id);
            $this->updateExhibitionAmount($exhibitionPurchase, $exhibitions);
        }


        Flash::success('Exhibition Purchase updated successfully.');

        return redirect(route('admin.exhibitionPurchases.index'));
    }

    /**
     * Remove the specified ExhibitionPurchase from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $exhibitionPurchase = $this->exhibitionPurchaseRepository->find($id);

        if (empty($exhibitionPurchase)) {
            Flash::error('Exhibition Purchase not found');

            return redirect(route('admin.exhibitionPurchases.index'));
        }

        $this->exhibitionPurchaseRepository->delete($id);

        Flash::success('Exhibition Purchase deleted successfully.');

        return redirect(route('admin.exhibitionPurchases.index'));
    }
}
