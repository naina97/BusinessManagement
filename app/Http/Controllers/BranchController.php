<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\Business;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::with('business')->get();
        return view('branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $businesses = Business::all();

        return view('branches.add_branch',compact('businesses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validationRule    = [];
        $validationMessage = [];

        $validationRule = [
            'business_id' => 'required|exists:businesses,id', // Removed extra space
            'branch_name' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Added file validation
            'schedule' => 'required|json',
            'exceptions' => 'nullable|json'
        ];
        
        $validationMessage = [
            'branch_name.required' => 'Branch name is required.',
            'branch_name.string'   => 'Branch name must be valid text.',
        ];
      
        $validatedData = $request->validate($validationRule, $validationMessage);
    
        try {
            $branch = new Branch();
            $branch->name = $request->branch_name;
            $branch->business_id = $request->business_id;
    
            $imagePaths = [];
            // Check if images exist in request
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = time() . '_' . $image->getClientOriginalName();
                    $path = $image->storeAs('branches/images', $filename, 'public'); // Store in storage/app/public/branches/images
                    $imagePaths[] = $path;
                }
            }
    
            // Store image paths as comma-separated values
            $branch->images = implode(',', $imagePaths);
            $branch->schedule = json_decode($request->schedule, true); 
            $branch->exceptions = $request->exceptions ? json_decode($request->exceptions, true) : null;
    
    
            if ($branch->save()) {
                return redirect()->route('branches.index')->with('success', 'Branch added successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to add branch.');
            }
    
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Branch creation failed: ' . $e->getMessage());
        }
       
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        $currentDay = date('l'); // Get current weekday
        $currentTime = date('H:i'); // Get current time in 24-hour format
    
        $schedule = $branch->schedule;
        $exceptions = $branch->exceptions;
    
        // Check if the current date is in the exceptions list
        $today = date('Y-m-d');
        if (isset($exceptions[$today])) {
            $isOpen = $exceptions[$today] === 'open' ? true : false;
        } else {
            $isOpen = false;
            if (isset($schedule[$currentDay])) {
                foreach ($schedule[$currentDay] as $slot) {
                    if ($currentTime >= $slot['start'] && $currentTime <= $slot['end']) {
                        $isOpen = true;
                        break;
                    }
                }
            }
        }
    
        return view('branches.show', compact('branch', 'schedule', 'exceptions', 'isOpen'));
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
      
        $branch->delete();
        return redirect()->back()->with('success', 'branch deleted!');
       
    }
}
