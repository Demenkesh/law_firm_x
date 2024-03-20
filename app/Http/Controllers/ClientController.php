<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Mail\Mails;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Client::query();
        if ($request->filled('filter')) {
            $filterValue = $request->filter;
            if ($filterValue == "last_name") {
                $query->orderBy('last_name');
            }
        }
        $client = $query->paginate(10);
        return view('welcome', compact('client'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('client_add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'first_Name' => 'required',
                'last_Name' => 'required',
                'email' => 'required|email|unique:clients,email',
                'primary_legal_counsel' => 'required',
                'date_of_birth' => 'required',
                'date_profiled' => 'required',
                // 'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
                'case_details' => 'required',
            ]);

            if ($request->hasFile('image')) {
                $validator = Validator::make($request->all(), [
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
            }

            if ($validator->stopOnFirstFailure()->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()[0],
                ]);
            }
            $client = new Client();
            $client->first_name = $request->input('first_Name');
            $client->last_name = $request->input('last_Name');
            $client->email = $request->input('email');
            $client->primary_legal_counsel = $request->input('primary_legal_counsel');
            $client->date_of_birth = $request->input('date_of_birth');
            $client->case_details = $request->input('case_details');
            $client->date_profiled = $request->input('date_profiled');
            $client->withoutimage = '3';

            if ($request->hasFile('image') ?? '') {
            $uploadPath = 'assets/uploads/client/';
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move($uploadPath, $filename);
            $client->profile_image = $uploadPath . $filename;
            }

            $APP_NAME = env('APP_NAME');
            $mail = [
                'title' => 'Welcome',
                'name' => $request->input('first_Name'),
                'subject' => 'Welcome to' . $APP_NAME,
                'email' =>  $request->input('email'),
            ];
            $mail['message'] = "Hello, " . $mail['name'] . " , you are welcome to " . $APP_NAME . ",we are here to serve you better 🥳🍾.";
            Mail::to($mail['email'])->send(new Mails($mail));
            $client->save();
            DB::commit();
            return response()->json(['message' => "Welcome  "  .   $client->first_name]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' =>  $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        return view('client_edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'first_Name' => 'required',
                'last_Name' => 'required',
                'email' => 'required',
                'primary_legal_counsel' => 'required',
                'date_of_birth' => 'required',
                'date_profiled' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'case_details' => 'required',
            ]);

            if ($validator->stopOnFirstFailure()->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()[0],
                ]);
            }
            $validatedData = $validator->validated();
            $id = $validatedData['id'];
            $client = Client::findOrFail($id);
            $client->first_name = $request->input('first_Name');
            $client->last_name = $request->input('last_Name');
            $client->email = $request->input('email');
            $client->primary_legal_counsel = $request->input('primary_legal_counsel');
            $client->date_of_birth = $request->input('date_of_birth');
            $client->case_details = $request->input('case_details');
            $client->date_profiled = $request->input('date_profiled');

            if ($request->hasFile('image')) {
                $uploadPath = 'assets/uploads/client/';
                $path = 'assets/uploads/client/' . $client->profile_image;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;
                $file->move('assets/uploads/client/', $filename);
                $client->profile_image = $uploadPath . $filename;
            }
            $client->update();
            DB::commit();
            return redirect('/')->with(['message' => "you have updated your profile  "  .   $client->first_name]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with(['error' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * get client with out image from storage.
     */


    public function withoutimage()
    {
        // Get all clients
        $clients = Client::all();
        $errors = [];

        foreach ($clients as $client) {

            if ($client->profile_image !== null) {
                // Skip clients with profile images
                continue;
            }

            // Check if 24 hours have passed since registration
            $registrationDate = $client->updated_at;
            $currentDate = Carbon::now();
            $hoursDifference = $currentDate->diffInHours($registrationDate);

            if ($hoursDifference >= 24) {
                // Subtract 1 from withoutimage column
                $client->withoutimage -= 1;
                $client->save();

                // Check if withoutimage is now zero
                if ($client->withoutimage <= 0) {
                    $url = url('/get_client/' . $client->id);
                    // Send mail to the client
                    $APP_NAME = env('APP_NAME');

                    $mail = [
                        'title' => 'Update your passport with ' . $APP_NAME,
                        'note' => 'Please kindly update your passport photograph with ' . $APP_NAME,
                        'subject' => 'Update your passport with ' . $APP_NAME,
                        'email' =>  $client->email,
                        'name' =>  $client->first_name,
                        'url' => $url,
                    ];
                    $mail['message'] = "Hello, " . $mail['name'] . ", " . $mail['note'];
                    Mail::to($mail['email'])->send(new Mails($mail));

                    // Reset withoutimage to 3 for the next cycle
                    $client->withoutimage = 3;
                    $client->save();
                }
            } else {
                $errors[] = 'Client ' . $client->id . ': 24 hours have not passed since registration.';
            }
        }

        if (empty($errors)) {

            if ($client->withoutimage <= 0) {
                return response()->json(['message' => 'still yet to know some client to update their image.']);
            } else {
                return response()->json(['message' => 'All client images updated successfully.']);
            }
        } else {
            return response()->json(['errors' => $errors]);
        }
    }
}
