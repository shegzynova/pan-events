<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateAbstractRequest;
use App\Http\Requests\UpdateAbstractRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Attendance;
use App\Notifications\AbstractApprovalNotification;
use App\Repositories\Admin\AbstractRepository;
use Illuminate\Http\Request;
use Flash;

class AbstractController extends AppBaseController
{
    /** @var AbstractRepository $abstractRepository*/
    private $abstractRepository;

    public function __construct(AbstractRepository $abstractRepo)
    {
        $this->middleware('permission:read abstractmodel|create abstractmodel|update abstractmodel|delete abstractmodel', ['only' => ['index','store']]);
        $this->middleware('permission:create abstractmodel', ['only' => ['create','store']]);
        $this->middleware('permission:update abstractmodel', ['only' => ['edit','update']]);
        $this->middleware('permission:delete abstractmodel', ['only' => ['destroy']]);
        $this->abstractRepository = $abstractRepo;
    }

    /**
     * Display a listing of the Abstract.
     */
    public function index(Request $request)
    {
        $abstracts = $this->abstractRepository->latest()->paginate(10);

        return view('admin.abstracts.index')
            ->with('abstracts', $abstracts);
    }

    /**
     * Show the form for creating a new Abstract.
     */
    public function create()
    {
        $raw_attendances = Attendance::latest('id')->get();
        $attendances = [];

        foreach ($raw_attendances as $attendance) {
            $attendances[] = optional(optional($attendance)->user)->first_name. ' for'. $attendance->event->title;
        }

        return view('admin.abstracts.create', compact('attendances'));
    }

    /**
     * Store a newly created Abstract in storage.
     */
    public function store(CreateAbstractRequest $request)
    {
        $input = $request->all();

        $abstract = $this->abstractRepository->create($input);

        Flash::success('Abstract saved successfully.');

        return redirect(route('admin.abstracts.index'));
    }

    /**
     * Display the specified Abstract.
     */
    public function show($id)
    {
        $abstract = $this->abstractRepository->find($id);

        if (empty($abstract)) {
            Flash::error('Abstract not found');

            return redirect(route('admin.abstracts.index'));
        }

        return view('admin.abstracts.show')->with('abstract', $abstract);
    }

    /**
     * Show the form for editing the specified Abstract.
     */
    public function edit($id)
    {
        $abstract = $this->abstractRepository->find($id);

        if (empty($abstract)) {
            Flash::error('Abstract not found');

            return redirect(route('admin.abstracts.index'));
        }

        $raw_attendances = Attendance::latest('id')->get();
        $attendances = [];

        foreach ($raw_attendances as $attendance) {
            $attendances[] = optional(optional($attendance)->user)->first_name. ' for'. $attendance->event->title;
        }

        return view('admin.abstracts.edit', compact('attendances'))->with('abstract', $abstract);
    }

    /**
     * Update the specified Abstract in storage.
     */
    public function update($id, UpdateAbstractRequest $request)
    {
        $abstract = $this->abstractRepository->find($id);

        if (empty($abstract)) {
            Flash::error('Abstract not found');

            return redirect(route('admin.abstracts.index'));
        }

        $abstract = $this->abstractRepository->update($request->all(), $id);

        Flash::success('Abstract updated successfully.');

        return redirect(route('admin.abstracts.index'));
    }

    /**
     * Remove the specified Abstract from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $abstract = $this->abstractRepository->find($id);

        if (empty($abstract)) {
            Flash::error('Abstract not found');

            return redirect(route('admin.abstracts.index'));
        }

        $this->abstractRepository->delete($id);

        Flash::success('Abstract deleted successfully.');

        return redirect(route('admin.abstracts.index'));
    }

    public function approve($id)
    {
        $abstract = $this->abstractRepository->find($id);

        $abstract->status = 'a';
        $abstract->save();

        //Send Email
        $attendance = Attendance::whereId($abstract->attendance_id)->first();

        if(!is_null($attendance)){
             $data = [
                 'name' => 'Abstract',
                 'type' => 'Approved',
                 'message' => 'You can now proceed to upload your full paper',
                 'abstract_id' => $abstract->id
             ];

             $attendance->user->notify(new AbstractApprovalNotification($data));

        }

        return redirect()->route('admin.abstracts.show', $id)->with('success', 'Abstract Successfully Approved');
    }

    public function decline($id)
    {
        $abstract = $this->abstractRepository->find($id);

        $abstract->status = 'd';
        $abstract->save();

        //Send Email
        $attendance = Attendance::whereId($abstract->attendance_id)->first();

        if(!is_null($attendance)){
            $data = [
                'name' => 'Abstract',
                'type' => 'Declined',
                'message' => 'Please review and re-upload',
                'abstract_id' => $abstract->id
            ];

            $attendance->user->notify(new AbstractApprovalNotification($data));

        }

        return redirect()->route('admin.abstracts.show', $id)->with('success', 'Abstract Successfully Declined');
    }

    public function approve_full_paper($id)
    {
        $abstract = $this->abstractRepository->find($id);

        $abstract->full_paper_status = 'a';
        $abstract->save();

        //Send Email
        $attendance = Attendance::whereId($abstract->attendance_id)->first();

        if(!is_null($attendance)){
            $data = [
                'name' => 'Full Paper',
                'type' => 'Approved',
                'message' => 'You can now proceed to upload your Presentation',
                'abstract_id' => $abstract->id
            ];

            $attendance->user->notify(new AbstractApprovalNotification($data));

        }

        return redirect()->route('admin.abstracts.show', $id)->with('success', 'Full Paper Successfully Approved');
    }

    public function decline_full_paper($id)
    {
        $abstract = $this->abstractRepository->find($id);

        $abstract->full_paper_status = 'd';
        $abstract->save();

        //Send Email
        $attendance = Attendance::whereId($abstract->attendance_id)->first();

        if(!is_null($attendance)){
            $data = [
                'name' => 'Full Paper',
                'type' => 'Declined',
                'message' => 'Please review and re-upload',
                'abstract_id' => $abstract->id
            ];

            $attendance->user->notify(new AbstractApprovalNotification($data));

        }

        return redirect()->route('admin.abstracts.show', $id)->with('success', 'Full Paper Successfully Declined');
    }

    public function approve_presentation($id)
    {
        $abstract = $this->abstractRepository->find($id);

        $abstract->presentation_status = 'a';
        $abstract->save();

        //Send Email
        $attendance = Attendance::whereId($abstract->attendance_id)->first();

        if(!is_null($attendance)){
            $data = [
                'name' => 'Presentation',
                'type' => 'Approved',
                'message' => 'We are happy to have you with us',
                'abstract_id' => $abstract->id
            ];

            $attendance->user->notify(new AbstractApprovalNotification($data));

        }

        return redirect()->route('admin.abstracts.show', $id)->with('success', 'Presentation Successfully Approved');
    }

    public function decline_presentation($id)
    {
        $abstract = $this->abstractRepository->find($id);

        $abstract->presentation_status = 'd';
        $abstract->save();

        //Send Email
        $attendance = Attendance::whereId($abstract->attendance_id)->first();

        if(!is_null($attendance)){
            $data = [
                'name' => 'Presentation',
                'type' => 'Declined',
                'message' => 'Please review and re-upload',
                'abstract_id' => $abstract->id
            ];

            $attendance->user->notify(new AbstractApprovalNotification($data));

        }

        return redirect()->route('admin.abstracts.show', $id)->with('success', 'Presentation Successfully Declined');
    }
}
