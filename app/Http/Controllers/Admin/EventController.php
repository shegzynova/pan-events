<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Mail\CertificateMail;
use App\Mail\CPDMail;
use App\Models\Event;
use App\Models\EventUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read event|create event|update event|delete event', ['only' => ['index','store']]);
        $this->middleware('permission:create event', ['only' => ['create','store']]);
        $this->middleware('permission:update event', ['only' => ['edit','update']]);
        $this->middleware('permission:delete event', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest()->get();

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEventRequest $request)
    {
        $eventData = $request->validated();
        if ($request->hasFile('image')) {
            $imagePath = $this->saveEventImage($request->file('image'));
            $eventData['image'] = $imagePath;
        }

        $eventData['is_published'] = $request->is_published == 'on' ? true : false;
        $eventData['slug'] = Str::slug(strtolower($eventData['title']), '_');
        $eventData['date'] = Carbon::createFromFormat('d M, Y', $request->input('date'))->toDateString();
        $eventData['unique_id'] = Str::uuid();

        $event = Event::create($eventData);

        if ($event) {
            return Redirect::route('admin.events.index')->with('success', 'Event created successfully!');
        }

        return back()->withErrors('Event creation failed. Please try again.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('admin.events.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $eventData = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $this->saveEventImage($request->file('image'));
            $eventData['image'] = $imagePath;
        }

        $eventData['is_published'] = $request->is_published == 'on' ? true : false;
        $eventData['date'] = Carbon::createFromFormat('d M, Y', $request->input('date'))->toDateString();

        if ($event->update($eventData)) {
            return Redirect::route('admin.events.index')->with('success', 'Event updated successfully!');
        }

        return back()->withErrors('Event update failed. Please try again.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully!');
    }

    private function saveEventImage(UploadedFile $image): string
    {
        $imagePath = $image->store('events', 'public');
        return Storage::disk('public')->url($imagePath);
    }

    public function publish(Request $request, Event $event)
    {
        $event->is_published = $request->input('is_published') == 'on' ? true : false;
        $event->save();

        return response()->json(['success' => true]);
    }

    public function certificate(Request $request, $type)
    {
        if (!in_array($type, ['coa', 'cpd']) && $request->selectedIds != '') {
            return redirect()->back()->with('error', 'Wrong Certificate Selected');
        }

        $eventUsers = EventUser::whereIn('id', explode(',', $request->selectedIds))->get();

        foreach ($eventUsers as $user) {
            $event = Event::whereId($user->event_id)->first();

            $imagePath = ($type == 'cpd') ? base_path('pan_cpd_template.png') : base_path('certificate-of-attendance-template.png');
            $image = file_get_contents($imagePath);
            $destinationPath = ($type == 'cpd') ? 'certificates/cpd/' : 'certificates/attendance/';
            $imageName = time() . '-' . (($type == 'cpd') ? 'cpd' : 'certificate-of-attendance') . '-for-' . $user->surname . '.png';


            $image = Image::make($image);
            $destinationPath = public_path($destinationPath);

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            if ($type == 'coa') {
                $image->text($user->first_name . ' ' . $user->surname, 1200, 880, function ($font) {
                    $font->file(base_path('Roboto-Regular.ttf'));
                    $font->size(100);
                    $font->color('#000000');
                    $font->align('center');
                    $font->valign('bottom');
                    $font->angle(0);
                });
            } else {
                $first = '1. Name: ' . $user->first_name . ' ' . $user->surname;
                $image->text($first, 100, 300, function ($font) {
                    $font->file(base_path('Roboto-Regular.ttf'));
                    $font->size(25);
                    $font->color('#000000');
                    $font->align('left');
                    $font->valign('bottom');
                    $font->angle(0);
                });

                $second = '2. Folio Number: _______________________  Address: ' . $user->city . ' ' . optional($user->state_name)->name . ' ' . optional($user->country)->name;
                $image->text($second, 100, 340, function ($font) {
                    $font->file(base_path('Roboto-Regular.ttf'));
                    $font->size(25);
                    $font->color('#000000');
                    $font->align('left');
                    $font->valign('bottom');
                    $font->angle(0);
                });

                $third = '3. Telephone: ' . $user->phone_number . '        Email Address: ' . $user->email;
                $image->text($third, 100, 380, function ($font) {
                    $font->file(base_path('Roboto-Regular.ttf'));
                    $font->size(25);
                    $font->color('#000000');
                    $font->align('left');
                    $font->valign('bottom');
                    $font->angle(0);
                });

                $four = '4. Qualification: (with dates and institutions, MCDN Reg. No)';
                $image->text($four, 100, 420, function ($font) {
                    $font->file(base_path('Roboto-Regular.ttf'));
                    $font->size(25);
                    $font->color('#000000');
                    $font->align('left');
                    $font->valign('bottom');
                    $font->angle(0);
                });

                $five = 'Basic: ___________________________  Additional: _____________________________';
                $image->text($five, 100, 520, function ($font) {
                    $font->file(base_path('Roboto-Regular.ttf'));
                    $font->size(25);
                    $font->color('#000000');
                    $font->align('left');
                    $font->valign('bottom');
                    $font->angle(0);
                });

            }

            $image->save($destinationPath . $imageName);

            $emailData = [
                'certificate' => $destinationPath . $imageName,
                'first_name' => $user->first_name,
                'event' => optional($event)->title
            ];
            if ($type == 'cpd') {
                Mail::to($user->email)
                    ->send(new CPDMail($emailData));
            } else {
                Mail::to($user->email)
                    ->send(new CertificateMail($emailData));
            }

        }

        return redirect()->back()->with('success', 'Certificate Sent');

    }
}
