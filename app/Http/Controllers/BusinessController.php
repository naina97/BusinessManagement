<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    
    public function index()
    {
        $businesses = Business::with('branches')->get();
        return view('businesses.index', compact('businesses'));
    }

    
    public function create()
    {
        return view('businesses.add_businesses');

    }

   
    public function store(Request $request)
    {
        // dd($request->all());
        $validationRule    = [];
        $validationMessage = [];

        $validationRule = [
            'business_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
        ];
        
        $validationMessage = [
            'business_name.required'  => 'Business name is required.',
            'business_name.string'    => 'Business name must be a valid text.',
            'email.required' => 'Email is required.',
            'email.email'    => 'Please enter a valid email address.',
            'phone.required' => 'Phone number is required.',
            'phone.numeric'  => 'Phone number must contain only numbers.',
        ];
      
        $validatedData     = $request->validate($validationRule, $validationMessage);
        try {
            // Create a new business instance
            $business = new Business();
            $business->name = $request->business_name;
            $business->email = $request->email;
            $business->phone = $request->phone;
    
            // Handle logo upload
            if ($request->hasFile('logo')) {
                $customPath = "businesses/logos"; 
                //C:\wamp64\www\BusinessManagement\storage\app\public\businesses\logos
                $logoPath = $request->file('logo')->store($customPath,'public');
                $business->logo = $logoPath;
            }
       
            if ($business->save()) {
                return redirect()->route('businesses.index')->with('success', 'Business added successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to add business.');
            }
    
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Business creation failed: ' . $e->getMessage());
        }
               
    }

    
    public function show(Business $business)
    {
       
    }

    
    public function edit(Business $business)
    {
        
    }

    
    public function update(Request $request, Business $business)
    {
       
    }

    
    public function destroy(Business $business)
    {
        $business->delete();
        return redirect()->back()->with('success', 'Business deleted!');
    }
}
