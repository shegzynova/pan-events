<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Event;
use App\Repositories\Admin\HotelRepository;
use Illuminate\Http\Request;
use Flash;

class HotelController extends AppBaseController
{
    /** @var HotelRepository $hotelRepository*/
    private $hotelRepository;

    public function __construct(HotelRepository $hotelRepo)
    {
        $this->middleware('permission:read hotel|create hotel|update hotel|delete hotel', ['only' => ['index','store']]);
        $this->middleware('permission:create hotel', ['only' => ['create','store']]);
        $this->middleware('permission:update hotel', ['only' => ['edit','update']]);
        $this->middleware('permission:delete hotel', ['only' => ['destroy']]);
        $this->hotelRepository = $hotelRepo;
    }

    /**
     * Display a listing of the Hotel.
     */
    public function index(Request $request)
    {
        $hotels = $this->hotelRepository->latest('id')->paginate(10);

        return view('admin.hotels.index')
            ->with('hotels', $hotels);
    }

    /**
     * Show the form for creating a new Hotel.
     */
    public function create()
    {
        $events = Event::latest('id')->pluck('title', 'id')->toArray();

        return view('admin.hotels.create', compact('events'));
    }

    /**
     * Store a newly created Hotel in storage.
     */
    public function store(CreateHotelRequest $request)
    {
        $input = $request->all();

        $hotel = $this->hotelRepository->create($input);

        Flash::success('Hotel saved successfully.');

        return redirect(route('admin.hotels.index'));
    }

    /**
     * Display the specified Hotel.
     */
    public function show($id)
    {
        $hotel = $this->hotelRepository->find($id);

        if (empty($hotel)) {
            Flash::error('Hotel not found');

            return redirect(route('admin.hotels.index'));
        }

        return view('admin.hotels.show')->with('hotel', $hotel);
    }

    /**
     * Show the form for editing the specified Hotel.
     */
    public function edit($id)
    {
        $hotel = $this->hotelRepository->find($id);

        if (empty($hotel)) {
            Flash::error('Hotel not found');

            return redirect(route('admin.hotels.index'));
        }

        return view('admin.hotels.edit')->with('hotel', $hotel);
    }

    /**
     * Update the specified Hotel in storage.
     */
    public function update($id, UpdateHotelRequest $request)
    {
        $hotel = $this->hotelRepository->find($id);

        if (empty($hotel)) {
            Flash::error('Hotel not found');

            return redirect(route('admin.hotels.index'));
        }

        $hotel = $this->hotelRepository->update($request->all(), $id);

        Flash::success('Hotel updated successfully.');

        return redirect(route('admin.hotels.index'));
    }

    /**
     * Remove the specified Hotel from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $hotel = $this->hotelRepository->find($id);

        if (empty($hotel)) {
            Flash::error('Hotel not found');

            return redirect(route('admin.hotels.index'));
        }

        $this->hotelRepository->delete($id);

        Flash::success('Hotel deleted successfully.');

        return redirect(route('admin.hotels.index'));
    }
}
